<?php
    session_start();
    require_once'app/core/Core.php';
    require_once'lib/Infonit/Database/Connection.php';
    require_once'app/controller/LoginController.php';
    require_once'app/controller/PainelController.php';
    require_once'app/controller/NoticiasController.php';
    require_once'app/controller/CadastroController.php';
    require_once'vendor/autoload.php';
    require_once'app/model/User.php';
    require_once'app/model/Noticias.php';
    $core = new Core;
    echo $core->start($_GET);