<?php
/*
    this is our core class
    It Creates url and loads core controller
*/

class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
            //print_r($this->getUrl());
        $url = $this->getUrl();

        //search in controllers for first value
        if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){
            //if exists then set it as controller
            $this->currentController = ucwords($url[0]);
            //unset zero index
            unset($url[0]);

        }

        //require the curent  controller
        require_once '../app/controllers/' . $this->currentController . '.php';

        //instaciate it
        $this->currentController = new $this->currentController;

    }

    public function getUrl(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}