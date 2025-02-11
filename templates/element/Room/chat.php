<div id="chat-area">
    <div class="container">
        <div class="row">
            <div id="chatlog" class="col-12 small">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div id="chat-info" class="input-group mb-3">
                    <?= $this->Form->create() ?>
                    <?= $this->Form->end() ?>
                    <input id="get-chat-url" type="hidden" value="<?=  $this->Url->Build(['controller' => 'Room', 'action' => 'get-chat'])?>">
                    <input id="post-chat-url" type="hidden" value="<?=  $this->Url->Build(['controller' => 'Room', 'action' => 'post-chat'])?>">
                    <input id="room-id" type=hidden value=<?= h($roomId)?> />
                    <input id="offset" type="hidden" value=0 />
                    <input id="chat-message" type="text" class="form-control" aria-describedby="chat-submit">
                    <div class="input-group-append">
                        <button id="chat-submit" class="btn btn-primary">送信</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>