<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Check if the user is logged in by verifying session data
        if ($this->session->userdata('userType') != 'policyholder' && $this->session->userdata('userType') != 'family') {
            redirect('login');
        }

        $this->load->model('M_auth');
    }
    

    public function index()
    {
        // Retrieve the logged-in policyholder's data from session
        $userType = $this->session->userdata('userType');
        if ($userType == 'policyholder') {
            // Use session data for the logged-in policyholder
            $policyholderId = $this->session->userdata('userNIN');
            $policyholderDatas = $this->M_auth->getPolicyHolderDataById($policyholderId);
            $familyMembers = $this->M_auth->getFamilyMembersByPolicyHolder($policyholderId);
        } else {
            // Assuming you are also retrieving family data if logged in as family
            $familyId = $this->session->userdata('userNIN');
            $policyholderDatas = $this->M_auth->getFamilyDataById($familyId);
        }

        // Pass policyholder data to view
        $datas = array(
            'title' => 'BIM | User',
            'subtitle' => 'User',
            'contentType' => 'profile',
            'policyholderDatas' => $policyholderDatas, // Send data to the view
            'familyMembers' => $familyMembers
        );

        $partials = array(
            'head' => 'partials/head',
            'navbar' => 'partials/user/navbar',
            'content' => 'user/userPage', // You can access policyholderData here
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

}

/* End of file User.php */
?>
