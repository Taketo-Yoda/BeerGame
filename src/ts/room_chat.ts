$(function(){
    // チャット検索
    setInterval(() => {
        getChat();
    }, 1000);

    // チャット送信
    $('#chat-submit').on('click',function(){
        submitChat();
    });
});

/**
 * チャット取得
 */
 function getChat() {
    let getChatUrl: any = $('#get-chat-url').val();
    let data: any = {
        'roomId' : $('#room-id').val(),
        'offset' : $('#offset').val()
    };
    $.getJSON(
        getChatUrl, data, function(response){
            $('#offset').val(response.offset);
            // チャットメッセージ生成
            for (const message of response.messages) {
                let outputLine:string = message.posted_datetime;
                let systemMsgClass:string = "";
                if (message.nickname == null) {
                    outputLine = outputLine + ' : ' + message.message;
                    systemMsgClass = "system-msg";
                } else {
                    outputLine = outputLine + ' ' + message.nickname + ' : ' + message.message;
                }
                let $messageObj = $("<p></p>");
                $messageObj.text(outputLine);
                $messageObj.addClass(systemMsgClass);
                $('#chatlog').append($messageObj);
                // チャット受信時は最下部へスクロール移動
                let chatlog: any = document.getElementById('chatlog');
                chatlog.scrollTop = chatlog.scrollHeight;
            }
        }
    )
}

/**
 * チャット送信
 */
function submitChat() {
    let url : any = $('#post-chat-url').val();
    let roomId : any = $('#room-id').val();
    let message : any = $('#chat-message').val();
    let csrfToken : any = $('#chat-info input[name="_csrfToken"]').val();
    $('#chat-message').prop('disabled', true);
    $('#chat-submit').prop('disabled', true);
    $.ajax({
        headers: { 'X-CSRF-TOKEN' : csrfToken},
        type: "POST",
        url: url,
        data: {id: roomId, message: message},
    }).done(function(){
        // 送信成功の場合はメッセージクリア
        $('#chat-message').val('');
    }).fail(function(){
        // 失敗した場合は処理なし
    }).always(function(){
        $('#chat-message').removeAttr('disabled');
        $('#chat-submit').removeAttr('disabled');
    });
}