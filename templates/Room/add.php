<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', __('Add Room'));
?>
<?= $this->Html->script('room_add') ?>
<div class="Add Room content">
    <div class="container">
        <?= $this->Form->create() ?>
        <fieldset>
            <legend><?= __('Add Room') ?></legend>
            <label for="room-name"><?= __('Room Name')?></label>
            <input id="room-name" name="room_name" type="text" placeholder="Room Name" maxlength="30"></input>
            <label for="difficulties"><?= __('Difficulty')?></label>
            <select id="difficulties" name="difficulty">
                <?php foreach($difficulties as $difficulty):?>
                    <option value="<?= h($difficulty['name'])?>" data-default-num-of-turn="<?= h($difficulty['default_num_of_turn'])?>"><?= __($difficulty['name'])?></option>
                <?php endforeach?>
            </select>
            <label for="num-of-turn"><?= __('Number Of Turn')?></label>
            <input id="num-of-turn" class="required" name="num_of_turn" type="number" min="20" max="50"></input>
        </fieldset>
        <?= $this->Form->button(__('Add'), ['class'=>'submit']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
