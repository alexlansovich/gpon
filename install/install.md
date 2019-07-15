## Установка:

1. Скачать все файлы в директорию Вашего веб-сервера;
2. Импортировать базу данных из файла [install/gpon_git.sql](install/gpon_git.sql);
3. Изменить параметр в файле application/config/config.php $config['base_url'] = 'http://URL';
4. Изменить параметры подключения к базе данных в файле application/config/database.php в переменных 'username' => 'DB_USER' и 'password' => 'DB_PASSWORD';
5. Для доступа авторизации используется логин admin@admin.com, пароль password;
6. При необходимости установить модуль php-snmp
7. При необходимости настроить snmp на сервере, создав пустой файл /etc/snmp/snmp.conf

## Работа с пользователями:
Есть 4 группы пользователей  
1. admin - имеет полный доступ;
2. support - имеет доступ к просмотру устройства, клиентов;
3. manager - имеет доступ к просмотру устройства, клиентов, может регистрировать и удалять ont;
4. admins - имеет доступ к просмотру устройства, клиентов, может регистрировать и удалять ont, добавлять/изменять/удалять устройства;  
По умолчанию пользователь создается с группой support. Пользователю можно применить несколько групп

## Настройка устройства OLT
1. Первоначальная настройка OLT должны быть произведена аналогично конфигурации в файле [install/basic_olt_cfg.txt](install/basic_olt_cfg.txt);
2. Если сделать импорт данного конфига, OLT будет грузитсья 30-40 минут;
3. Можно воспользоваться геренатором line-profiles скриптом [install/olt_config_gen.pl](install/olt_config_gen.pl) c параметрами запуска
``` ./olt_config_gen.pl ip_olt username password```

## Использование
1. Добавить устройство, указав все параметры  
type установить "1" - Ipoe - это QnQ по схеме влан на абонента (vlan per user)  
type установить "2" - dhcp - все абоненты находятся в одном влане  
device_type - установить "1" Huawei(на Bdcom пока не реализовано)
2. После добавления нажать на устройство - будет предложено инициализировать все интерфейсы устройства, согласно установленных плат в шасси.
3. Для просомотра незарегистрированных ONT нажать "Показать unreg ONT"
4. Для регистрации ONT написать примечание латинскими буквами и нажать "Зарегистрировать"  
## Логика регистрации ONT в QnQ режиме 
1. Регистрируется ONT c дефолтным line-profile чтобы получить ID зарегистрированной ONT  
```ont add $port_id sn-auth $ont omci ont-lineprofile-id 1 ont-srvprofile-id 1 desc $desc```
2. Изменяется line-profile согласно необходимого влана  
```ont modify $port_id $ont_id ont-lineprofile-id $cvlan```
3. Назначается pvid  
```ont port native-vlan $port_id $ont_id eth 1 vlan $cvlan priority 0```
4. Создается service-port  
```service-port $service vlan $svlan gpon 0/$gpon_id/$port_id ont $ont_id gemport 1 multi-service user-vlan $cvlan tag-transform translate-and-add inner-vlan $cvlan inner-priority 0```
## Логика регистрации ONT в DHCP режиме 
1. Регистрируется ONT c фиксированным line-profile чтобы получить ID зарегистрированной ONT  
```ont add $port_id sn-auth $ont omci ont-lineprofile-id 1109 ont-srvprofile-id 1109 desc $desc```
2. Назначается pvid  
```ont port native-vlan $port_id $ont_id eth 1 vlan $cvlan priority 0```
3. Создается service-port  
```service-port $service vlan $cvlan gpon 0/$gpon_id/$port_id ont $ont_id gemport 1 multi-service user-vlan $cvlan tag-transform translate```
## В данной версии ONT не заносятся в базу данных при регистрации/удалении
Для этого после регистрации/удаления необходимо нажать "Синхронизировать ONT"
