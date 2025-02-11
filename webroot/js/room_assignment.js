"use strict";
var getMembersIntervalId;
var $waitModal;
$(function () {
    // メンバー一覧検索
    getMembersIntervalId = setInterval(() => {
        getMembers();
    }, 3000);
    // droppableイベント設定
    $(".dropable-area").droppable({
        accept: '.user-card',
        drop: function (event, ui) {
            if ($(this).hasClass('unit')) {
                // キャンセルボタンを活性化
                $('#btn-cancel').removeAttr('disabled');
                // draggable解除
                let account = ui.draggable.data('account');
                ui.draggable.attr('style', '');
                $(this).append(ui.draggable);
                ui.draggable.draggable({ 'disabled': true });
                $(this).droppable({ 'disabled': true });
                // form設定
                if ($(this).hasClass('unit-Retailer')) {
                    $('#hdn-unit-Retailer').val(account);
                } else if ($(this).hasClass('unit-Wholesale')) {
                    $('#hdn-unit-Wholesale').val(account);
                } else if ($(this).hasClass('unit-Distributor')) {
                    $('#hdn-unit-Distributor').val(account);
                } else {
                    $('#hdn-unit-Factory').val(account);
                }
                // draggableオブジェクトが存在しなくなったら決定ボタンを活性化
                let fixedFlg = true;
                $('.assign-input-group').each(function(i, elem){
                    if ($(elem).val() == "") {
                        fixedFlg = false;
                    }
                })
                if (fixedFlg) {
                    $('#btn-decision').removeAttr('disabled');
                }
            }
        }
    });
    // waitモーダル表示
    $waitModal = $('#wait-modal');
    $waitModal.modal('show');

    // TODO:キャンセルボタン押下イベント
});
/**
 * メンバー取得
 */
function getMembers() {
    let getMembersUrl = $('#get-members-url').val();
    let data = {
        ts: new Date().getTime()
    };
    $.getJSON(getMembersUrl, data, function (response) {
        let $putCardArea = $('#put-user-card-area');
        let $userCardDivs = $putCardArea.find('.user-card-div');
        $('#room-status').val(response.roomInfo.status);
        // 入室者のパネル作成
        for (const user of response.roomInfo.users) {
            if ($userCardDivs.length == 0 || $userCardDivs.find('[data-account="' + user.account + '"]').length == 0) {
                let $userCardElem = $('#user-card-template .user-card-div').clone();
                $userCardElem.find('.user-card').data('account', user.account);
                $userCardElem.find('.card-body').text(user.nickname);
                $('#put-user-card-area').append($userCardElem);
            }
        }
        // 退室者のパネルを削除
        if ($userCardDivs != undefined) {
            for (const userCardDiv of $userCardDivs) {
                let existsFlg = false;
                for (const user of response.roomInfo.users) {
                    if (user.account == $(userCardDiv).data('account')) {
                        existsFlg = true;
                    }
                }
                if (!existsFlg) {
                    $(userCardDiv).remove();
                }
            }
            ;
        }
        ;
        // ステータスがReadyになった場合
        if (response.roomInfo.status == 'Ready') {
            // waitモーダルが表示されていたら閉じる
            $waitModal.modal('hide');
            let isOwner = $('#is-owner').val();
            if (isOwner) {
                // インターバル処理停止
                clearInterval(getMembersIntervalId);
                // draggable設定
                $('#put-user-card-area').find('.user-card').draggable({
                    stack: '.user-card',
                    revert: 'invalid',
                });
                // assign-guide-modal表示
                $('#assign-guide-modal').modal('show');
            }
            else {
                // ボタン活性非活性制御
                $('#leave-btn').prop('disabled', true);
                // wait-assign-modal表示
                if ($('#wait-assign-modal-shown-flg').val() == 'false'){
                    $('#wait-assign-modal').modal('show');
                    $('#wait-assign-modal-shown-flg').val('true');
                }
            }
        }
        // ステータスがGamingになった場合
        if (response.roomInfo.status == 'Gaming') {
            // インターバル処理停止
            clearInterval(getMembersIntervalId);
            // wait-assign-modalが表示されていたら閉じる
            $('#wait-assign-modal').modal('hide');
            // game-start-modalを表示
            $('#game-start-modal').modal('show');
            // TODO: 10秒後の自動遷移処理
            // TODO: 役割の表示
        }
    });
}
