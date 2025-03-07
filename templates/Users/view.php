<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', __('User Info'));
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->account], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->account], ['confirm' => __('Are you sure you want to delete # {0}?', $user->account), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Add User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users view content">
            <h3><?= h($user->account) ?></h3>
            <table>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= h($user->account) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nickname') ?></th>
                    <td><?= h($user->nickname) ?></td>
                </tr>
                <tr>
                    <th><?= __('Auth Name') ?></th>
                    <td><?= h($user->auth_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created By') ?></th>
                    <td><?= h($user->created_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated By') ?></th>
                    <td><?= h($user->updated_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Participate Cnt') ?></th>
                    <td><?= $this->Number->format($user->participate_cnt) ?></td>
                </tr>
                <tr>
                    <th><?= __('Version') ?></th>
                    <td><?= $this->Number->format($user->version) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Login') ?></th>
                    <td><?= h($user->last_login) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($user->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated') ?></th>
                    <td><?= h($user->updated) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
