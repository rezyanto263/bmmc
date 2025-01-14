<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
{
    parent::__construct();
    // Pastikan hanya admin atau company yang dapat mengakses
    if ($this->session->userdata('adminRole') != ('admin' || 'company')) {
        redirect('dashboard');
    }

    $this->load->model('M_companies');

    // Ambil adminId dari session yang sudah login
    $adminId = $this->session->userdata('adminId');

    // Ambil data perusahaan berdasarkan adminId
    $companyData = $this->M_companies->getCompanyByAdminId($adminId);

    // Jika data perusahaan ada, simpan ke session
    if (!empty($companyData)) {
        $this->session->set_userdata('companyId', $companyData['companyId']);
        $this->session->set_userdata('companyName', $companyData['companyName']);
        $this->session->set_userdata('companyLogo', $companyData['companyLogo']);
        $this->session->set_userdata('companyPhone', $companyData['companyPhone']);
        $this->session->set_userdata('companyAddress', $companyData['companyAddress']);
        $this->session->set_userdata('companyCoordinate', $companyData['companyCoordinate']);
    }
}

public function index()
{
    // Ambil data perusahaan dari session
    $company = array(
        'companyId' => $this->session->userdata('companyId'),
        'companyName' => $this->session->userdata('companyName'),
        'companyLogo' => $this->session->userdata('companyLogo'),
        'companyPhone' => $this->session->userdata('companyPhone'),
        'companyAddress' => $this->session->userdata('companyAddress'),
        'companyCoordinate' => $this->session->userdata('companyCoordinate')
    );

    // Kirim data ke view
    $datas = array(
        'title' => 'BIM Dashboard | Companies',
        'subtitle' => 'Companies',
        'contentType' => 'dashboard',
        'company' => $company // Kirim data perusahaan ke view
    );

    $partials = array(
        'head' => 'partials/head',
        'sidebar' => 'partials/company/sidebar',
        'floatingMenu' => 'partials/company/floatingMenu',
        'contentHeader' => 'partials/company/contentHeader',
        'contentBody' => 'company/Dashboard',
        'footer' => 'partials/dashboard/footer',
        'script' => 'partials/script'
    );

    $this->load->vars($datas);
    $this->load->view('master', $partials);
}


    public function editCompany()
    {
        $validate = array(
            array(
                'field' => 'companyName',
                'label' => 'Name',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Company should provide a %s.'
                )
            ),
            array(
                'field' => 'companyPhone',
                'label' => 'Phone',
                'rules' => 'required|trim|numeric|max_length[13]',
                'errors' => array(
                    'required' => 'Company should provide a %s.',
                    'numeric' => 'The %s field must contain only numbers.',
                    'max_length' => '%s number max 13 digits in length.',
                )
            ),
            array(
                'field' => 'companyAddress',
                'label' => 'Address',
                'rules' => 'required|trim',
                'errors' => array(
                    'required' => 'Company should provide a %s.'
                )
            ),
            array(
                'field' => 'companyCoordinate',
                'label' => 'Coordinate',
                'rules' => 'trim|regex_match[/^[-+]?\d{1,2}(\.\d+)?,\s*[-+]?\d{1,3}(\.\d+)?$/]',
                'errors' => array(
                    'regex_match' => 'The %s field must contain valid latitude and longitude coordinates.'
                )
            ),
        );
        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->error_array();
            echo json_encode(array('status' => 'invalid', 'errors' => $errors));
        } else {
            $companyCoordinate = $this->input->post('companyCoordinate');

            $companyDatas = array(
                'companyName' => $this->input->post('companyName'),
                'companyPhone' => htmlspecialchars($this->input->post('companyPhone')),
                'companyAddress' => $this->input->post('companyAddress'),
            );

            if ($companyCoordinate) {
                $checkCompanyCoordinate = $this->M_companies->checkCompany('companyCoordinate', $companyCoordinate);
                if (!$checkCompanyCoordinate) {
                    $companyDatas['companyCoordinate'] = $companyCoordinate;
                }
            }

            if ($_FILES['companyLogo']['name']) {
                $fileName = strtoupper(trim($companyDatas['companyName'])).'-'.time();
                $companyLogo = $this->_uploadLogo('companyLogo', array('file_name' => $fileName));
                if ($companyLogo['status']) {
                    $this->_deleteLogo($this->input->post('companyId'));
                    $companyDatas['companyLogo'] = $companyLogo['data']['file_name'];
                } else {
                    echo json_encode(array('status' => 'failed', 'failedMsg' => 'upload failed', 'errorMsg' => $companyLogo['error']));
                    return;
                }
            }

            $this->M_companies->updateCompany($this->input->post('companyId'), $companyDatas);
            echo json_encode(array('status' => 'success'));
        }
    }

    private function _uploadLogo($fileLogo, $customConfig = [])
    {
        $defaultConfig = array(
            'upload_path'   => FCPATH . 'uploads/logos/',
            'allowed_types' => 'jpg|jpeg|png',
            'max_size'      => 1024,
        );

        $config = array_merge($defaultConfig, $customConfig);

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($fileLogo)) {
            return array('status' => false, 'error' => $this->upload->display_errors());
        } else {
            return array('status' => true, 'data' => $this->upload->data());
        }
    }

    private function _deleteLogo($companyId)
    {
        $companyDatas = $this->M_companies->checkCompany('companyId', $companyId);
        if ($companyDatas && isset($companyDatas['companyLogo'])) {
            unlink(FCPATH . 'uploads/logos/' . $companyDatas['companyLogo']);
        }
    }
}

/* End of file Dashboard.php */