<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="ua">
<head>
    <meta charset="UTF-8">
    <title><?php echo $this->config->item('site_version'); ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/semantic.min.css'); ?>">
    <script type="text/javascript" src="<?php echo base_url("assets/js/jquery-3.3.1.min.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/semantic.min.js');?>"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <script>
        $(document).ready(function(){
            $("input").attr("autocomplete", "none");
        });
    </script>
</head>
<body>


<div class="ui attached stackable menu">
    <div class="ui container">
        <a class="item" href="<?php echo site_url(); ?>">
            <i class="home icon"></i>Главная
        </a>

        <div class="right menu">
            <form action="/search" method="POST">
            <div class="ui icon input">
                <input type="text" name="search" placeholder="поиск..." autocomplete="off">
                <i class="search icon"></i>
            </div>
            </form>
        </div>
            <?php
            if ($this->ion_auth->is_admin())
            {
                echo anchor('auth', 'Админ', 'class="active blue item"');
            }
            if ($this->ion_auth->logged_in())
            {
                echo anchor('auth/logout', 'Выход', 'class="active red item"');
            }

            ?>
    </div>

</div>
<div class="ui container">
    <p>
