<?= $this->Html->css(['room']) ?>
<?= $this->Html->script(['room']) ?>
<input id="my-member-id" type="hidden" value="<?= h($myMemberId)?>">
<input id="unit-info-url" type="hidden" value="<?= $this->Url->Build(['controller' => 'Room', 'action' => 'unit-info', $roomId]) ?>">
<div class="row">
    <div class="col-6">難易度：<span><?= __($difficulty)?></span></div>
    <div class="col-6">ターン数：<span id="cur-turn"><?= h($currentTurn)?></span>/<span><?= __($numOfTurn)?></span></div>
</div>
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a href="#pane-retailer" class="nav-link <?php if ($isWatcher || $retailer->account == $account) echo("active")?>" data-bs-toggle="tab" data-member-id=<?= h($retailer->id)?>><?= __('Retailer')?></a>
    </li>
    <li class="nav-item">
        <a href="#pane-wholesale" class="nav-link <?php if ($wholesale->account == $account) echo("active")?>" data-bs-toggle="tab" data-member-id=<?= h($wholesale->id)?>><?= __('Wholesale')?></a>
    </li>
    <li class="nav-item">
        <a href="#pane-distributor" class="nav-link <?php if ($distributor->account == $account) echo("active")?>" data-bs-toggle="tab" data-member-id=<?= h($distributor->id)?>><?= __('Distributor')?></a>
    </li>
    <li class="nav-item">
        <a href="#pane-factory" class="nav-link <?php if ($factory->account == $account) echo("active")?>" data-bs-toggle="tab" data-member-id=<?= h($factory->id)?>><?= __('Factory')?></a>
    </li>
</ul>
<div class="tab-content">
    <div id="pane-retailer" class="tab-pane pane-retailer <?php if ($isWatcher || $retailer->account == $account) echo("active")?>">
        <?php echo $this->element('Room/unit', ['name' => $retMemName, 'member' => $retailer, 'account' => $account, 'isMyUnit' => $retailer->account == $account])?>
    </div>
    <div id="pane-wholesale" class="tab-pane <?php if ($wholesale->account == $account) echo("active")?>">
        <?php echo $this->element('Room/unit', ['name' => $wholMemName, 'member' => $wholesale, 'account' => $account, 'isMyUnit' => $wholesale->account == $account])?>
    </div>
    <div id="pane-distributor" class="tab-pane <?php if ($distributor->account == $account) echo("active")?>">
        <?php echo $this->element('Room/unit', ['name' => $distMemName, 'member' => $distributor, 'account' => $account, 'isMyUnit' => $distributor->account == $account])?>
    </div>
    <div id="pane-factory" class="tab-pane <?php if ($factory->account == $account) echo("active")?>">
        <?php echo $this->element('Room/unit', ['name' => $factMemName, 'member' => $factory, 'account' => $account, 'isMyUnit' => $factory->account == $account])?>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12 d-inline-flex">
            <?php if ($isWatcher): ?>
                <button class="btn btn-danger submit" onclick="location.href='<?= $this->Url->Build(['controller' => 'Entrance', 'action' => 'index']) ?>'"><?= __('Back to Entrance')?></button>
            <?php else: ?>
                <button class="btn btn-danger submit" onclick="location.href='/'"><?= __('Return Top')?></button>
            <?php endif ?>
        </div>
    </div>
</div>
