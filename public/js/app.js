jQuery( document ).ready( function() {
    VoteButtonAjax();
});



/***************** AJAX handler for vote buttons *******************/
function VoteButtonAjax() {
    $('.vote-button').click(function(e){
        e.preventDefault();

        var $postData = {};
        $postData._token = $(this).data('token');
        $postData.vote_value = ($(this).data('vote-type') == 'upvote') ? 1 : -1;
        $postData.article_id = parseInt($(this).data('article'));

        $.ajax({
            type: 'POST',
            url : $(this).data('action'),
            data : $postData,
            cache: false,
            success : function(data){
                $('#rating-counter').html('Rating: ' + (data['upvotes'] - data['downvotes']));
                $('#upvote-button').html('Upvote (' + data['upvotes'] + ')');
                $('#downvote-button').html('Downvote (' + data['downvotes'] + ')');

                if(data['vote_value'] == 1) {   // Select upvote button

                } else if(data['vote_value'] == -1) {   // Select downvote button

                } else {    // deselect both buttons

                }
            }
        });
        return false;
    });
}
