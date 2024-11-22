<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Landing extends CI_Controller
{
    public function index()
    {
        // Load view secara langsung
        $this->load->view('user/landing');
    }
}
