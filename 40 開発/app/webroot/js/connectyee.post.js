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

        $.ajax(ajaxParam).done(function(result) {
            $('#comment-wrapper').remove();

            $.each(result, function(i, comment){
                var comment_wrapper = $('<div></div>').addClass('comment-wrapper panel panel-default');

                var comment_row = $('<div></div>').addClass('row');
                comment_row.appendTo(comment_wrapper);

                var comment_name = $('<div></div>').addClass('comment-name col-sm-2 col-xs-12');
                comment_name.appendTo(comment_row);

                var initial = $('<span></span>').addClass(comment.initialClass + ' text-center').val(comment.initial);
                initial.appendTo(comment_name);

                var full_name = $('<span></span>').addClass('full-name').val(comment.fullName);
                full_name.appendTo(comment_name);

                var comment_main = $('<div></div>').addClass('comment-main col-sm-8 col-xs-10');

                var comment_main_row = $('<div></div>').addClass('row');
                comment_main_row.appendTo(comment_main);

                var comment_date = $('<div></div>').addClass('comment-date col-sm-5 col-sm-push-7').val(comment.postDate);
                comment_date.appendTo(comment_main_row);

                var comment_body_title = $('<div></div>').addClass('comment-body-title col-sm-7 col-sm-pull-5');
                comment_body_title.appendTo(comment_main_row);

                var comment_title = $('<div></div>').addClass('comment-title').val(comment.title);
                comment_title.appendTo(comment_body_title);

                var comment_body = $('<div></div>').addClass('comment-body').val(comment.body);
                comment_body.appendTo(comment_body_title);

                if (comment.canDelete === true) {
                    var comment_delete = $('<div></div>').addClass('comment-delete col-sm-2 col-xs-2');
                    comment_delete.appendTo(comment_main_row);

                    var comment_delete_button = $('<a></a>').addClass('comment-delete-button btn btn-success glyphicon glyphicon-remove')
                                                            .attr('data-toggle', 'tooltip').attr('data-container', 'body')
                                                            .attr('data-placement', 'top').attr('data-comment-id', comment.id)
                                                            .attr('title', '削除');
                    comment_delete_button.appendTo(comment_delete);
                }
            });
        });
    });

    $('.comment-delete-button').on('click', function() {
        var ajaxParam = {
            url: location.href + '/deleteComment',
            dataType: 'json',
            type: 'POST',
            data: { id: $(this).attr('data-comment-id'),
                    parent_id: $('#post-id').val()}
        };

        $.ajax(ajaxParam).done(function(result) {
            $('this').parents('.comment-wrapper').fadeOut();
        });
    });
});
