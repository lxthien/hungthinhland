'use strict';

require('jquery-validation');
require('@fancyapps/fancybox');

function intHandleFormComment() {
    window.dataLayer = window.dataLayer || [];

    var $formComment = $('#form-comment');

    $formComment.on('click', '#form_send', function(e) {
        if ($formComment.valid()) {
            $.ajax({
                type: "POST",
                url: $formComment.attr('action'),
                data: $formComment.serialize(),
                success: function(data) {
                    var response = JSON.parse(data);
                    if (response.status === 'success') {
                        $.fancybox.open({
                            src: response.message,
                            type : 'html',
                            touch : false
                        });
                        
                        window.dataLayer.push({
                            'event': 'subscriber'
                        });

                        // Clear form comment
                        $formComment[0].reset();
                    } else {
                        $.fancybox.open({
                            src: response.message,
                            type : 'html',
                            touch : false
                        });
                    }
                }
            });
        }
    })
}

function intHandleFormReplyComment() {
    var $commentReply = $('.comment-reply-link');
    var $formComment = $('#form-comment');

    $commentReply.click(function(e) {
        e.preventDefault();

        var postID = $(this).data('postId');

        if (postID) {
            $formComment.find('input#form_comment_id').val(postID);

            $('html, body').animate({
                scrollTop: $formComment.offset().top
            }, 1000);
        }
    });
}

exports.init = function () {

    $('#form-comment').validate();

    intHandleFormComment();
    intHandleFormReplyComment();
};