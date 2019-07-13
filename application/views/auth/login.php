<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="ua">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?php echo $this->config->item('site_version'); ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/semantic.min.css'); ?>">
    <script type="text/javascript" src="<?php echo base_url("assets/js/jquery-3.3.1.min.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/semantic.min.js');?>"></script>
    <style type="text/css">
        body {
            background-color: #DADADA;
        }
        body > .grid {
            height: 100%;
        }
        .image {
            margin-top: -100px;
        }
        .column {
            max-width: 450px;
        }
    </style>
</head>
<body>

<div class="ui middle aligned center aligned grid">
    <div class="column">
        <h2 class="ui teal image header">
            <div class="content">
                Введите свой логин/пароль.
            </div>
        </h2>

        <?php echo form_open("auth/login", "class='ui large form'");?>
            <div class="ui stacked segment">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="identity" id="identity" placeholder="E-mail address">
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password" id="password" placeholder="Password">
                    </div>
                </div>
                <button class="ui fluid large teal submit button" type="submit">Войти</button>
            </div>

            <div id="infoMessage"><?php echo $message;?></div>
         <?php echo form_close();?>
    </div>
</div>

</body>
</html>
