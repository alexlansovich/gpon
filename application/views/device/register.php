<?php
// Выводим vardump ошибок для понимания ситуаций
var_dump($log);
if ($error)
{
    echo '<h4 class="ui red header">'.$error.'</h4>';

}
else
{
    ?>
    <div class="ui segments">
        <div class="ui segment">
            <p>Абонент - <?php echo $desc; ?></p>
        </div>
        <div class="ui secondary segment">
            <p>Добавлено примечание: <?php echo $desc.' - HUAWEI - 0/'.$gpon_id.'/'.$port_id.':'.$ont_id.' s/n:'.$ont; ?></p>
        </div>
        <!-- ОТКЛЮЧЕННЫЙ блок для Биллинга. Используйте свой код
        <div class="ui secondary segment">
            <p>Результат назначения вланов: <?php var_dump($billing_vlans_result) ?></p>
        </div>
        -->
    </div>
    <?php
}
?>




