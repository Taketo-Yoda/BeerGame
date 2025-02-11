var getMembersIntervalId: any;
var $waitModal: any;
$(function(){
    // メンバー一覧検索
    getMembersIntervalId = setInterval(() => {
        getMembers();
    }, 3000);
    // droppableイベント設定
    $(".dropable-area").droppable({
        accept: '.user-card',
        drop: function(event, ui) {
            if ($(this).hasClass('unit')){
                ui.draggable.attr('style','');
                $(this).append(ui.draggable);
                ui.draggable.draggable({'disabled':true});
                $(this).droppable({'disabled':true});
            }
       }}
    );
    // waitモーダル表示
    $waitModal = $('#wait-modal');
})

/**
 * メンバー取得
 */
function getMembers() {
    let getMembersUrl: any = $('#get-members-url').val();
    $.getJSON(
        getMembersUrl, function(response){
            let $putCardArea = $('#put-user-card-area');
            let $userCardDivs = $putCardArea.find('.user-card-div');
            $('#room-status').val(response.status);
            // 入室者のパネル作成
            for (const user of response.users) {
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
                    let existsFlg: boolean = false;
                    for (const user of response.users) {
                        if (user.account == $(userCardDiv).data('account')) {
                            existsFlg = true;
                        }
                    }
                    if (!existsFlg) {
                        $(userCardDiv).remove();
                    }
                };
            };
            // ステータスがReadyになった場合
            if (response.status == 'Ready') {
                let isOwner = $('#is-owner').val();
                if (isOwner) {
                    // インターバル処理停止
                    clearInterval(getMembersIntervalId);
                    // draggable設定
                    $('#put-user-card-area').find('.user-card').draggable({
                        stack: '.user-card',
                        revert: 'invalid',
                    });
                } else {
                    // ボタン活性非活性制御
                    $('#leave-btn').prop('disabled', true);
                }
            }
            // ステータスがGamingになった場合
            if (response.status == 'Gaming') {
                // インターバル処理停止
                clearInterval(getMembersIntervalId);
            }
        }
    )
}