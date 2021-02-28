<?php
class Pages extends Controller{
    
    public function __construct()
    {
        $this->pageModel = $this->model('Page');
    }

    public function index(){
        $this->view('pages/index');
    }

    public function about(){
        $this->view('pages/about');
    }

    public function Contact(){

        $data = [
            'nameError' => '',
            'emailError' => '',
            'phoneNumberError' => '',
            'messageError' => '',
            'succeeded' => ''
        ];

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            //Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                // variables that user has typed
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'phoneNumber' => trim($_POST['phoneNumber']),
                'message' => trim($_POST['message']),

                // variables for eventual errors
                'nameError' => '',
                'emailError' => '',
                'phoneNumberError' => '',
                'messageError' => ''
            ];



            if(empty($data['name'])){
                $data['nameError'] = 'Please enter name';
            }else if(!preg_match(NAMEVALIDATION, $data['name'])){
                $data['nameError'] = 'Name can only contains letters and numbers';
            }


            // validate email
            if(empty($data['email'])){
                $data['emailError'] = 'Please enter email address.';
            }else if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                $data['emailError'] = 'Invalid email! please enter the correct format.';
            }


            if(empty($data['phoneNumber'])){
                $data['phoneNumberError'] = 'Please enter phone number to call you back if your request is handled';
            }else if(!preg_match(NUMBERVALIDATION, $data['phoneNumber'])){
                $data['phoneNumberError'] = 'Phone number can only contains numbers';
            }

            if(empty($data['message'])){
                $data['messageError'] = 'Please enter message to handle your request';
            }else if(!preg_match(NAMEVALIDATION, $data['message'])){
                $data['messageError'] = 'Message
                 can only contains letters and numbers';
            }


            //Check that there is no errors
            if(empty($data['nameError']) && empty($data['emailError']) && empty($data['phoneNumberError']) && empty($data['messageError'])){

               
                // Register user through model of the user
                if($this->pageModel->registerRequest($data)){
                    // if registration  is succeed then the user will be redirected to the login page
                    $data['succeeded'] = '<span class="validfeedback">We have received your request, we will contact you as soon as possible</span>';
                }else{
                    die('Something went wrong.');
                }
            }
        }

        $this->view('pages/contact', $data);
    }

    public function requests(){
        $data = [
            'requests' => ''
        ];

        $requests = $this->pageModel->getRequests();
        $data['requests'] = $requests;

        $this->view('pages/requests', $data);
    }

    public function updateStatus(){
        if($_GET['action'] == 'update'){

            $id = $_GET['id'];

            $this->pageModel->updateStatus($id);
        }
        
        $this->requests();
    }


}