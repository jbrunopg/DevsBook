<?php
namespace src\handlers;

use \src\models\User;

class LoginHandler {

    /**
     * Verifica se o usuário está logado na sessão.
     * Retorna um objeto User com os dados do usuário logado ou false caso não esteja logado.
     */

    public static function checkLogin(){
        if(!empty($_SESSION['token'])){
            $token = $_SESSION['token'];

             // Busca os dados do usuário com base no token armazenado na sessão
            $data = User::select()->where('token', $token)->one();
            if(count($data) > 0) {
                // Cria um objeto User com os dados do usuário logado e o retorna
                $loggedUser = new User();
                $loggedUser->id = $data['id'];
                $loggedUser->name = $data['name'];
                $loggedUser->avatar = $data['avatar'];

                return $loggedUser;

            }

        }
        // Retorna false caso o usuário não esteja logado
        return false;
    }

    /**
     * Verifica se o login é válido com base no e-mail e senha fornecidos.
     * Retorna o token de autenticação em caso de login válido ou false caso contrário.
     */

    public static function verifyLogin($email, $password){
        $user = User::select()->where('email', $email)->one();

        if($user) {
            if(password_verify($password, $user['password'])) {
                $token = md5(time().rand(0, 9999).time());

                // Atualiza o token do usuário no banco de dados
                User::update()->set('token', $token)
                ->where('email', $email)
            ->execute();


                return $token;
            }
        }

        // Retorna false caso o login seja inválido
        return false;
    }

    /**
     * Verifica se um e-mail já está cadastrado no sistema.
     * Retorna true caso o e-mail já esteja cadastrado ou false caso contrário.
     */

    public function emailExists($email){
        $user = User::select()->where('email', $email)->one();
        return $user ? true : false;
    }

    /**
     * Adiciona um novo usuário ao sistema.
     * Retorna o token de autenticação do novo usuário.
     */

    public function addUser($name, $email, $password, $birthdate) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $token = md5(time().rand(0, 9999).time());

        // Insere os dados do novo usuário no banco de dados
        User::insert([
            'email' => $email,
            'password' => $hash,
            'name' => $name,
            'birthdate' => $birthdate,
            'token' => $token
        ])->execute();

        return $token;
    }

}