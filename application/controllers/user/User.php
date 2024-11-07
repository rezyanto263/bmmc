<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function profile() {
        // Memuat view tanpa data tambahan
        $this->load->view('user/user_profile');
    }
}
