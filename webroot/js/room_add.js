"use strict";
$(window).on('load', function () {
    // 初期化処理
    $('#num-of-turn').val($('#difficulties option:selected').data('default-num-of-turn'));
    // セレクトボックス変更時の処理
    $('#difficulties').on('change', function () {
        $('#num-of-turn').val($(this).find('option:selected').data('default-num-of-turn'));
    });
});
