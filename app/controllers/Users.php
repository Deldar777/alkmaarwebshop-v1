<?php

class Users extends Controller{

    

    

    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->orderModel = $this->model('order');
    }

    public function changePassword(){
        $data = [

            'id' => trim($_SESSION['user_id']),
            'current_password' => trim($_POST['current_password']),
            'new_password' => trim($_POST['new_password']),
            'repeat_password' => trim($_POST['repeat_password']),
            

            'emptyCurrent' => '',
            'emptyNew' => '',
            'emptyRepeat' => '',

            'emptyError' => '',
            'sameError' => '',
            'invalidError' => '',
            'existsError' => '',
        ];


        // Validate password on length and numeric value
        if(empty($_POST['current_password'])){
            $data['emptyCurrent'] = 'Please enter your current password.';
        }else if(!password_verify($data['current_password'], $_SESSION['pwd'])){
            $data['emptyCurrent'] = 'Wrong password!';
        }


        
        if(empty($data['new_password'])){
            $data['emptyNew'] = 'Please enter new password';
        }else if(strlen($data['new_password'] < 6)){
            $data['emptyNew'] = 'Password should be at least 8 characters.';
        }


        // Validate confirm password on length and numeric value
        if(empty($data['repeat_password'])){
            $data['emptyRepeat'] = 'Please enter password';
        }else{
            if($data['new_password'] != $data['repeat_password']){
                $data['emptyRepeat'] = 'Passwords do not match, please try again.';
            }
        }


        //Check that there is no errors
            if(empty($data['emptyCurrent']) && empty($data['emptyNew']) && empty($data['emptyRepeat'])){

                // Hash password
                $data['new_password'] = password_hash($data['new_password'],    PASSWORD_DEFAULT);

                // Register user through model of the user
                if($this->userModel->updatePassword($data)){
                    // if update  is succeed then the user will be redirected to the login page
                    $this->logout();
                }else{
                    die('Something went wrong.');
                }
            }






        $this->view('users/account', $data);
    }

    public function changeEmail(){
        $data = [

            'id' => trim($_SESSION['user_id']),
            'new_email' => trim($_POST['new_email']),
            

            'emptyCurrent' => '',
            'emptyNew' => '',
            'emptyRepeat' => '',
            'emptyError' => '',
            'sameError' => '',
            'invalidError' => '',
            'existsError' => '',
        ];


        // validate email
            if(empty($_POST['new_email'])){
                $data['emptyError'] = 'Please enter your new email address.';
            }else if(!filter_var($_POST['new_email'], FILTER_VALIDATE_EMAIL)){
                $data['invalidError'] = 'Invalid email! please enter the correct format.';
            }else if($_POST['new_email'] == $_SESSION['user_email']){
                $data['sameError'] = 'You are already using this email. nothing changed!';
            }
            else if($this->userModel->findUserByEmail($_POST['new_email'])){
                // check if email exists
                 $data['existsError'] = 'Email is already taken.';
            }



            //Check that there is no errors
            if(empty($data['emptyError']) && empty($data['sameError']) && empty($data['invalidError']) && empty($data['existsError'])){

            
                // update email through model of the user
                if($this->userModel->updateEmail($data)){
                    // if updating  is succeed then the user will be redirected to the account page
                    $user = $this->userModel->getUserById($_SESSION['user_id']);
                    $this->createUserSession($user);
                }else{
                    die('Something went wrong.');
                }
            }

        $this->view('users/account', $data);
    }

    public function account(){
        $data = [
            'emptyCurrent' => '',
            'emptyNew' => '',
            'emptyRepeat' => '',
            'emptyError' => '',
            'sameError' => '',
            'invalidError' => '',
            'existsError' => '',
        ];

        

        $this->view('users/account', $data);
    }

    public function delete(){
        $data = [
            'deleted' => '',
            'error' => '',
            'users' => '',
        ];

        
        if($_GET['action'] == 'delete'){
            $id = $_GET['id'];
            $user = $this->userModel->getUserById($id);
            $hasOrder = $this->orderModel->getOrders($id);

            if($user->user_role == 'admin'){
                $data['error'] = 'Can not delete a user with admin right!';
            }else if($hasOrder){
                $data['error'] = 'Can not delete a user with order history!';
            }else{
                $this->userModel->deleteById($id);
                $data['deleted'] =  $user->user_first . " " . $user->user_last . " is deleted";
            }
        }
        
        $users = $this->userModel->getUsers();

        $data['users'] = $users;
        $this->view('users/editUsers', $data);
    }

    public function editUsers(){
        $users = $this->userModel->getUsers();

        $data = [
            'deleted' => '',
            'error' => '',
            'users' => $users,
        ];
        $this->view('users/editUsers', $data);
    }

    public function login(){

        $data = [
            'username' => '',
            'usernameError' => '',
            'password' => '',
            'passwordError' => '',
        ];
        

        // Check for post
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            //Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
             // variables that user has typed
            'username' => trim($_POST['username']),
            'password' => trim($_POST['password']),

            // variables for eventual errors
            'usernameError' => '',
            'passwordError' => '',
            ];

            // Validate user inputs
             if(empty($data['username'])){
                $data['usernameError'] = 'Please enter username!';
            }

            if(empty($data['username'])){
                $data['passwordError'] = 'Please enter password!';
            }

            // Check if all erros are empty
            if(empty($data['usernameError']) && empty($data['passwordError'])){

                $loggedIn = $this->userModel->login($data['username'], $data['password']);

                if($loggedIn){
                    $this->createUserSession($loggedIn);
                    header('location: ' . URLROOT . '/pages/index');
                }else{
                    $data['passwordError'] = 'Password or username is incorrect. Please try again.';

                    $this->view('users/login', $data);
                }
            }
        }else{
             $data = [
            'username' => '',
            'usernameError' => '',
            'password' => '',
            'passwordError' => '',
        ];
        }
        $this->view('users/login', $data);
    }

    public function createUserSession($user){
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['firstname'] = $user->user_first;
        $_SESSION['lastname'] = $user->user_last;
        $_SESSION['user_role'] = $user->user_role;
        $_SESSION['user_email'] = $user->user_email;
        $_SESSION['pwd'] = $user->user_pwd;
        header('location:' . URLROOT . '/pages/index');
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['firstname']);
        unset($_SESSION['lastname']);
        unset($_SESSION['user_role']);
        unset($_SESSION['user_email']);
        unset($_SESSION['pwd']);
        header('location:' . URLROOT . '/users/login');
    }

    public function register(){
        

        $data = [
            'firstname' => '',
            'firstnameError' => '',
            'lastname' => '',
            'lastnameError' => '',
            'email' => '',
            'emailError' => '',
            'password' => '',
            'passwordError' => '',
            'confirmPassword' => '',
            'confirmPasswordError' => '',
        ];

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                // variables that user has typed
                'firstname' => trim($_POST['firstname']),
                'lastname' => trim($_POST['lastname']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirmPassword' => trim($_POST['confirmPassword']),

                // variables for eventual errors
                'firstnameError' => '',
                'lastnameError' => '',
                'emailError' => '',
                'passwordError' => '',
                'confirmPasswordError' => '',
            ];

            
            // valdiate user input(firstname, lastname) on letters/numbers

            if(empty($data['firstname'])){
                $data['firstnameError'] = 'Please enter firstname';
            }else if(!preg_match(NAMEVALIDATION, $data['firstname'])){
                $data['firstnameError'] = 'Firstname can only contains letters and numbers';
            }

            if(empty($data['lastname'])){
                $data['lastnameError'] = 'Please enter lastname';
            }else if(!preg_match(NAMEVALIDATION, $data['lastname'])){
                $data['lastnameError'] = 'Lastname can only contains letters and numbers';
            }


            // validate email
            if(empty($data['email'])){
                $data['emailError'] = 'Please enter email address.';
            }else if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                $data['emailError'] = 'Invalid email! please enter the correct format.';
            }else if($this->userModel->findUserByEmail($data['email'])){
                // check if email exists
                 $data['emailError'] = 'Email is already taken.';
            }

            // Validate password on length and numeric value
            if(empty($data['password'])){
                $data['passwordError'] = 'Please enter password';
            }else if(strlen($_POST['password'])  < 8){
                $data['passwordError'] = 'Password should be at least 8 characters.';
            }//else if(!preg_match($passwordValidation, $data['password'])){
            //     $data['passwordError'] = 'Password should have at least one numeric value.';
            // }


            // Validate confirm password on length and numeric value
            if(empty($data['confirmPassword'])){
                $data['confirmPasswordError'] = 'Please enter password';
            }else{
                if($data['password'] != $data['confirmPassword']){
                    $data['confirmPasswordError'] = 'Passwords do not match, please try again.';
                }
            }

            //Check that there is no errors
            if(empty($data['firstnameError']) && empty($data['lastnameError']) && empty($data['emailError']) && empty($data['passwordError']) && empty($data['confirmPasswordError']) ){

                // Hash password
                $data['password'] = password_hash($data['password'],    PASSWORD_DEFAULT);

                // Register user through model of the user
                if($this->userModel->registerUser($data)){
                    // if registration  is succeed then the user will be redirected to the login page
                    header('location: ' . URLROOT . '/users/register?action=registered');
                }else{
                    die('Something went wrong.');
                }
            }

        }

        $this->view('users/register', $data);
    }
} 