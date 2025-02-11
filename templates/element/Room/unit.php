<div class="row">
    <div class="col-12 small unit-info-row">
        <span class="badge bg-primary bg-playing" style="display:none">Playing</span>
        <span class="badge bg-secondary bg-wait" style="display:none">Wait</span>
        <?= h($name)?>
    </div>
    <!-- 受注発送エリア -->
    <div class="col-4 card-col">
        <!-- 受注エリア -->
        <div class="col-12">
            <div class="card first-row-card">
                <div class="card-header"><?= __("Order")?></div>
                <div class="card-body">
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="card-open rounded border border-secondary card-order">
                            <div class="open-flg">
                                <div class="i2 open-object d-flex justify-content-center align-items-center">
                                    <span class="num-of-order">4</span>
                                </div>
                                <?= $this->Html->image("card.png", ["class" => "i1 open-object"])?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($isMyUnit):?>
                    <div class="card-footer text-center">
                        <button type="button" class="btn btn-primary btn-order" disabled>2.<?= __("Order")?></button>
                    </div>
                <?php endif?>
            </div>
        </div>
        <!-- 顧客／配送エリア -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <?php if ($member->unit == 'Retailer'):?>
                        <?= __("Customer")?>
                    <?php else: ?>
                        <?= __("Delivery request")?>
                    <?php endif?>
                </div>
                <div class="card-body delivery-icons">
                    <?php if ($member->unit == 'Retailer'):?>
                        <div class="row d-flex justify-content-center align-items-center">
                            <div id="customer-img">
                                <div class="open-flg">
                                    <?= $this->Html->image("happy.png", ["id" => "happy-image", "class" => "i2 open-object"])?>
                                    <?= $this->Html->image("sad.png", ["id" => "sad-image", "class" => "i2 open-object", "style" => "display:none"])?>
                                    <?= $this->Html->image("customer.png", ["id" => "customer-image", "class" => "i1 open-object"])?>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php echo $this->element('Room/ship_token')?>
                    <?php endif?>
                </div>
                <?php if ($member->unit != 'Retailer'):?>
                    <div class="card-footer">
                        <div class="row d-flex align-items-center">
                            <div class="col-md-6 col-sm-12">
                                <?= __("Quantity") ?> : <span class="delivery-request-count"></span>
                            </div>
                            <?php if($isMyUnit):?>
                            <div class="col-md-6 col-sm-12 text-end">
                                <button type="button" class="btn btn-primary btn-sale" disabled>3.
                                    <?= __("Shipping Request")?>
                                </button>
                            </div>
                            <?php endif ?>
                        </div>
                    </div>
                <?php elseif ($isMyUnit):?>
                    <div class="card-footer text-center">
                        <button type="button" class="btn btn-primary btn-sale" disabled>3.<?= __("Sale")?></button>
                    </div>
                <?php endif?>
            </div>
        </div>
    </div>
    <!-- 在庫エリア -->
    <div class="col-4">
        <div class="card">
            <div class="card-header"><?= __("Inventory")?></div>
            <div class="card-body inventory-icons">
                <?php echo $this->element('Room/ship_token')?>
            </div>
            <div class="card-footer">
                <?= __("Quantity") ?> : <span class="inventory-count"></span>
            </div>
            <?php if ($account == $member->account): ?>
                <div class="card-footer"><?= __("Backlog Of Orders")?>：<span class="num-backlog-order"></span></div>
            <?php endif ?>
        </div>
    </div>
    <!-- 発注受領エリア -->
    <div class="col-4 card-col">
        <!-- 発注エリア -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <?php if ($member->unit == 'Factory'): ?>
                        <?= __("Production Request")?>
                    <?php else: ?>
                        <?= __("Purchasing")?>
                    <?php endif ?>
                </div>
                <div class="card-body">
                    <?php if ($isMyUnit):?>
                        <div class="input-group">
                            <input type="number" class="form-control" name="num-of-purchasing">
                            <button type="button" class="btn btn-primary btn-send" disabled>4.<?= __('Send')?></button>
                        </div>
                    <?php endif?>
                </div>
            </div>
        </div>
        <!-- 受領エリア -->
        <div class="col-12 card-col">
            <div class="card">
                <div class="card-header">
                    <?php if ($member->unit == 'Factory'): ?>
                        <?= __("In production")?>
                    <?php else: ?>
                        <?= __("Shipping")?>
                    <?php endif ?>
                </div>
                <div class="card-body ship-icons">
                    <?php echo $this->element('Room/ship_token')?>
               </div>
                <div class="card-footer">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-6 col-sm-12">
                            <?= __("Quantity") ?> : <span class="shipping-count"></span>
                        </div>
                        <?php if ($isMyUnit): ?>
                        <div class="col-md-6 col-sm-12 text-end">
                            <button class="btn btn-primary btn-receipt" disabled>1.<?= __('Receipt')?></button>
                        </div>
                        <?php endif?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>