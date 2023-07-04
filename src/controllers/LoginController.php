<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\LoginHandler;

class LoginController extends Controller {

    public function signin() {
        $flash = '';

         // Verifica se existe uma mensagem flash na sessão e a atribui a variável $flash
        if(!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }

         // Renderiza a view 'signin' passando a variável $flash como parâmetro
        $this->render('signin', [
            'flash' => $flash
        ]);

    }

    public function signinAction() {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        if($email && $password) {

             // Verifica se o login é válido, obtendo um token de autenticação
            $token = LoginHandler::verifyLogin($email, $password);
            if($token) {
                
                // Armazena o token na sessão e redireciona para a página inicial
                $_SESSION['token'] = $token;
                $this->redirect('/');
            } else {

                // Caso o login seja inválido, define uma mensagem flash e redireciona para a página de login
                $_SESSION['flash'] = 'E-mail e/ou senha incorreta';
                $this->redirect('/login');
            }

        } else {

             // Caso o e-mail e a senha não tenham sido fornecidos, define uma mensagem flash e redireciona para a página de login
            $_SESSION['flash'] = 'Digite os campos de e-mail e senha.';
            $this->redirect('login');
        }
    }


    public function signup() {
        $flash = '';

        // Verifica se existe uma mensagem flash na sessão e a atribui a variável $flash
        if(!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }

        // Renderiza a view 'signup' passando a variável $flash como parâmetro
        $this->render('signup', [
            'flash' => $flash
        ]);
    }

    public function signupAction(){
        $name = filter_input(INPUT_POST, 'name');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        $birthdate = filter_input(INPUT_POST, 'birthdate');

        if($name && $email && $password && $birthdate){
            $birthdate = explode('/', $birthdate);

             // Verifica se a data de nascimento possui o formato esperado (dd/mm/aaaa)
            if(count($birthdate) != 3) {
                $_SESSION['flash'] = 'Data de nascimento inválida!';
                $this->redirect('/cadastro');
            }
                
             // Formata a data de nascimento para o formato aaaa-mm-dd
            $birthdate = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];

                  // Verifica se a data de nascimento é válida
                if(strtotime($birthdate) === false) {
                    $_SESSION['flash'] = 'Data de nascimento inválida!';
                    $this->redirect('/cadastro');
                }
                
                 // Verifica se o e-mail já está cadastrado no sistema
                if(LoginHandler::emailExists($email) === false) {
                    $token = LoginHandler::addUser($name, $email, $password, $birthdate);
                    $_SESSION['token'] = $token;
                    $this->redirect('/');
                } else {

                    // Caso o e-mail já esteja cadastrado, define uma mensagem flash e redireciona para a página de cadastro
                    $_SESSION['flash'] = 'E-mail já cadastrado!';
                    $this->redirect('/cadastro');
                }


        }else {
            // Caso algum dos campos obrigatórios não tenha sido preenchido, redireciona para a página de cadastro
            $this->redirect('/cadastro');
        }
    }

}