<?php
    namespace Tisim\SimpleCrm\Controllers;
    use Tisim\SimpleCrm\Models\User;
    class AuthController extends BaseController {
        public function showLogin() {
            $this->view('auth/login');
        }
        public function login() {
            $user = User::where('email', $_POST['email'])->first();
            if ($user && password_verify($_POST['password'], $user->password)) {
                $_SESSION['user_id'] = $user->id;
                $this->redirect('index.php?url=dashboard');
            } else {
                $this->view('auth/login', ['error' => 'E-mail ou senha inválidos.']);
            }
        }
        public function showRegister() {
            $this->view('auth/register');
        }
        public function register() {
            $user = new User;
            $user->name = $_POST['name'];
            $user->email = $_POST['email'];
            $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $user->save();
            $_SESSION['user_id'] = $user->id;
            $this->redirect('index.php?url=dashboard');
        }
        public function logout() {
            session_destroy();
            $this->redirect('/');
        }
    }