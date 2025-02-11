<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', __('Add User'));
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create() ?>
            <fieldset>
                <legend><?= __('Add User') ?></legend>
                <label for="account"><?= __('Account')?></label>
                <input id="account" class="required" name="account" type="text" placeholder="account" maxlength="30"></input>
                <?php echo $this->element('Users/password', ['legend' => 'Password', 'name' =>'password'])?>
                <?php echo $this->element('Users/nickname', ['value' => null])?>
                <?php echo $this->element('Users/auth_name', ['authorities' => $authorities, 'authName' =>null])?>
            </fieldset>
            <?= $this->Form->button(__('Add'), ['class'=>'submit']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
