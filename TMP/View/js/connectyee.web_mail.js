/*
 * connectyee.common.js
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
$(function() {
	'use strict';

	$('#select-receiving-users').multiselect({
        maxHeight: 200,
        checkboxName: 'receiving_user_list[]',
        buttonClass: 'select-receiving-users btn btn-success',
        buttonWidth: '100px',
        buttonTitle: function(options, select) {
            var labels = [];
            options.each(function() {
                if ($(this).attr('label') !== undefined) {
                    labels.push($(this).attr('label'));
                } else {
                    labels.push($(this).html());
                }
            });
            $('#label-receiving-user-list').text(labels.join('; '));

            if ($('#label-receiving-user-list').text() === '') {
                $('#label-receiving-user-list').hide();
            } else {
                $('#label-receiving-user-list').show();
            }

            return '宛先';
        },
        buttonText: function(options, select) {return '宛先';},
        includeSelectAllOption: true,
        selectAllText: '全選択',
        enableFiltering: true,
        filterPlaceholder: '検索'
	});

	$('#btn-send').on('click', function() {
        if ($('#label-receiving-user-list').text() === '') {
            $('#alertModal').modal();
            return false;
        }
	});
});

