<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', __('Edit User'));
?>
<div class="row">
    <?php if($isAdmin):?>
        <aside class="column">
            <div class="side-nav">
                <h4 class="heading"><?= __('Actions') ?></h4>
                <?= $this->Form->postLink(
                    __('Delete'),
                    ['action' => 'delete', $user->account],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $user->account), 'class' => 'side-nav-item']
                ) ?>
                <?= $this->Html->link(__('Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            </div>
        </aside>
    <?php endif ?>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Edit User') ?></legend>
                <?php echo $this->element('Users/nickname', ['value' => $user['nickname']])?>
                <label for="participate_cnt"><?= __('Participate Cnt')?></label>
                <input id="participate_cnt" type="number" value="<?= h($user['participate_cnt'])?>" disabled></input>
                <?php if ($isAdmin):?>
                    <?php echo $this->element('Users/auth_name', ['authorities' => $authorities, 'authName' => $user['auth_name']])?>
                <?php else: ?>
                    <label for="auth_name"><?= __('Auth Name')?></label>
                    <input id="auth_name" type="text" value="<?= h($user['auth_name'])?>" disabled></input>
                <?php endif ?>
            </fieldset>
            <?= $this->Form->button(__('Save'), ['class'=>'submit']) ?>
            <?= $this->Form->end() ?>
            <?php if ($isAdmin):?>
                <button type="button" data-bs-toggle="modal" data-bs-target="#password-reset-modal"><?= __('Reset Password')?></button>
                <div class="modal fade" id="password-reset-modal" tabindex="-1" aria-labelledby="reset-modal-label" aria-hidden="true">
                    <?= $this->Form->create($user, ['type'=> 'post', 'url' => ['action' => 'resetPassword']]) ?>
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="reset-modal-label"><?= __('Reset Password')?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php echo $this->Form->hidden('account');?>
                                    <?php echo $this->element('Users/password', ['legend' => 'New Password', 'name' => 'password', 'placeholder' => 'password']) ?>
                                </div>
                                <div class="modal-footer">
                                    <?= $this->Form->button(__('Save'), ['class'=>'submit']) ?>
                                </div>
                            </div>
                        </div>
                    <?= $this->Form->end() ?>
                </div>
            <?php endif?>
        </div>
    </div>
</div>
