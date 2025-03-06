<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class M_news extends CI_Model {

  public function getAllNews() {
    return $this->db->get('news')->result_array();
  }

  public function getAllPublishedNewsWithoutContent($searchKeywords, $limit, $offset) {
    $this->db->select('newsId, newsTitle, newsType, newsTags, newsThumbnail, newsViews, createdAt, updatedAt');
    $this->db->where('newsStatus', 'published');
    $this->db->order_by('createdAt', 'DESC');
    if (!empty($searchKeywords)) {
      $this->db->like('newsTitle', $searchKeywords, 'both');
      $this->db->or_like('newsType', $searchKeywords, 'both');
      $this->db->or_like('newsTags', $searchKeywords, 'both');
    }
    return $this->db->get('news', $limit, $offset)->result_array();
  }

  public function getAllNewsTags() {
    $this->db->select('newsTags');
    $newsTags = $this->db->get('news')->result_array();
    
    $tags = array();
    foreach ($newsTags as $newsTag) {
      $tags = array_merge($tags, explode(',', $newsTag['newsTags']));
    }

    return array_unique($tags);
  }

  public function getAllNewsTypes() {
    $this->db->select('newsType');
    $newsTypes = $this->db->get('news')->result_array();
    
    $types = array();
    foreach ($newsTypes as $newsType) {
      $types = array_merge($types, [$newsType['newsType']]);
    }

    return array_unique($types);
  }

  public function getFourLatestNews() {
    $this->db->select('newsId, newsTitle, newsType, newsTags, newsThumbnail, newsViews, createdAt, updatedAt');
    $this->db->where('newsStatus', 'published');
    $this->db->order_by('createdAt', 'DESC');
    $this->db->limit(4);
    return $this->db->get('news')->result_array();
  }

  public function getSimilarNewsByTags($newsId, $newsTags) {
    $this->db->select('*');
    $this->db->from('news');
    
    $this->db->where('newsId !=', $newsId);

    $this->db->group_start();

    foreach (explode(',', $newsTags) as $tag) {
        $this->db->or_where("FIND_IN_SET('$tag', newsTags) >", 0);
    }

    $this->db->group_end();

    $this->db->limit(5);
    
    return $this->db->get()->result_array();
}

  public function checkNews($param, $value) {
    return $this->db->get_where('news', array($param => $value))->row_array();
  }

  public function insertNews($newsData) {
    return $this->db->insert('news', $newsData);
  }

  public function updateNews($newsId, $newsData) {
    $this->db->where('newsId', $newsId);
    return $this->db->update('news', $newsData);
  }

  public function deleteNews($newsId) {
    $this->db->where('newsId', $newsId);
    return $this->db->delete('news');
  }

}

/* End of file M_news.php */

?>