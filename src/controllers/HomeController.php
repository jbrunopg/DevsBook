<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\LoginHandler;


class HomeController extends Controller {

    private $loggedUser;

    // Verifica se o usuário está logado e redireciona para a página de login se não estiver.

    public function __construct() {
        $this->loggedUser = LoginHandler::checkLogin();
        if($this->loggedUser === false) {
            $this->redirect('/login');
        }
    }

    public function index() {
        $this->render('home', ['nome' => 'Bonieky']);
    }

}