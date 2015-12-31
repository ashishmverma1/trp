/**************** AJAX for notification checking *******************/
function notifAjax() {
    $.ajax({
        type: 'GET',
        url : '/notifications/check',
        cache: false,
        success : function(data) {
            if(data > 0) {
                $('#notif-indicator').html(data);
                $('#notif-indicator').show();
            } else {
                $('#notif-indicator').hide();
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
        $('.rating-ajax-spinner').show();

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
                $('#new-rating-value').html(data['upvotes'] - data['downvotes']);
                $('#new-upvote-value').html(data['upvotes']);
                $('#new-downvote-value').html(data['downvotes']);

                if(data['vote_value'] == 1) {   // Select upvote button
                    $('#upvote-button').removeClass('vote-button-unselected');
                    $('#downvote-button').addClass('vote-button-unselected');

                } else if(data['vote_value'] == -1) {   // Select downvote button
                    $('#upvote-button').addClass('vote-button-unselected');
                    $('#downvote-button').removeClass('vote-button-unselected');
                } else {    // deselect both buttons
                    $('#upvote-button').addClass('vote-button-unselected');
                    $('#downvote-button').addClass('vote-button-unselected');
                }

                $('.rating-ajax-spinner').hide();
            }
        });
        return false;
    });
}


/*********************** Set footer position ******************/
function setFooter() {
    if($(document).height() <= $(window).height()) {
        var footer = $('.footer').first();
        footer.css('position', 'fixed');
    }
}
