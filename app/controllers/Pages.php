<?php
/* 
    * Each controller will inherit the parent controller which is named Controller.php. 
    * This is an example of pure inheritance, that each child controller inherits the parents properties and methods.
    * The Access Modifiers will have to be protected or public in order to inherit the properites and methods
*/

class Pages extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $users = $this->userModel->getUsers();

        $data = [
            'users' => $users,
        ];
        $this->view('pages/index', $data);
    }

    public function about()
    {
        $this->view('pages/about');
    }
}