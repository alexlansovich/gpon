<?php
if ($ont) {
?>
<table class="ui selectable celled table">
  <thead>
    <tr>
      <th>Название</th>
      <th>Порт</th>
      <th>ONT id</th>
      <th>ONT-MAC</th>
      <th>Пользователь</th>
      <th>Действие</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($ont as $item)
  {
      echo '<tr>';
      echo '<td>'.$item['name'].'</td >';
      echo '<td>'.$item['port_alias'].'</td >';
      echo '<td>'.$item['ont_index'].'</td >';
      if (stristr($item['ont_mac'], $search) !== false) {
          $words = preg_split('/('.$search.')/i', $item['ont_mac'], 0, PREG_SPLIT_DELIM_CAPTURE);
          echo '<td><strong>';
          foreach ($words as $word)
          {
              if (!strcasecmp($word, $search)) echo '<font color=red>'.$word.'</font>';
              else echo $word;
          }
          echo '</strong></td >';
      }
      else echo '<td>'.$item['ont_mac'].'</td >';
      if (stristr($item['ont_desc'], $search) !== false) {
          $words = preg_split('/('.$search.')/i', $item['ont_desc'], 0, PREG_SPLIT_DELIM_CAPTURE);
          echo '<td><strong>';
          foreach ($words as $word)
          {
              if (!strcasecmp($word, $search)) echo '<font color=red>'.$word.'</font>';
              else echo $word;
          }
          echo '</strong></td >';
      }
      else echo '<td>'.$item['ont_desc'].'</td >';
      echo '<td>';
      echo anchor('device/view_ont/'.$item['ont_id'], '<i class="green eye icon"></i>');
      echo '&nbsp;&nbsp;&nbsp;&nbsp;';
      echo anchor('device/unregister/'.$item['ont_id'], '<i class="red trash alternate icon"></i>', 'onClick="javascript:return confirm(\'Удалить ONT?\')"Delete');
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
    echo '<h1 class="ui red header">'.$search.' - не найдено</h1>';
}

?>

