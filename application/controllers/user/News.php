<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_news');
    }

    public function index() {
        $newsId = $this->input->get('id');
        if (!empty($newsId)) {
            return $this->newsView($newsId);
        }

        $searchKeywords = $this->input->get('search') ?: NULL;
        $newsData = $this->M_news->getAllPublishedNewsWithoutContent($searchKeywords, 8, 0);

        $datas = array(
            'title' => 'BMMC | News',
            'subtitle' => 'News',
            'contentType' => 'user',
            'news' => $newsData,
            'searchKeywords' => $searchKeywords
        );

        $partials = array(
            'head' => 'partials/head',
            'navbar' => 'partials/user/navbar',
            'content' => 'user/news',
            'footer' => 'partials/user/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function newsView($newsId) {
        $newsData = $this->M_news->checkNews('newsId', $newsId);
        if (empty($newsData) || $newsData['newsStatus'] != 'published') {
            show_404();
        }

        $this->M_news->updateNews($newsId, array('newsViews' => (int) $newsData['newsViews'] + 1),);
        $similarNewsData = $this->M_news->getSimilarNewsByTags($newsId, $newsData['newsTags']);

        $datas = array(
            'title' => 'BMMC | News',
            'subtitle' => 'News',
            'contentType' => 'user',
            'news' => $newsData,
            'similarNews' => $similarNewsData
        );

        $partials = array(
            'head' => 'partials/head',
            'navbar' => 'partials/user/navbar',
            'content' => 'user/newsView',
            'footer' => 'partials/user/footer',
            'script' => 'partials/script'
        );

        $this->load->vars($datas);
        $this->load->view('master', $partials);
    }

    public function getAllPublishedNewsWithoutContent() {        
        $page = $this->input->get('page');
        $searchKeywords = $this->input->get('search') ?: NULL;
        $limit = 8;
        $offset = ($page - 1) * $limit;

        $newsData = $this->M_news->getAllPublishedNewsWithoutContent($searchKeywords, $limit, $offset);

        $datas = array(
            'data' => $newsData
        );

        echo json_encode($datas);
    }

}

/* End of file News.php */

?>