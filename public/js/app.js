jQuery( document ).ready( function() {
    notificationAjax();
    voteButtonAjax();
});


/**************** AJAX for notification checking *******************/
function notifAjax() {
    $.ajax({
        type: 'GET',
        url : '/notifications/check',
        cache: false,
        success : function(data) {
            if(data > 0) {
                $('#notif-indicator').html(data);
            } else {
                $('#notif-indicator').html('');
            }
        }
    });
}

function notificationAjax() {
    notifAjax();
    setInterval(function(){
        notifAjax();
    }, 10000);
}



/***************** AJAX handler for vote buttons *******************/
function voteButtonAjax() {
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
