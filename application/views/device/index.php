<?php

?>
<table class="ui selectable celled table">
  <thead>
    <tr>
      <th>Название</th>
      <th>IP</th>
      <th>Тип подключения</th>
      <th>Тип устройства</th>
      <th>Действие</th>
    </tr>
  </thead>
  <tbody>

  <?php foreach ($device as $item)
  {
     echo '<tr>';
      echo '<td>'.anchor('device/view/'.$item['id'], $item['name']).'</td >';
      echo '<td>'.long2ip($item['ip']).'</td >';
      if ($item['type'] == 1)
      echo '<td>IPoE</td >';
      else echo '<td>DCHP</td >';
      echo '<td>'.$item['device_type'].'</td >';
      echo '<td>';
      echo anchor('device/edit/'.$item['id'], '<i class="green edit outline icon"></i>');
      echo anchor('device/delete/'.$item['id'], '<i class="red trash alternate icon"></i>', 'onClick="javascript:return confirm(\'Удалить устройство?\')"Delete');
      echo '</td >';
     echo '</tr >';
    }
?>
  </tbody >
</table >



