<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

  public function __construct() {
    parent::__construct();
    if ($this->session->userdata('adminRole') != 'admin') {
      redirect('dashboard/login');
    }

    $this->load->model('M_news');
  }

  public function index() {
    $datas = array(
      'title' => 'BMMC Dashboard | News',
      'subtitle' => 'News',
      'contentType' => 'dashboard',
    );

    $partials = array(
      'head' => 'partials/head',
      'sidebar' => 'partials/dashboard/sidebar',
      'floatingMenu' => 'partials/floatingMenu',
      'contentHeader' => 'partials/contentHeader',
      'contentBody' => 'dashboard/news',
      'script' => 'partials/script'
    );

    $this->load->vars($datas);
    $this->load->view('master', $partials);
  }

  public function getAllNews() {
    $newsDatas = $this->M_news->getAllNews();
    $datas = array(
      'data' => $newsDatas
    );

    echo json_encode($datas);
  }

  public function getAllNewsTags() {
    $newsTagsData = $this->M_news->getAllNewsTags();
    $datas = array(
      'data' => $newsTagsData
    );

    echo json_encode($datas);
  }

  public function getAllNewsTypes() {
    $newsTypesData = $this->M_news->getAllNewsTypes();
    $datas = array(
      'data' => $newsTypesData
    );

    echo json_encode($datas);
  }

  private function _uploadImage($imageInputField, $customConfig = []) {
    $defaultConfig = array(
        'allowed_types' => 'jpg|jpeg|png',
        'max_size'      => 1024,
        'max_width'     => 0,
        'max_height'    => 0
    );

    $config = array_merge($defaultConfig, $customConfig);

    if (!isset($this->upload)) {
        $this->load->library('upload');
    }

    $this->upload->initialize($config);

    if (!$this->upload->do_upload($imageInputField)) {
        return array('status' => false, 'error' => strip_tags($this->upload->display_errors()));
    } else {
        return array('status' => true, 'data' => $this->upload->data());
    }
  }

  private function _deleteImage($newsId, $field, $path) {
      $newsData = $this->M_news->checkNews('newsId', $newsId);
      !empty($newsData[$field]) && unlink($path . $newsData[$field]);
  }

  public function addNews() {
    $validate = array(
      array(
        'field' => 'newsTitle',
        'label' => 'Title',
        'rules' => 'required',
        'errors' => array(
          'required' => 'News %s is required'
        )
      ),
      array(
        'field' => 'newsType',
        'label' => 'Type',
        'rules' => 'required',
        'errors' => array(
          'required' => 'News %s is required'
        )
      ),
      array(
        'field' => 'newsTags[]',
        'label' => 'Tags',
        'rules' => 'required',
        'errors' => array(
          'required' => 'News %s is required'
        )
      ),
      array(
        'field' => 'newsContent',
        'label' => 'Content',
        'rules' => 'required',
        'errors' => array(
          'required' => 'News %s is required'
        )
      )
    );
    $this->form_validation->set_rules($validate);

    if ($this->form_validation->run() == FALSE) {
      $errors = $this->form_validation->error_array();
      echo json_encode(array(
        'status' => 'invalid', 
        'errors' => $errors, 
        'csrfToken' => $this->security->get_csrf_hash()
      ));
      return;
    } else {
      $newsData = array(
        'newsTitle' => $this->input->post('newsTitle'),
        'newsType' => json_decode($this->input->post('newsType'), TRUE)[0]['value'],
        'newsContent' => $this->input->post('newsContent'),
        'newsStatus' => $this->input->post('newsStatus'),
      );

      if (empty($newsData['newsStatus'])) {
        echo json_encode(array(
          'status' => 'failed', 
          'message' => 'unknown news status', 
          'csrfToken' => $this->security->get_csrf_hash()
        ));
      }
  
      $newsTags = json_decode($this->input->post('newsTags', true));
      if (!empty($newsTags)) {
        $newsData['newsTags'] = implode(',', $newsTags);
      }
  
      $checkNews = $this->M_news->checkNews('newsTitle', $newsData['newsTitle']);
      if ($checkNews) {
        echo json_encode(array(
          'status' => 'failed', 
          'message' => 'news already exist', 
          'csrfToken' => $this->security->get_csrf_hash()
        ));
        return;
      }

      if (!empty($_FILES['newsThumbnail']['name'])) {
        $fileName = time();
        $imageUpload = $this->_uploadImage('newsThumbnail', array('file_name' => $fileName, 'upload_path' => FCPATH . 'uploads/news/'));
        if (!$imageUpload['status']) {
          echo json_encode(array(
            'status' => 'failed', 
            'failedMsg' => 'upload failed', 
            'errorMsg' => $imageUpload['error'], 
            'csrfToken' => $this->security->get_csrf_hash()
          ));
          return;
        }
        $newsData['newsThumbnail'] = $imageUpload['data']['file_name'];
      } else {
        echo json_encode(array(
          'status' => 'failed', 
          'failedMsg' => 'news thumbnail required', 
          'csrfToken' => $this->security->get_csrf_hash())
        );
        return;
      }

      $insertNews = $this->M_news->insertNews($newsData);
      echo json_encode(array(
        'status' => 'success',
        'csrfToken' => $this->security->get_csrf_hash()
      ));
    }
  }

  public function editNews() {
    $validate = array(
      array(
        'field' => 'newsId',
        'label' => 'ID',
        'rules' => 'required',
        'errors' => array(
          'required' => 'News %s is required'
        )
      ),
      array(
        'field' => 'newsTitle',
        'label' => 'Title',
        'rules' => 'required',
        'errors' => array(
          'required' => 'News %s is required'
        )
      ),
      array(
        'field' => 'newsType',
        'label' => 'Type',
        'rules' => 'required',
        'errors' => array(
          'required' => 'News %s is required'
        )
      ),
      array(
        'field' => 'newsTags[]',
        'label' => 'Tags',
        'rules' => 'required|trim|max_length[100]',
        'errors' => array(
          'required' => 'News %s is required',
          'max_length' => 'News %s must not exceed 100 characters'
        )
      ),
      array(
        'field' => 'newsStatus',
        'label' => 'Status',
        'rules' => 'required',
        'errors' => array(
          'required' => 'News %s is required'
        )
      ),
      array(
        'field' => 'newsContent',
        'label' => 'Content',
        'rules' => 'required',
        'errors' => array(
          'required' => 'News %s is required'
        )
      )
    );
    $this->form_validation->set_rules($validate);

    if ($this->form_validation->run() == FALSE) {
      $errors = $this->form_validation->error_array();
      echo json_encode(array(
        'status' => 'invalid', 
        'errors' => $errors, 
        'csrfToken' => $this->security->get_csrf_hash()
      ));
      return;
    } else {
      $newsData = array(
        'newsTitle' => $this->input->post('newsTitle'),
        'newsType' => json_decode($this->input->post('newsType'), TRUE)[0]['value'],
        'newsContent' => $this->input->post('newsContent'),
        'newsStatus' => $this->input->post('newsStatus'),
      );

      $newsTags = json_decode($this->input->post('newsTags', true));
      if (!empty($newsTags)) {
        $newsData['newsTags'] = implode(',', $newsTags);
      }
      
      $currentNewsTitle = $this->input->post('currentNewsTitle');
      if ($newsData['newsTitle'] != $currentNewsTitle) {
        $checkNews = $this->M_news->checkNews('newsTitle', $newsData['newsTitle']);
        if ($checkNews) {
          echo json_encode(array(
            'status' => 'failed', 
            'message' => 'news already exist', 
            'csrfToken' => $this->security->get_csrf_hash()
          ));
          return;
        }
      }

      if (!empty($_FILES['newsThumbnail']['name'])) {
        $fileName = time();
        $this->_deleteImage($this->input->post('newsId'), 'newsThumbnail', FCPATH . 'uploads/news/');
        $imageUpload = $this->_uploadImage('newsThumbnail', array('file_name' => $fileName, 'upload_path' => FCPATH . 'uploads/news/'));
        if (!$imageUpload['status']) {
          echo json_encode(array(
            'status' => 'failed', 
            'failedMsg' => 'upload failed', 
            'errorMsg' => $imageUpload['error'], 
            'csrfToken' => $this->security->get_csrf_hash()
          ));
          return;
        }
        $newsData['newsThumbnail'] = $imageUpload['data']['file_name'];
      }

      $this->M_news->updateNews($this->input->post('newsId'), $newsData);
      echo json_encode(array(
        'status' => 'success',
        'csrfToken' => $this->security->get_csrf_hash()
      ));
    }
  }

  public function deleteNews() {
    $newsId = $this->input->post('newsId');
    $this->_deleteImage($newsId, 'newsThumbnail', FCPATH . 'uploads/news/');
    $this->M_news->deleteNews($newsId);
    echo json_encode(array(
      'status' =>'success',
      'csrfToken' => $this->security->get_csrf_hash()
    ));
  }

}

/* End of file News.php */

?>