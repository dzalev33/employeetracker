<?php
//base controller

//this will load the models and views

class Controller {
    //load model
    public function model($model){

        //require model file
        require_once '../app/models/' . $model . '.php';

        return new $model;
    }

    //load view
    public function view($view, $data = []){

        //check for a view file
        if (file_exists('../app/views/' . $view . '.php')){

            require_once '../app/views/' . $view . '.php';

        }else{
            //view does not exist
            die('view not found');
        }

    }
}