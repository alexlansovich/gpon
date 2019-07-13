<?php
//если найдена ону
if ($ont_data) {
    // $key  поиск наличия такой записи в таблице опроса
    $key = array_search('4', array_column($ont_data, 'oid_id'));
    //var_dump($key);
    $ont_online = $ont_data[$key]['value'];
    if (($ont_online == '24') or ($ont_online == '34')) {

        ?>
        <h1 class="ui header">
            <?php echo anchor('device/view/'.$device['id'], $device['name']) . ' - ' .anchor('device/view/'.$device['id'].'/interface/'.$ont['port_index'], $ont['port_alias']) .  ' - ' . $ont['ont_mac']; ?>
        </h1>
        <table class="ui selectable celled table">
            <thead>
            <tr>
                <th>Название</th>
                <th>Значение</th>
            </tr>
            </thead>
            <tbody>
            <?php
            echo '<tr>';
            echo '<td>OLT Tx, dBm</td >';
            echo '<td>' . $olt_data / 100 . '</td >';
            echo '</tr >';

            foreach ($ont_data as $item) {
                echo '<tr>';
                echo '<td>' . $item['name'] . '</td >';
                if (!is_null($item['divide'])) $item['value'] = $item['value'] / $item['divide'];
                if (!is_null($item['minus'])) $item['value'] = $item['value'] - $item['minus'];
                if ($item['oid_id'] == '4') {
                    if ($item['value'] == '34') echo '<td>1 Gbit</td >';
                    elseif ($item['value'] == '24') echo '<td>100 Mbit</td >';
                    else  echo '<td>Offline</td >';
                }
                elseif ($item['oid_id'] == '3') {
                    if ($item['value'] == '5') echo '<td>Full Duplex</td >';
                    elseif ($item['value'] == '5') echo '<td class="negative">Half Duplex</td >';
                    else  echo '<td>Не известно('.$item['value'].')</td >';
                }
                elseif ($item['oid_id'] == '15') {
                    if ($item['value'] == '5') echo '<td class="negative">10 Mbit</td >';
                    elseif ($item['value'] == '6') echo '<td>100 Mbit</td >';
                    elseif ($item['value'] == '7') echo '<td>1 Gbit</td >';
                    else  echo '<td>Не известно('.$item['value'].')</td >';
                }
                else echo '<td>' . $item['value'] . '</td >';
                echo '</tr >';
            }

            ?>
            </tbody>
        </table>


        <?php
    }
    else
    {
        ?>
        <h1 class="ui header">
            <?php echo anchor('device/view/'.$device['id'], $device['name']) . ' - ' . $ont['ont_mac']; ?> - Offline
        </h1>
        <?php
    }
    //ont log
    ?>
    <h1 class="ui header">
        LOG
    </h1>
    <table class="ui selectable celled table">
    <thead>
    <tr>
        <th>Время</th>
        <th>Статус</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i = 0; $i <= 9; $i++) {
        if (!trim($log_up[$i], '"')=='') {
            echo '<tr class="positive">';
            echo '<td>' . date("Y-m-d H:i:s",strtotime(trim($log_up[$i], '"'))) . '</td >';
            echo '<td>UP</td >';
            echo '</tr>';
        }
        if (!trim($log_down[$i], '"')=='') {
            echo '<tr class="negative">';
            echo '<td>' . date("Y-m-d H:i:s",strtotime(trim($log_down[$i], '"'))) . ' - причина ';
            switch ($log_couse[$i]){
                case 13:
                    echo "по питанию";
                    break;
                case 2:
                    echo "по оптике";
                    break;
                default:
                    echo "другое ".$log_couse[$i];
            }
            echo '</td >';
            echo '<td>DOWN</td >';
            echo '</tr>';
        }
    }
    ?>
    </tbody>
    </table>
    <?php
}
else
{
    echo '<h1 class="ui red header">Устройство не настроено, нажмите "Создать интерфейсы"</h1>';
}

?>
