<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', __('Change Password'));
?>
<div class="row">
    <div class="column">
        <div class="users form content">
            <?= $this->Form->create() ?>
            <fieldset>
                <legend><?= __('Change Password') ?></legend>
                <?php echo $this->element('Users/password', ['legend' => 'Old Password', 'name' =>'old_password'])?>
                <?php echo $this->element('Users/password', ['legend' => 'New Password', 'name' =>'new_password1'])?>
                <?php echo $this->element('Users/password', ['legend' => 'New Password', 'name' =>'new_password2'])?>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['class' => 'submit']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
