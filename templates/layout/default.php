<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= __('Beer Game') ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <link rel="apple-touch-icon" href="/favicon.ico">

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">

    <?= $this->Html->script('index') ?>
    <?= $this->Html->script('jquery') ?>
    <?= $this->Html->script('common') ?>
    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake', 'common']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-title">
            <a href="<?= $this->Url->build('/') ?>"><span><?= __('Beer Game')?></span></a>
        </div>
        <div>
            <?php
                $session = $this->getRequest()->getSession();
                $nickname = $session->read("User.nickname");
            ?>
            <?php if (!is_null($nickname)): ?>
                <?php echo $this->Html->image('figure_one_red.png', ['width' => '20', 'height' => '30']); ?><?= h($nickname)?>
            <?php endif ?>
        </div>
    </nav>
    <main class="main">
        <div id="all-area-indicator">
            <?php echo $this->element('indicator')?>
        </div>
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>
