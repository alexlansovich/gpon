<?php

?>
<?php echo form_error('svlan', '<div class="ui red message">', '</div>'); ?>
<h1 class="ui header"><?php echo $interface['ifName']; ?></h1>
<form class="ui form" method="POST" action="/device/edit/<?php echo $interface['id_device']?>/interface/<?php echo $interface['id']?>" autocomplete="off">
    <div class="field">
        <label>SVLAN</label>
        <input type="text" name="svlan" maxlength="100" placeholder="SVLAN"
               value="<?php echo $interface['svlan']; ?>">
    </div>
    <button class="ui primary button" type="submit">Редактировать</button>
</form>