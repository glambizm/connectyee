/*
 * connectyee.user.js
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
 */
$(function() {
    'use strict';

    $('#btn-regist').on('click', function() {
        var error = false;

        $('.modal-body').empty();

        if ($('#full_name') && $('#full_name').val() === '') {
            $('.modal-body').append($('<h6 id="modal-body-text">「氏名」を入力してください。</h6>'));
            error = true;
        }

        if ($('#full_name_kana') && $('#full_name_kana').val() === '') {
            $('.modal-body').append($('<h6 id="modal-body-text">「氏名カナ」を入力してください。</h6>'));
            error = true;
        }

        if ($('#account') && $('#account').val() === '') {
            $('.modal-body').append($('<h6 id="modal-body-text">「アカウント」を入力してください。</h6>'));
            error = true;
        }

        if ($('#password') && $('#password').val() === '') {
            $('.modal-body').append($('<h6 id="modal-body-text">「パスワード」を入力してください。</h6>'));
            error = true;
        }

        if ($('#password') && $('#password').val().length < 6) {
            $('.modal-body').append($('<h6 id="modal-body-text">「パスワード」は6文字以上入力してください。</h6>'));
            error = true;
        }

        if ($('#mail_address') && $('#mail_address').val() === '') {
            $('.modal-body').append($('<h6 id="modal-body-text">「メールアドレス」を入力してください。</h6>'));
            error = true;
        }

        if (error === true) {
            $('#alertModal').modal();
            return false;
        }
    });
});
