<?php

if ($interfaces_tpl) {

?>
<h1 class="ui header"><?php echo $device['name']; ?> </h1>

<table class="ui selectable celled table">
    <thead>
    <tr>
        <th>if_index</th>
        <th>if_real_index</th>
        <th>ifName</th>
        <th>ifOperStatus</th>
        <th>ifLastChange</th>
        <th>Cvlan start</th>
        <th>Service start</th>
        <th>Присутствует</th>
    </tr>
    </thead>
    <tbody>
  <?php

  foreach ($interfaces_tpl as $item) {
      // $key  поиск наличия такой записи в таблице опроса устройства
      $key = array_search ($item['if_index'], array_column ($interfaces, 'ifIndex'));
      echo '<td>' .$item['if_index'] . '</td >';
      echo '<td>' .$item['if_real_index'] . '</td >';
      echo '<td>' .$item['ifName'] . '</td >';
      if ($key) echo '<td>' .$interfaces[$key]['ifOperStatus'] . '</td >';
      else echo '<td>не установлен</td >';
      if ($key) echo '<td>' .$interfaces[$key]['ifLastChange'] . '</td >';
      else echo '<td>не установлен</td >';
      echo '<td>' .$item['cvlan_start'] . '</td >';
      echo '<td>' .$item['service_start'] . '</td >';
      if ($key) echo '<td>есть</td >';
      else echo '<td>не установлен</td >';
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
