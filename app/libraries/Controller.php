<?php
//load the model and the view
class Controller{
    public function model($model){
        // to require models
        require_once '../app/models/' . $model . '.php';
        //instantiate model
        return new $model();
    }

    // load the views 
    public function view($view, $data = []){
        if(file_exists('../app/views/' . $view . '.php')){
            require_once '../app/views/' . $view . '.php';
        }else{
            die("View does not exist.");
        }
    }
}