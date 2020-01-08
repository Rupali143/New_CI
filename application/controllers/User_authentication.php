<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class User_Authentication extends CI_Controller 
{ 
    function __construct() { 
        parent::__construct(); 
         
        // Load linkedin oauth library 
        $this->load->library('linkedin'); 
         
        //Load user model 
        $this->load->model('user'); 
    } 
     
    public function index(){ 
        $userData = array(); 
         
        // Get status and user info from session 
        $oauthStatus = $this->session->userdata('oauth_status'); 
        $sessUserData = $this->session->userdata('userData'); 
         
        if(isset($oauthStatus) && $oauthStatus == 'verified'){ 
            // Get the user info from session 
            $userData = $sessUserData; 
        }elseif((isset($_GET["oauth_init"]) && $_GET["oauth_init"] == 1) || (isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])) || (isset($_GET['code']) && isset($_GET['state']))){ 
             
            // Authenticate with LinkedIn 
            if($this->linkedin->authenticate()){ 
                 
                // Get the user account info 
                $userInfo = $this->linkedin->getUserInfo(); 
                 
                // Preparing data for database insertion 
                $userData = array(); 
                $userData['oauth_uid']  = !empty($userInfo['account']->id)?$userInfo['account']->id:''; 
                $userData['first_name'] = !empty($userInfo['account']->firstName->localized->en_US)?$userInfo['account']->firstName->localized->en_US:''; 
                $userData['last_name']  = !empty($userInfo['account']->lastName->localized->en_US)?$userInfo['account']->lastName->localized->en_US:''; 
                $userData['email']      = !empty($userInfo['email']->elements[0]->{'handle~'}->emailAddress)?$userInfo['email']->elements[0]->{'handle~'}->emailAddress:''; 
                $userData['picture']    = !empty($userInfo['account']->profilePicture->{'displayImage~'}->elements[0]->identifiers[0]->identifier)?$userInfo['account']->profilePicture->{'displayImage~'}->elements[0]->identifiers[0]->identifier:''; 
                $userData['link']       = 'https://www.linkedin.com/'; 
         
                // Insert or update user data to the database 
                $userData['oauth_provider'] = 'linkedin'; 
                $userID = $this->user->checkUser($userData); 
                 
                // Store status and user profile info into session 
                $this->session->set_userdata('oauth_status','verified'); 
                $this->session->set_userdata('userData',$userData); 
                 
                // Redirect the user back to the same page 
                redirect('/user_authentication'); 
 
            }else{ 
                 $data['error_msg'] = 'Error connecting to LinkedIn! try again later! <br/>'.$this->linkedin->client->error; 
            } 
        }elseif(isset($_REQUEST["oauth_problem"]) && $_REQUEST["oauth_problem"] <> ""){ 
            $data['error_msg'] = $_GET["oauth_problem"]; 
        } 
         
        $data['userData'] = $userData; 
        $data['oauthURL'] = base_url().$this->config->item('linkedin_redirect_url').'?oauth_init=1'; 
         
        // Load login & profile view 
        $this->load->view('user_authentication/index',$data); 
    } 
 
    public function logout() { 
        // Unset token and user data from session 
        $this->session->unset_userdata('oauth_status'); 
        $this->session->unset_userdata('userData'); 
         
        // Destroy entire session 
        $this->session->sess_destroy(); 
         
        // Redirect to login page 
        redirect('/user_authentication'); 
    } 
}