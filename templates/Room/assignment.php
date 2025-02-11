<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?= $this->Html->css(['room-assignment']) ?>
<?= $this->Html->script(['jquery-ui','room_assignment']) ?>
<div class="room-assignment container border rounded">
    <div id="role-assighn-div" class="container">
        <input id="get-members-url" type="hidden" value="<?=  $this->Url->Build(['controller' => 'Room', 'action' => 'get-members', $id])?>">
        <input id="room-status" type="hidden" value="">
        <input id="is-owner" type="hidden" value="<?= h($isOwner)?>">
        <div class="row">
            <div class="col-6">
                <div class="card bg-info text-white">
                    <div class="card-header"><?= __('Participant')?></div>
                    <div class="card-body dropable-area mx-auto">
                        <div id="put-user-card-area" class="row">
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($isOwner): ?>
                <div class="col-6">
                    <div class="card bg-primary text-white">
                        <div class="card-header"><?= __('Role')?></div>
                        <div class="card-body mx-auto">
                            <?php foreach($units as $unit): ?>
                                <div class="card bg-light text-dark unit-card">
                                    <div class=card-header><?= __($unit['name'])?></div>
                                    <div class="card-body unit unit-<?= h($unit['name'])?> dropable-area">
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            <?php endif?>
        </div>
        <?php if ($isOwner): ?>
            <div id="owners-btn" class="row">
                <div class="col-12 d-inline-flex">
                    <?= $this->Form->create() ?>
                    <?php foreach($units as $unit): ?>
                        <input type="hidden" id="hdn-unit-<?= h($unit['name'])?>" class="assign-input-group" name="<?= h($unit['name'])?>">
                    <?php endforeach ?>
                    <?= $this->Form->button(__('Decision'), ['id' => 'btn-decision','class'=>'btn btn-primary submit', 'disabled']) ?>
                    <?= $this->Form->end() ?>
                    <button id="btn-cancel" class="btn btn-secondary" disabled><?= __('Cancel')?></button>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>
<div class="container border rounded">
    <div class="row">
        <div class="col-12 d-inline-flex">
            <button class="btn btn-danger submit" onclick="location.href='/'"><?= __('Return Top')?></button>
            <?php if (!$isOwner): ?>
                <!-- 退室フォーム -->
                <?= $this->Form->create(null, ['url' => ['controller' => 'Room', 'action' => 'leave']]) ?>
                <?php echo $this->Form->hidden('id', ['value' => $id]);?>
                <?= $this->Form->button(__('Leave'), ['id' => 'leave-btn', 'class'=>'btn btn-secondary submit']) ?>
                <?= $this->Form->end() ?>
            <?php endif ?>
        </div>
    </div>
</div>
<div hidden id="user-card-template">
    <div class="col-12 user-card-div"><div class="card bg-light text-dark user-card" data-account=""><div class="card-body small"></div></div></div>
</div>
<div id="wait-modal" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body"><?= __('I00001')?></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= __('Close')?></button>
            </div>
        </div>
    </div>
</div>
<?php if ($isOwner): ?>
    <div id="assign-guide-modal" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body"><?= __('I00002')?></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= __('Close')?></button>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <input id="wait-assign-modal-shown-flg" type="hidden" value=false>
    <div id="wait-assign-modal" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body"><?= __('I00003')?></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= __('Close')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="game-start-modal" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <?= __('I00004')?>
                    <table>
                        <tr><th><?= __('Retailer')?></th><td id="user-retailer"></td></tr>
                        <tr><th><?= __('Wholesale')?></th><td id="user-wholesale"></td></tr>
                        <tr><th><?= __('Distributor')?></th><td id="user-distributor"></td></tr>
                        <tr><th><?= __('Factory')?></th><td id="user-factory"></td></tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="location.href='<?= $this->Url->Build(['controller' => 'Room', 'action' => 'index', $id]) ?>'"><?= __('Move')?></button>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>