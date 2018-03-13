<?php

Config::set('site_name', 'Site Name');

Config::set('routes', array(
    'default' => '',
    'admin' => 'admin_',
));

Config::set('default_route', 'default');
Config::set('default_controller', 'films');
Config::set('default_action', 'index');

//для подключения к базе данных

Config::set('db.host', 'localhost');
Config::set('db.user', 'root');
Config::set('db.password', '');
Config::set('db.db_name', 'filmgallery');

//соль

Config::set('salt', 'jd7sj3sdkd964he7e');
?>
