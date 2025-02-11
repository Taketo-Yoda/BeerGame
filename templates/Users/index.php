<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
$this->assign('title', __('Users'));
?>
<div class="users index content">
    <?= $this->Html->link(__('Add User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Users') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('account') ?></th>
                    <th><?= $this->Paginator->sort('nickname') ?></th>
                    <th><?= $this->Paginator->sort('participate_cnt') ?></th>
                    <th><?= $this->Paginator->sort('auth_name') ?></th>
                    <th><?= $this->Paginator->sort('last_login') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= h($user->account) ?></td>
                    <td><?= h($user->nickname) ?></td>
                    <td><?= $this->Number->format($user->participate_cnt) ?></td>
                    <td><?= h($user->auth_name) ?></td>
                    <td><?= h($user->last_login) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $user->account]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->account]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->account], ['confirm' => __('Are you sure you want to delete # {0}?', $user->account)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
