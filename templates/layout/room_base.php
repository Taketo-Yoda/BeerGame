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

    <?= $this->Html->script('index') ?>
    <?= $this->Html->script('jquery') ?>
    <?= $this->Html->script('common') ?>
    <?= $this->Html->script('room_chat') ?>
    <?= $this->Html->css(['common', 'room-base']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <main class="main">
        <div id="all-area-indicator">
            <div class="loading d-flex justify-content-center align-items-center">
                <div class="spinner spinner-border text-danger" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>            
            </div>
        </div>
        <div class="container content-area">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
        <?php echo $this->element('Room/chat', ['roomId' => $roomId]);?>
    </footer>
</body>
</html>
