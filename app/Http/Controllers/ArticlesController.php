<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Article;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class ArticlesController extends Controller
{
  // check authentication for create/edit pages using middleware
  public function __construct()
  {
    $this->middleware('auth', ['except' => ['index', 'show']]);
  }


  // for all articles home page
  public function index()
  {
    $articles = Article::all();
    //$articles = Article::latest()->get();
    return view('articles.index', compact('articles'));
  }


  // to show a particular article
  public function show($articleID)
  {
    $article = Article::find($articleID);
    if(is_null($article)) {
      abort(404);
    }
    return view('articles.show', compact('article'));
  }


  // to show create article page
  public function create()
  {
    return view('articles.create');
  }


  // to create and store new  article
  public function store(Request $input)
  {
    $this->validate($input, ['title' => 'required', 'body' => 'required']);
    $newArticle = new Article($input->all());
    // $newArticle->title = $input->input('title');
    // $newArticle->body = $input->input('body');
    // $newArticle->save();
    Auth::user()->articles()->save($newArticle);
    return redirect('articles/'.$newArticle->id);
  }


  // to verify and show edit article page
  public function edit($articleID)
  {
    $article = Article::find($articleID);
    if(is_null($article)) {
      abort(404);
    }
    return view('articles.edit', compact('article'));
  }


  // to update editted  article in DB
  public function update($articleID, Request $input)
  {
    $this->validate($input, ['title' => 'required', 'body' => 'required']);

    $article = Article::find($articleID);
    if(is_null($article)) {
      abort(404);
    }

    $article->update($input->all());

    return redirect('articles/'.$articleID);
  }


  // to delete an article
  public function destroy($articleID)
  {
    $article = Article::find($articleID);
    if(is_null($article)) {
      abort(404);
    }
    $article->delete();
    return redirect('articles');
  }
}
