<?php

//load config
require_once 'config/config.php';

//autoload Core Libraries
spl_autoload_register(function ($className){
    require_once 'libraries/'. $className.'.php';
});