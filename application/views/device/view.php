<?php

if ($interfaces) {

?>
<h1 class="ui header"><?php echo $device['name']; ?> </h1>

<form action="/device/registered/<?php echo $device['id']?> ">
<button class="ui compact labeled icon button" type="submit">
  <i class="sync alternate icon"></i>
  Синхронизировать ONT
</button>
</form>

<table class="ui selectable celled table">
    <thead>
    <tr>
        <th>ifName</th>
        <th>ifAlias</th>
        <th>ifOperStatus</th>
        <th>ifSignal</th>
        <th>Svlan</th>
        <th>Cvlan start</th>
        <th>Service start</th>
        <th>Действие</th>
    </tr>
    </thead>
    <tbody>
  <?php

  foreach ($interfaces as $item) {

      if ($item['ifOperStatus'] == 'up') echo '<tr class="positive">';
      else  echo '<tr class="negative">';
      echo '<td>' . anchor('device/view/'.$id_device.'/interface/'.$item['id'], $item['ifName']) .'</td >';
      echo '<td>' .$item['ifAlias'] . '</td >';
      echo '<td>' .$item['ifOperStatus'] . '</td >';
      echo '<td>' .$item['ifSignal'] . '</td >';
      echo '<td>' .$item['svlan'] . '</td >';
      echo '<td>' .$item['cvlan_start'] . '</td >';
      echo '<td>' .$item['service_start'] . '</td >';
      echo '<td>' .anchor('device/edit/'.$id_device.'/interface/'.$item['id'], '<i class="green edit outline icon"></i>'). '</td >';
      echo '</td >';
      echo '</tr >';
  }
  ?>
  </tbody >
</table >


    <?php
}
else
{
    echo '<h1 class="ui red header">Устройство не настроено, нажмите "Создать интерфейсы"</h1>';
}

?>
