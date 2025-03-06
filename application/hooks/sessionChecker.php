<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SessionChecker {
    public function check_status() {
        $CI =& get_instance();
        $CI->load->library('session');

        $adminRole = $CI->session->userdata('adminRole');

        if ($adminRole === 'company') {
            $CI->load->model('M_companies');
            $status = $CI->M_companies->getCompanyStatus($CI->session->userdata('companyId'));
            $CI->session->set_userdata('companyStatus', $status);
        } elseif ($adminRole === 'hospital') {
            $CI->load->model('M_hospitals');
            $status = $CI->M_hospitals->getHospitalStatus($CI->session->userdata('hospitalId'));
            $CI->session->set_userdata('hospitalStatus', $status);
        } else {
            return;
        }

        if ($status === 'discontinued') {
            $CI->session->sess_destroy();
            $CI->session->set_flashdata('flashdata', 'account discontinued');
            redirect('dashboard/login');
        }
    }
}

?>