<?php

class Users extends Controller {
    public function __construct()
    {
        $this->userModel = $this->model('User');

    }

    public function register(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            //process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data =[
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' =>trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err'
            ];

            //validate name
            if (empty($data['name'])){
                $data['name_err'] = 'Please enter name';
            }

            //validate email\
            if (empty($data['email'])){
                $data['email_err'] = 'Please enter email';
            } else{
                //check email if exists in database
                if ($this->userModel->findUserByEmail($data['email'])){
                    $data['email_err'] = 'email already exists in our database';
                }
            }

            //validate password

            if (empty($data['password'])){
                $data['password_err'] = 'Please enter password';
            }elseif(strlen($data['password']) <6){
                $data['password_err'] = 'The Password must be at least 6 characters';
            }

            //validate confirm password

            if (empty($data['confirm_password'])){
                $data['confirm_password_err'] = 'Please confirm password';
            }else{
                if ($data['password'] != $data['confirm_password']){
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            //make errors empty
            if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                //if everything is validated proceed

                //hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                //Register user
               if ( $this->userModel->register($data)){
                   flash('register_success','You are registered and you can now log in ');
                    redirect('users/login');
               }else{
                   die('something went wrong');
               }
            } else {

                //load view with errors
                $this->view('users/register', $data);
            }

        }else{
            //init data
            $data =[
              'name' => '',
              'email' => '',
              'password' =>'',
              'confirm_password' => '',
              'name_err' => '',
              'email_err' => '',
              'password_err' => '',
              'confirm_password_err' => ''
            ];

            //load view
            $this->view('users/register', $data);
        }
    }


    public function login(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            //process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data =[
                'email' => trim($_POST['email']),
                'password' =>trim($_POST['password']),
                'user_type' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            //validate email
            if (empty($data['email'])){
                $data['email_err'] = 'Please enter email';
            }
            //validate password
            if (empty($data['password'])){
                $data['password_err'] = 'Please enter Password';
            }

            //check user/email
            if ($this->userModel->findUserByEmail($data['email'])){
                //user found in database
            }else{
                $data['email_err'] = 'No user found';
            }


            //make errors empty
            if (empty($data['email_err'])  && empty($data['password_err']) ){
                //log in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password'] , $data['user_type']);

                if ($loggedInUser){
                    //create session
                    $this->createUserSession($loggedInUser);
                }else{
                    $data['password_err'] = 'Password incorrect';

                    $this->view('users/login',$data);
                }
            } else {

                //load view with errors
                $this->view('users/login', $data);
            }


        }else{
            //init data
            $data =[
                'email' => '',
                'password' =>'',
                'email_err' => '',
                'password_err' => '',
            ];

            //load view
            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_type'] = $user->user_type;
        redirect('employees/index');
//
//        if ( $_SESSION['user_type'] == 1){
//            redirect('employees/index');
//        }else{
//            redirect('pages/index');
//        }

    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('users/login');
    }




}