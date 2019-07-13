<?php

?>
<?php echo form_error('name', '<div class="ui red message">', '</div>'); ?>
<?php echo form_error('ip', '<div class="ui red message">', '</div>'); ?>
<?php echo form_error('snmp_read', '<div class="ui red message">', '</div>'); ?>
<?php echo form_error('snmp_write', '<div class="ui red message">', '</div>'); ?>
<?php echo form_error('login', '<div class="ui red message">', '</div>'); ?>
<?php echo form_error('password', '<div class="ui red message">', '</div>'); ?>

<form class="ui form" method="POST" action="/device/edit/<?php echo $device['id']?>" autocomplete="off">
    <div class="field">
        <label>Название устройства</label>
        <input type="text" name="name" maxlength="100" placeholder="Название устройства"
            value="<?php echo $device['name']; ?>">
    </div>
    <div class="field">
        <label>IP</label>
        <input type="text" name="ip" maxlength="100" placeholder="IP"
               value="<?php echo long2ip($device['ip']); ?>">
    </div>
    <div class="field">
        <label>SNMP read</label>
        <input type="text" name="snmp_read" maxlength="100" placeholder="SNMP read"
               value="<?php echo $device['snmp_read']; ?>">
    </div>
    <div class="field">
        <label>SNMP write</label>
        <input type="text" name="snmp_write" maxlength="100" placeholder="SNMP write"
               value="<?php echo $device['snmp_read']; ?>">
    </div>
    <div class="field">
        <label>login</label>
        <input type="text" name="login" maxlength="100" placeholder="login"
               value="<?php echo $device['login']; ?>">
    </div>
    <div class="field">
        <label>password</label>
        <input type="text" name="password" maxlength="100" placeholder="password"
               value="<?php echo $device['password'];  ?>">
    </div>
    <div class="field">
        <label>type(1 - Ipoe or 2 - dhcp)</label>
        <input type="text" name="type" maxlength="100" placeholder="type(1 - IPoE or 2 - DHCP)"
               value="<?php echo $device['type'];  ?>">
    </div>
    <button class="ui primary button" type="submit">Редактировать</button>
</form>