<label for="auth_name"><?= __('Auth Name')?></label>
<select id="auth_name" name="auth_name">
    <?php foreach($authorities as $authority):?>
        <option value="<?= h($authority['auth_name'])?>" <?php if ($authority['auth_name'] == $authName) {echo("selected");} ?>><?= h($authority['auth_name'])?></option>
    <?php endforeach?>
</select>