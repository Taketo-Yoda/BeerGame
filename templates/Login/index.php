<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', __('LOGIN'));
?>
<div class="Login index content">
    <div class="container">
        <?= $this->Form->create() ?>
        <?php
            echo $this->Form->text('account', ['id'=>'account', 'placeholder'=>'account']);
            echo $this->Form->password('password', ['id'=>'password', 'placeholder'=>'password']);
        ?>
        <?= $this->Form->button(__('LOGIN'), ['class'=>'submit']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
