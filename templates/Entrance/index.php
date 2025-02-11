<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', __('Entrance'));
?>
<?= $this->Html->css(['entrance']);?>
<div id="entranc-content">
    <div id="entrance-head-content" class="Entrance index content">
        <div class="container">
            <button id="btn-create-room" class="submit" onclick="location.href='<?= $this->Url->Build(['controller' => 'Room', 'action' => 'add'])?>'">
                <?= __('Add Room')?>
            </button>
        </div>
    </div>
    <div id="game-list-content" class="content">
        <div id="room-btn-div">
            <button class="btn btn-primary submit" onclick="window.location.reload();"><?= __('Reload')?></button>
            <!-- TODO : 過去ゲーム一覧画面作成 -->
            <button class="btn btn-secondary"><?= __('Old Game')?></button>
        </div>
        <div class="container">
            <ol class="list-group">
                <?php foreach ($rooms as $room):?>
                    <li class="list-group-item d-flex justify-content-between align-items-start align-items-center  list-group-item-action">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">
                                <?php if ($room['name'] === ''): ?>
                                    <?= h('#' . $room['id']) ?>
                                <?php else: ?>
                                    <?= h($room['name']) ?>
                                <?php endif ?>
                                <span class="badge <?= h($room['entry_flg'] ? 'bg-primary' : 'bg-success')?> rounded-pill"><?= __($room['status']) ?></span>
                            </div>
                            <span class="small">参加者：<?= h($room['members'])?></span>
                        </div>
                        <?php if ($room['entry_flg']): ?>
                            <?= $this->Form->create(null, ['url' => ['controller' => 'Entrance', 'action' => 'entry']]) ?>
                            <?php echo $this->Form->hidden('id', ['value' => $room['id']]);?>
                            <?= $this->Form->button(__('Enter'), ['class'=>'btn btn-primary in-li-btn submit']) ?>
                            <?= $this->Form->end() ?>
                        <?php elseif ($room['watching_flg']): ?>
                            <button class="btn btn-secondary in-li-btn" onclick="location.href='<?= $this->Url->Build(['controller' => 'Room', 'action' => 'index', $room['id']])?>'"><?= __('Watch')?></button>
                        <?php endif ?>
                    </li>
                <?php endforeach?>
            </ol>
        </div>
    </div>
</div>
