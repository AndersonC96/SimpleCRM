<?php
    namespace App\Controllers;
    use App\Models\User;
    use Respect\Validation\Validator as v;
    class UserController extends BaseController {
        /**
        * Lista todos os usuários.
        */
        public function index() {
            $users = User::all();
            $this->render('users/index', ['users' => $users]);
        }
        /**
        * Exibe o formulário para criação de um novo usuário.
        */
        public function create() {
            $this->render('users/create');
        }
        /**
        * Processa a criação de um novo usuário.
        */
        public function store() {
            $data = $_POST;
            if (!v::email()->validate($data['email'])) {
                $error = "Email inválido";
                return $this->render('users/create', ['error' => $error]);
            }
            $user = new User();
            $user->name     = $data['name'];
            $user->email    = $data['email'];
            $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
            $user->save();
            header('Location: /users');
            exit;
        }
        /**
        * Exibe o formulário para edição de um usuário existente.
        */
        public function edit($id) {
            $user = User::find($id);
            $this->render('users/edit', ['user' => $user]);
        }
        /**
        * Atualiza os dados de um usuário.
        */
        public function update($id) {
            $data = $_POST;
            $user = User::find($id);
            $user->name  = $data['name'];
            $user->email = $data['email'];
            if (!empty($data['password'])) {
                $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
            }
            $user->save();
            header('Location: /users');
            exit;
        }
        /**
        * Exclui um usuário.
        */
        public function delete($id) {
            $user = User::find($id);
            if ($user) {
                $user->delete();
            }
            header('Location: /users');
            exit;
        }
    }