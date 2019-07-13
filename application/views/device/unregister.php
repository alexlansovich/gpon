<?php
// Выводим vardump ошибок для понимания ситуаций
error_reporting(0);
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
            <p>
                удаление успешно
                <?php //echo $desc.' - HUAWEI - 0/'.$gpon_id.'/'.$port_id.':'.$ont_id.' s/n:'.$ont; ?>
            </p>
        </div>
    </div>
    <?php
}
?>




