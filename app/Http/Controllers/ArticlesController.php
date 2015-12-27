<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Article;
use App\Vote;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class ArticlesController extends Controller
{
    // check authentication for create/edit pages using middleware
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'search']]);
    }


    /**
     * Display all articles home page, articles sorted by 'sortby' parameter
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Request::get('sortby') == 'mostviewed') {       // Sort by mostviewed
            $articles = Article::orderBy('view_count', 'DESC')->get();
            foreach ($articles as $article) {
                $article->votes = $this->getUpvotes($article->id) - $this->getDownvotes($article->id);
            }
        }

        else if (\Request::get('sortby') == 'toprated') {       // Sort by toprated
            $articles = Article::latest()->get();
            foreach ($articles as $article) {
                $article->votes = $this->getUpvotes($article->id) - $this->getDownvotes($article->id);
            }
            $articles = $articles->sortByDesc(function($article){
                return $article->votes;
            });
        }

        else {      // Sort by latest
            $articles = Article::latest()->get();
            foreach ($articles as $article) {
                $article->votes = $this->getUpvotes($article->id) - $this->getDownvotes($article->id);
            }
        }

        return view('articles.index', compact('articles'));
    }


    /**
     * to show a particular article
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($articleID)
    {
        $article = Article::find($articleID);
        if(is_null($article)) {
            abort(404);
        }

        // update view count
        $article->timestamps = false;
        $article->view_count = $article->view_count + 1;
        $article->save();
        $article->timestamps = true;

        // set rating attributes
        $article->upvotes = $this->getUpvotes($articleID);
        $article->downvotes = $this->getDownvotes($articleID);
        if(Auth::check()) {
            $article->user_has_voted = $this->userHasVoted($articleID);
            if($this->userHasVoted($articleID)) {
                $article->user_vote_value = $this->getUserVoteValue($articleID);
            }
        }

        return view('articles.show', compact('article'));
    }


    /**
     * to show create article page
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.create');
    }


    /**
     * to create and store new  article
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $input)
    {
        $this->validate($input, ['title' => 'required', 'body' => 'required']);
        $newArticle = new Article($input->all());

        Auth::user()->articles()->save($newArticle);
        session()->flash('flash_message', 'Article created successfully!');

        return redirect('articles/'.$newArticle->id);
    }


    /**
     * to verify and show edit article page
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($articleID)
    {
        $article = Article::find($articleID);

        if(is_null($article)) {
            abort(404);
        }
        if($article->user_id != Auth::user()->id){
            abort(401);
        }

        return view('articles.edit', compact('article'));
    }


    /**
     * to update editted  article in DB
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($articleID, Request $input)
    {
        $this->validate($input, ['title' => 'required', 'body' => 'required']);

        $article = Article::find($articleID);
        if(is_null($article)) {
            abort(404);
        }

        $article->update($input->all());
        session()->flash('flash_message', 'Article updated successfully!');

        return redirect('articles/'.$articleID);
    }


    /**
     * to delete an article
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($articleID)
    {
        $article = Article::find($articleID);

        if(is_null($article)) {
            abort(404);
        }
        if($article->user_id != Auth::user()->id){
            abort(401);
        }

        $article->delete();
        session()->flash('flash_message', 'Article deleted successfully!');

        return redirect('articles');
    }


    /**
     * to handle search queries
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $search = \Request::get('query');
        $articles = Article::where('title', 'like', '%'.$search.'%')->latest()->get();
        return view('articles.search', compact('articles'));
    }



    /************ Vote Stuff ****************/

    public function getUpvotes($article_id)
    {
        return (
            Article::find($article_id)
                    ->votes()
                    ->where('vote_value', 1)
                    ->count()
        );
    }


    public function getDownvotes($article_id)
    {
        return (
            Article::find($article_id)
                    ->votes()
                    ->where('vote_value', -1)
                    ->count()
        );
    }


    public function userHasVoted($article_id)
    {
        if( Auth::user()->votes()->where('article_id', $article_id)->count() == 0 ) {
            return false;
        } else {
            return true;
        }
    }


    public function getUserVoteValue($article_id)
    {
        return (
            Auth::user()
                ->votes()
                ->where('article_id', $article_id)
                ->get()->first()
                ->vote_value
        );
    }


    /**
     * Handles vote AJAX requests and updates DB accordingly
     *
     * @param  \Illuminate\Http\Request  $input
     * @return \Illuminate\Http\Response
     */
    public function storeUpvote(Request $input)
    {
        $article_id = (int)$input->article_id;
        $vote_value = (int)$input->vote_value;

        $response_vote_value = $vote_value;

        if($this->userHasVoted($article_id)) { // user has already voted on this article
            $vote = Vote::all()->where('user_id', Auth::user()->id)->where('article_id', $article_id)->first();
            if($vote->vote_value == $vote_value) { // if new vote is same as previous, remove it
                $vote->delete();
                $response_vote_value = 0;
            } else { // else update previous vote value to new one
                $vote->vote_value = $vote_value;
                $vote->save();
            }
        } else { // else create a new vote and insert into DB
            $vote = new Vote;
            $vote->user_id = Auth::user()->id;
            $vote->article_id = $article_id;
            $vote->vote_value = $vote_value;
            $vote->save();
        }

        $responseData = [];
        $responseData['vote_value'] = $response_vote_value;
        $responseData['upvotes'] = $this->getUpvotes($article_id);
        $responseData['downvotes'] = $this->getDownvotes($article_id);

        return response($responseData);
    }
}
