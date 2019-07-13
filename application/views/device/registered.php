<?php
echo '<h1 class="ui header">';
echo anchor('device/view/'.$device['id'], $device['name']);
echo '</h1>';
?>
<table class="ui selectable celled table">
  <thead>
    <tr>
      <th>iface</th>
      <th>id</th>
      <th>mac</th>
      <th>desc</th>
    </tr>
  </thead>
  <tbody>

  <?php foreach ($registered as $key => $item)
  {
      if (strlen($item['value']) < 16)  $item['value'] = strtoupper(bin2hex($item['value']));
     echo '<tr>';
     echo '<td>'.$item['if_alias'].'</td >';
     echo '<td>'.$item['ont_index'].'</td >';
     echo '<td>'.$item['value'].'</td >';
     echo '<td>'.$item['desc'].'</td >';
     //todo добавить возможность просмотра информации с этой страницы
     //echo '<td>';
     //echo anchor('device/view_ont/'.$item['ont_id'], '<i class="green eye icon"></i>');
     //echo '</td >';
     echo '</tr >';
    }
?>
  </tbody >
</table >



