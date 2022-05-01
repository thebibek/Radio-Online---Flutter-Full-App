<?php defined('BASEPATH') || exit('No direct script access allowed');

class Login extends CI_Controller {

    /*  This is default constructor of the class */
    public function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->model('Dashboard_model');  
    }

    /**  Index Page for this controller. */
    public function index() {
        $this->isLoggedIn();
    }

    /**  This function used to check the user is logged in or not  */
    function isLoggedIn() {
        $isLoggedIn = $this->session->userdata('isLoggedIn');

        if (!isset($isLoggedIn) || $isLoggedIn != TRUE) {
        $result['full'] = $this->Dashboard_model->get_full_logo();
        $result['half'] = $this->Dashboard_model->get_half_logo();
        $this->load->view('login',$result);
        } else {
            redirect('dashboard');
        }
    }

    /**  This function used to logged in user */
    public function loginMe() {
        
            $data_from = $this->input->post(NULL, TRUE);

            if ($data_from) {
                $user = $data_from['Username'];
                $pass = $data_from['Password'];
                
                $result = $this->Login_model->get_user($user, $pass);

                if ($result) {

                    $sessionArray = array('adminname' => $user,
                        'isLoggedIn' => TRUE);

                    $this->session->set_userdata($sessionArray);
                    $this->isLoggedIn();
                }
                $this->session->set_flashdata('error', 'Invalid Username or Password');
                redirect('', 'refresh');           
            }
        // Load our view to be displayed to the user
        $result['full'] = $this->Dashboard_model->get_full_logo();
        $result['half'] = $this->Dashboard_model->get_half_logo();
        $this->load->view('login',$result);
    }
    
}
