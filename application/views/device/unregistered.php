<?php

if ($unregistered) {
    ?>
    <h1 class="ui header">
        <?php anchor('device/view/'.$device['id'], $device['name']); ?>
    </h1>
    <table class="ui selectable celled table">
        <thead>
        <tr>
            <th>Номер</th>
            <th>Iface</th>
            <th>MAC</th>
            <th>Подпись</th>
        </tr>
        </thead>
        <tbody>

        <?php
        $i = 1;
        foreach ($unregistered as $item) {
            $ont_port = $if_aliases[$item['if_index']];
            $if_name = explode("/", $ont_port);
            $gpon = $if_name['1'];
            $port = $if_name['2'];
            echo '<tr>';

            echo '<td>' . $i . '</td >';
            echo '<td>' . $ont_port . '</td >';
            echo '<td>' . $item['mac'] . '</td >';
            echo '<td>';
            echo '<form class="ui form" method="POST" action="/device/register" autocomplete="off">';
            echo '<div class="ui input">';
            echo '<input type="text" name="desc" placeholder="введите подпись">';
            echo '<button class="ui primary button" type="submit">Зарегистрировать</button>';
            echo '</div>';
            echo '<div class="ui error message"></div>';
            echo '<input type="hidden" name="dev_id" value="' . $device['id'] . '">';
            echo '<input type="hidden" name="gpon_id" value="' . $gpon . '">';
            echo '<input type="hidden" name="port_id" value="' . $port . '">';
            echo '<input type="hidden" name="ont" value="' . $item['mac'] . '">';
            echo '</form>';
            echo '</td >';
            echo '</tr >';
            $i = $i+1;

        }


        ?>
        </tbody>
    </table>
    <?php
}
else
{
    echo '<h1 class="ui header">'.anchor('device/view/'.$device['id'], $device['name']).'</h1>';
    echo '<h1 class="ui red header">Пусто :( - Не найдено незарегистрированных ONT</h1>';
}

?>
<script>
    $('.ui.form').form({
        fields: {
            desc: {
                identifier: 'desc',
                rules: [{
                        type   : 'empty',
                        prompt : 'Введите подпись!'
                }]
            }
        }
    });
</script>



