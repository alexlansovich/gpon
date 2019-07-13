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
        <th>signal</th>
        <th>status</th>
        <th>run</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($registered as $key => $item)
    {
        if (strlen($item['value']) < 16)  $item['value'] = strtoupper(bin2hex($item['value']));
        if (($item['status']=='24') or ($item['status']=='34')) echo '<tr class="positive">';
        else  echo '<tr class="negative">';
        echo '<td>'.$item['if_alias'].'</td >';
        echo '<td>'.$item['ont_index'].'</td >';
        echo '<td>'.$item['value'].'</td >';
        echo '<td>'.$item['desc'].'</td >';
        if (($item['status']=='24') or ($item['status']=='34'))
        {
            echo '<td>'.$item['signal'].'</td >';
            echo '<td>Online</td >';
        }
        else
        {
            echo '<td>Offline</td >';
            echo '<td>Offline</td >';
        }

        echo '<td>';
        echo anchor('device/view_ont_iface/'.$interface['id_device'].'/'.$interface['if_real_index'].'/'.$item['ont_index'], '<i class="green eye icon"></i>');
        echo '</td >';
        echo '</tr >';
    }
    ?>
    </tbody >
</table >
