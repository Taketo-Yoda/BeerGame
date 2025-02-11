<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', __('Top'));
?>
<div class="top index content">
    <div class="row">
        <fieldset>
            <legend><?= __('Game')?></legend>
            <button onclick="location.href='<?= $this->Url->Build(['controller' => 'Entrance', 'action' => 'index'])?>'">
                <?= __('Game Start')?>
            </button>
        </fieldset>
    </div>
    <div class="row">
        <fieldset>
            <legend><?= __('User Info')?></legend>
            <?php if ($isAdmin): ?>
                <button class="submit" onclick="location.href='<?= $this->Url->Build(['controller' => 'Users', 'action' => 'index'])?>'">
                    <?= __('Users')?>
                </button>
            <?php endif; ?>
            <button class="submit" onclick="location.href='<?= $this->Url->Build(['controller' => 'Users', 'action' => 'edit', $account])?>'">
                <?= __('User Info')?>
            </button>
            <button class="submit" onclick="location.href='<?= $this->Url->Build(['controller' => 'Users', 'action' => 'changePassword', $account])?>'">
                <?= __('Change Password')?>
            </button>
        </fieldset>
    </div>
</div>
