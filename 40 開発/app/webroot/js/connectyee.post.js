/*
 * connectyee.post.js
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
 */
$(function() {
    'use strict';

    $('#btn-submissiont').on('click', function() {
        var error = false;
        $('.modal-body').empty();
        if ($('#title').val() === '') {
            $('.modal-body').append($('<h6 id="modal-body-text">タイトルを入力してください。</h6>'));
            error = true;
        }
        if ($('#body').val() === '') {
            $('.modal-body').append($('<h6 id="modal-body-text">本文を入力してください。</h6>'));
            error = true;
        }

        if (error === true) {
            $('#alertModal').modal();
            return false;
        }
    });

    $('#btn-comment-regist').on('click', function() {
        var error = false;
        $('.modal-body').empty();
        if ($('#comment-title-input').val() === '') {
            $('.modal-body').append($('<h6 id="modal-body-text">コメントタイトルを入力してください。</h6>'));
            error = true;
        }
        if ($('#comment-body-input').val() === '') {
            $('.modal-body').append($('<h6 id="modal-body-text">コメント本文を入力してください。</h6>'));
            error = true;
        }

        if (error === true) {
            $('#alertModal').modal();
            return false;
        }

        var ajaxParam = {
            url: location.href + '/submissionComment',
            dataType: 'json',
            type: 'POST',
            data: { parent_id: $('#post-id').val(),
                    comment_title:$('#comment-title-input').val(),
                    comment_body: $('#comment-body-input').val()}
        };

        ajaxComment(ajaxParam);
    });

    $('.comment-delete-button').on('click', function() {
        var ajaxParam = {
            url: location.href + '/deleteComment',
            dataType: 'json',
            type: 'POST',
            data: { id: $(this).attr('data-comment-id'),
                    parent_id: $('#post-id').val()}
        };

        ajaxComment(ajaxParam);
    });

    function ajaxComment(ajaxParam) {
        $.ajax(ajaxParam).done(function(result) {
            $('#comment-wrapper').remove();

            $.each(result, function(i, comment){
                var wrapper = $('<div></div>').addClass('comment-wrapper panel panel-default');
                var row = $('<div></div>').addClass('row');


            });
        });
    }
});
