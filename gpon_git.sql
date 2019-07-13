--
-- База данных: `gpon_git`
--

-- --------------------------------------------------------

--
-- Структура таблицы `device`
--

CREATE TABLE `device` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `ip` int(11) UNSIGNED NOT NULL,
  `snmp_read` varchar(50) NOT NULL,
  `snmp_write` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `device_type` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `server_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `device__types`
--

CREATE TABLE `device__types` (
  `id_type` int(11) NOT NULL,
  `device_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `device__types`
--

INSERT INTO `device__types` (`id_type`, `device_type`) VALUES
(1, 'Huawei'),
(2, 'BDCOM');

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'support', 'support'),
(3, 'admins', 'admins'),
(6, 'manager', 'manager');

-- --------------------------------------------------------

--
-- Структура таблицы `interfaces`
--

CREATE TABLE `interfaces` (
  `id` int(11) NOT NULL,
  `id_device` int(11) NOT NULL,
  `if_index` int(11) NOT NULL,
  `if_real_index` bigint(20) NOT NULL,
  `ifName` varchar(100) NOT NULL,
  `svlan` smallint(5) UNSIGNED DEFAULT NULL,
  `cvlan_start` smallint(5) UNSIGNED DEFAULT NULL,
  `service_start` int(10) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `interfaces__tpl`
--

CREATE TABLE `interfaces__tpl` (
  `id` int(11) NOT NULL,
  `if_index` int(11) NOT NULL,
  `if_real_index` bigint(20) NOT NULL,
  `ifName` varchar(100) NOT NULL,
  `cvlan_start` smallint(5) UNSIGNED DEFAULT NULL,
  `service_start` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `interfaces__tpl`
--

INSERT INTO `interfaces__tpl` (`id`, `if_index`, `if_real_index`, `ifName`, `cvlan_start`, `service_start`) VALUES
(1, -100663296, 4194304000, 'GPON 0/0/0', 2100, 0),
(2, -100663040, 4194304256, 'GPON 0/0/1', 2228, 128),
(3, -100662784, 4194304512, 'GPON 0/0/2', 2356, 256),
(4, -100662528, 4194304768, 'GPON 0/0/3', 2484, 384),
(5, -100662272, 4194305024, 'GPON 0/0/4', 2612, 512),
(6, -100662016, 4194305280, 'GPON 0/0/5', 2740, 640),
(7, -100661760, 4194305536, 'GPON 0/0/6', 2868, 768),
(8, -100661504, 4194305792, 'GPON 0/0/7', 2996, 896),
(9, -100661248, 4194306048, 'GPON 0/0/8', 2100, 1024),
(10, -100660992, 4194306304, 'GPON 0/0/9', 2228, 1152),
(11, -100660736, 4194306560, 'GPON 0/0/10', 2356, 1280),
(12, -100660480, 4194306816, 'GPON 0/0/11', 2484, 1408),
(13, -100660224, 4194307072, 'GPON 0/0/12', 2612, 1536),
(14, -100659968, 4194307328, 'GPON 0/0/13', 2740, 1664),
(15, -100659712, 4194307584, 'GPON 0/0/14', 2868, 1792),
(16, -100659456, 4194307840, 'GPON 0/0/15', 2996, 1920),
(17, -100655104, 4194312192, 'GPON 0/1/0', 2100, 4096),
(18, -100654848, 4194312448, 'GPON 0/1/1', 2228, 4224),
(19, -100654592, 4194312704, 'GPON 0/1/2', 2356, 4352),
(20, -100654336, 4194312960, 'GPON 0/1/3', 2484, 4480),
(21, -100654080, 4194313216, 'GPON 0/1/4', 2612, 4608),
(22, -100653824, 4194313472, 'GPON 0/1/5', 2740, 4736),
(23, -100653568, 4194313728, 'GPON 0/1/6', 2868, 4864),
(24, -100653312, 4194313984, 'GPON 0/1/7', 2996, 4992),
(25, -100653056, 4194314240, 'GPON 0/1/8', 2100, 5120),
(26, -100652800, 4194314496, 'GPON 0/1/9', 2228, 5248),
(27, -100652544, 4194314752, 'GPON 0/1/10', 2356, 5376),
(28, -100652288, 4194315008, 'GPON 0/1/11', 2484, 5504),
(29, -100652032, 4194315264, 'GPON 0/1/12', 2612, 5632),
(30, -100651776, 4194315520, 'GPON 0/1/13', 2740, 5760),
(31, -100651520, 4194315776, 'GPON 0/1/14', 2868, 5888),
(32, -100651264, 4194316032, 'GPON 0/1/15', 2996, 6016),
(33, -100646912, 4194320384, 'GPON 0/2/0', 2100, 8192),
(34, -100646656, 4194320640, 'GPON 0/2/1', 2228, 8320),
(35, -100646400, 4194320896, 'GPON 0/2/2', 2356, 8448),
(36, -100646144, 4194321152, 'GPON 0/2/3', 2484, 8576),
(37, -100645888, 4194321408, 'GPON 0/2/4', 2612, 8704),
(38, -100645632, 4194321664, 'GPON 0/2/5', 2740, 8832),
(39, -100645376, 4194321920, 'GPON 0/2/6', 2868, 8960),
(40, -100645120, 4194322176, 'GPON 0/2/7', 2996, 9088),
(41, -100644864, 4194322432, 'GPON 0/2/8', 2100, 9216),
(42, -100644608, 4194322688, 'GPON 0/2/9', 2228, 9344),
(43, -100644352, 4194322944, 'GPON 0/2/10', 2356, 9472),
(44, -100644096, 4194323200, 'GPON 0/2/11', 2484, 9600),
(45, -100643840, 4194323456, 'GPON 0/2/12', 2612, 9728),
(46, -100643584, 4194323712, 'GPON 0/2/13', 2740, 9856),
(47, -100643328, 4194323968, 'GPON 0/2/14', 2868, 9984),
(48, -100643072, 4194324224, 'GPON 0/2/15', 2996, 10112),
(49, -100638720, 4194328576, 'GPON 0/3/0', 2100, 12288),
(50, -100638464, 4194328832, 'GPON 0/3/1', 2228, 12416),
(51, -100638208, 4194329088, 'GPON 0/3/2', 2356, 12544),
(52, -100637952, 4194329344, 'GPON 0/3/3', 2484, 12672),
(53, -100637696, 4194329600, 'GPON 0/3/4', 2612, 12800),
(54, -100637440, 4194329856, 'GPON 0/3/5', 2740, 12928),
(55, -100637184, 4194330112, 'GPON 0/3/6', 2868, 13056),
(56, -100636928, 4194330368, 'GPON 0/3/7', 2996, 13184),
(57, -100636672, 4194330624, 'GPON 0/3/8', 2100, 13312),
(58, -100636416, 4194330880, 'GPON 0/3/9', 2228, 13440),
(59, -100636160, 4194331136, 'GPON 0/3/10', 2356, 13568),
(60, -100635904, 4194331392, 'GPON 0/3/11', 2484, 13696),
(61, -100635648, 4194331648, 'GPON 0/3/12', 2612, 13824),
(62, -100635392, 4194331904, 'GPON 0/3/13', 2740, 13952),
(63, -100635136, 4194332160, 'GPON 0/3/14', 2868, 14080),
(64, -100634880, 4194332416, 'GPON 0/3/15', 2996, 14208),
(65, -100630528, 4194336768, 'GPON 0/4/0', 2100, 16384),
(66, -100630272, 4194337024, 'GPON 0/4/1', 2228, 16512),
(67, -100630016, 4194337280, 'GPON 0/4/2', 2356, 16640),
(68, -100629760, 4194337536, 'GPON 0/4/3', 2484, 16768),
(69, -100629504, 4194337792, 'GPON 0/4/4', 2612, 16896),
(70, -100629248, 4194338048, 'GPON 0/4/5', 2740, 17024),
(71, -100628992, 4194338304, 'GPON 0/4/6', 2868, 17152),
(72, -100628736, 4194338560, 'GPON 0/4/7', 2996, 17280),
(73, -100628480, 4194338816, 'GPON 0/4/8', 2100, 17408),
(74, -100628224, 4194339072, 'GPON 0/4/9', 2228, 17536),
(75, -100627968, 4194339328, 'GPON 0/4/10', 2356, 17664),
(76, -100627712, 4194339584, 'GPON 0/4/11', 2484, 17792),
(77, -100627456, 4194339840, 'GPON 0/4/12', 2612, 17920),
(78, -100627200, 4194340096, 'GPON 0/4/13', 2740, 18048),
(79, -100626944, 4194340352, 'GPON 0/4/14', 2868, 18176),
(80, -100626688, 4194340608, 'GPON 0/4/15', 2996, 18304),
(81, -100622336, 4194344960, 'GPON 0/5/0', 2100, 20480),
(82, -100622080, 4194345216, 'GPON 0/5/1', 2228, 20608),
(83, -100621824, 4194345472, 'GPON 0/5/2', 2356, 20736),
(84, -100621568, 4194345728, 'GPON 0/5/3', 2484, 20864),
(85, -100621312, 4194345984, 'GPON 0/5/4', 2612, 20992),
(86, -100621056, 4194346240, 'GPON 0/5/5', 2740, 21120),
(87, -100620800, 4194346496, 'GPON 0/5/6', 2868, 21248),
(88, -100620544, 4194346752, 'GPON 0/5/7', 2996, 21376),
(89, -100620288, 4194347008, 'GPON 0/5/8', 2100, 21504),
(90, -100620032, 4194347264, 'GPON 0/5/9', 2228, 21632),
(91, -100619776, 4194347520, 'GPON 0/5/10', 2356, 21760),
(92, -100619520, 4194347776, 'GPON 0/5/11', 2484, 21888),
(93, -100619264, 4194348032, 'GPON 0/5/12', 2612, 22016),
(94, -100619008, 4194348288, 'GPON 0/5/13', 2740, 22144),
(95, -100618752, 4194348544, 'GPON 0/5/14', 2868, 22272),
(96, -100618496, 4194348800, 'GPON 0/5/15', 2996, 22400);

-- --------------------------------------------------------

--
-- Структура таблицы `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `oid__iftype`
--

CREATE TABLE `oid__iftype` (
  `id` int(11) NOT NULL,
  `oid` varchar(100) NOT NULL,
  `name` varchar(30) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `oid__iftype`
--

INSERT INTO `oid__iftype` (`id`, `oid`, `name`, `active`) VALUES
(1, '1.3.6.1.2.1.2.2.1.1', 'ifIndex', 1),
(2, '1.3.6.1.2.1.2.2.1.2', 'ifDescr', 0),
(3, '1.3.6.1.2.1.2.2.1.3', 'ifType', 0),
(5, '1.3.6.1.2.1.2.2.1.5', 'ifSpeed', 1),
(7, '1.3.6.1.2.1.2.2.1.7', 'ifAdminStatus', 1),
(8, '1.3.6.1.2.1.2.2.1.8', 'ifOperStatus', 1),
(9, '1.3.6.1.2.1.2.2.1.9', 'ifLastChange', 1),
(20, '1.3.6.1.2.1.31.1.1.1.1', 'ifName', 1),
(21, '1.3.6.1.2.1.31.1.1.1.15', 'ifHighSpeed', 0),
(22, '1.3.6.1.2.1.31.1.1.1.18', 'ifAlias', 1),
(23, '1.3.6.1.2.1.31.1.1.1.17', 'ifConnectorPresent', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `oid__ont`
--

CREATE TABLE `oid__ont` (
  `id` int(11) NOT NULL,
  `oid` varchar(100) NOT NULL,
  `port` varchar(10) DEFAULT NULL,
  `divide` int(11) DEFAULT NULL,
  `minus` int(11) DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `order_by` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Дамп данных таблицы `oid__ont`
--

INSERT INTO `oid__ont` (`id`, `oid`, `port`, `divide`, `minus`, `name`, `order_by`, `active`) VALUES
(1, '1.3.6.1.4.1.2011.6.128.1.1.2.43.1.7', NULL, NULL, NULL, 'Линейный профайл', 12, 1),
(2, '1.3.6.1.4.1.2011.6.128.1.1.2.62.1.22', '.1', NULL, NULL, 'Статус eth порта (1 онлайн, 3 офлайн)', 8, 1),
(3, '1.3.6.1.4.1.2011.6.128.1.1.2.62.1.3', '.1', NULL, NULL, 'Duplex eth порта (5 - Full, 4-Half, 3 офлайн)', 9, 1),
(4, '1.3.6.1.4.1.2011.6.128.1.1.2.62.1.21', '.1', NULL, NULL, 'Type eth порта (34=1G, 24=100m, офлайн -1)', 10, 1),
(5, '1.3.6.1.4.1.2011.6.128.1.1.2.51.1.3', NULL, 100, NULL, 'ONT Tx optical power, dBm', 3, 1),
(6, '1.3.6.1.4.1.2011.6.128.1.1.2.51.1.4', NULL, 100, NULL, 'ONT Rx optical power, dBm', 2, 1),
(7, '1.3.6.1.4.1.2011.6.128.1.1.2.51.1.6', NULL, 100, 100, 'OLT Rx ONT optical power, dBm', 1, 1),
(8, '1.3.6.1.4.1.2011.6.128.1.1.2.51.1.5', NULL, 1000, NULL, 'ONT Voltage, V', 4, 1),
(9, '1.3.6.1.4.1.2011.6.128.1.1.2.51.1.2', NULL, NULL, NULL, 'ONT Current, mA', 5, 1),
(10, '1.3.6.1.4.1.2011.6.128.1.1.2.51.1.1', NULL, NULL, NULL, 'ONT Temperature, градусов', 6, 1),
(11, '1.3.6.1.4.1.2011.6.128.1.1.2.46.1.20', NULL, NULL, NULL, 'ONT Расстояние, метров', 7, 1),
(12, '1.3.6.1.4.1.2011.6.128.1.1.2.43.1.3', NULL, NULL, NULL, 'Получить данные Интерфейса - Оптического порта', 0, 0),
(13, '1.3.6.1.4.1.2011.6.128.1.1.2.45.1.4', NULL, NULL, NULL, 'ONT EquipmentID', 11, 1),
(14, '1.3.6.1.4.1.2011.6.128.1.1.2.43.1.8', NULL, NULL, NULL, 'Сервисный профайл', 13, 1),
(15, '1.3.6.1.4.1.2011.6.128.1.1.2.62.1.4', '.1', NULL, NULL, 'Speed eth порта (5 - 10, 6- 100, 7-1000 )', 9, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `ont`
--

CREATE TABLE `ont` (
  `id` int(11) NOT NULL,
  `id_device` int(11) NOT NULL,
  `port_index` bigint(20) NOT NULL,
  `port_alias` varchar(100) NOT NULL,
  `ont_index` int(11) NOT NULL,
  `ont_mac` varchar(100) NOT NULL,
  `ont_desc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `billing_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `billing_id`) VALUES
(1, '127.0.0.1', 'admin@admin.com', '$2y$12$KdHlDTx/zqYny8lvwXskf.6HZrL76pSQznAYgqGm/Z.PrTDLVnnxa', 'admin@admin.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1563008023, 1, 'Admin', 'Admin', 'ADMIN', '0', 53);

-- --------------------------------------------------------

--
-- Структура таблицы `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(31, 1, 1),
(32, 1, 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `device__types`
--
ALTER TABLE `device__types`
  ADD PRIMARY KEY (`id_type`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `interfaces`
--
ALTER TABLE `interfaces`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `interfaces__tpl`
--
ALTER TABLE `interfaces__tpl`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `oid__iftype`
--
ALTER TABLE `oid__iftype`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `oid__ont`
--
ALTER TABLE `oid__ont`
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `ont`
--
ALTER TABLE `ont`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_email` (`email`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`);

--
-- Индексы таблицы `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `device`
--
ALTER TABLE `device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT для таблицы `device__types`
--
ALTER TABLE `device__types`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `interfaces`
--
ALTER TABLE `interfaces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `interfaces__tpl`
--
ALTER TABLE `interfaces__tpl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT для таблицы `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `oid__iftype`
--
ALTER TABLE `oid__iftype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT для таблицы `oid__ont`
--
ALTER TABLE `oid__ont`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT для таблицы `ont`
--
ALTER TABLE `ont`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT для таблицы `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
