<?php

namespace src\controllers;

use \core\Controller;
use \src\handlers\LoginHandler;
use \src\handlers\PostHandler;

class HomeController extends Controller {

    private $loggedUser;

    // Verifica se o usuário está logado e redireciona para a página de login se não estiver
    public function __construct() {
        // Verifica se o usuário está logado usando o método checkLogin() da classe LoginHandler
        $this->loggedUser = LoginHandler::checkLogin();

        if($this->loggedUser === false) {
            // Caso o usuário não esteja logado, redireciona para a página de login
            $this->redirect('/login');
        }
    }

    public function index() {
        // Renderiza a view 'home' e passa a variável 'loggedUser' como parâmetro com o valor $this->loggedUser
        $this->render('home', [
            'loggedUser' => $this->loggedUser
        ]);
    }
}
