<?php
// Core App class
class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl();

        //to look in controllers folder, ucwords will capitalize first letter
        if(isset($url[1])){
            if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        }

        }
        

        //Require the controller 
        require_once '../app/controllers/' .$this->currentController. '.php';
        $this->currentController = new $this->currentController;

        // check for the second parts no of the url and if the method exists
        if(isset($url[1])){
            if(method_exists($this->currentController, $url[1])){
                $this->currentMethod = $url[1];
                unset($url[1]);
                
            }
        }

        //get parameters
        $this->params = $url ? array_values($url) : [];

        //call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl(){

        if(isset($_GET['url'])){

            // to get rid of forward slash
            $url = rtrim($_GET['url'], '/');

            // to get rid of special characters
            $url = filter_var($url, FILTER_SANITIZE_URL);

            //to convert the url to an array
            $url = explode('/', $url);
            return $url;
        }
    }
}
