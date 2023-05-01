<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\HandlerLogin;


class HomeController extends Controller {

    private $loggedUser;

    public function __construct() {
        $this->loggedUser = HandlerLogin::checkLogin();
        if(HandlerLogin::checkLogin( == false)){
            $this->redirect('/login');
        }


        $this->redirect('/login');
    }

    public function index() {
        $this->render('home', ['nome' => 'Bonieky']);
    }

}