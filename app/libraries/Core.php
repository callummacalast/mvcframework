<?php
// Core App Class
class Core 
{
   protected $currentController = 'Pages';
   protected $currentMethod = 'index';
   protected $params = [];

   /* 
        * This constructor method is instantiated upon load, this handles all of the routing of the project.
        * Handling the corresponding controllers and methods within that controller
    */
     

   public function __construct()
   {
        $url = $this->getUrl();
        //  Look in controllers folder for first value and ucwords(); will capitalise first letter 
        if (isset($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            $this->currentController = ucwords($url[0]); // Setting the current controllers name to the name capitilised first letter
            unset($url[0]);   
        }

        // Require the controller
        require_once '../app/controllers/' . $this->currentController . '.php';
        // Taking the current controller and instantiating the controller class  
        $this->currentController = new $this->currentController;
        // This is checking for the second part of the URL
        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) { // Checking the seond part of the url which is the corresponding method from the controller class
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        //  Get params, if no params, keep it empty
        $this->params = $url ? array_values($url) : []; 

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
   }

     /* 
        * This function is getting the URL, and trimming the forward slash off at the end using rtrim(). 
        * The FILTER_SANITIZE_URL is allowing you to filter variables as a string/number. 
        * The explode() function is breaking the result into an array

        * E.g. $url = http://localhost:8888/mvcframework/shop/glasses/men. This would return "Array ( [0] => shop [1] => glasses [2] => men )"

    */

   public function getUrl()
   {
       if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');

            $url = filter_var($url, FILTER_SANITIZE_URL);

            $url = explode('/', $url);
            return $url;
        
       }
   }
}