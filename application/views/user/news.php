<!-- Latest News Section Start -->
<section class="latest-news px-1 px-md-3 px-lg-4 pb-5 w-100">
  <div class="container-xxl pb-5 pt-3">
    <h2 class="text-center fw-bold display-5 mb-5"><span class="text-primary">Breaking</span> News & Important Updates<span class="text-primary">.</span></h2>
    <form action="<?= base_url('news'); ?>" method="GET">
      <div class="d-flex align-items-center justify-content-center justify-content-md-end gap-2 mb-3">
        <div class="position-relative w-100" style="max-width: 300px;">
          <input type="search" name="search" placeholder="Search by name, type, or tag" class="border rounded bg-transparent py-2 ps-3 pe-5 w-100" value="<?= $searchKeywords; ?>">
          <button type="submit" class="btn-primary rounded d-flex align-items-center justify-content-center position-absolute end-0 top-0 bottom-0 my-auto me-2" style="width: 30px; height: 30px;">
            <i class="las la-search fs-6"></i>
          </button>
        </div>
      </div>
    </form>
    <div class="row g-4 justify-content-center" id="newsList">
      <?php foreach($news as $news): ?>
      <div class="col-12 col-md-4 col-lg-3">
        <div class="card">
          <img class="card-img-top mb-0 border-bottom" src="<?= base_url('uploads/news/' . $news['newsThumbnail']); ?>" alt="Latest News Image" draggable="false">
          <div class="card-body py-3">
            <h5 class="card-title my-0"><?= $news['newsTitle']; ?></h5>
            <div class="text-nowrap overflow-hidden">
              <span class="badge bg-success text-white">
                <i class="las la-history text-white"></i>
                <?= date('D, j F Y', strtotime($news['createdAt'])); ?>
              </span>
              <span class="badge bg-primary text-white">
                <i class="las la-newspaper text-white"></i>
                <?= $news['newsType']; ?>
              </span>
            </div>
            <div class="tag-badges">
              <?php 
              if (!empty($news['newsTags'])):
                foreach(explode(',', $news['newsTags']) as $tag): 
              ?>
              <span class="badge fw-normal">
                <?= '#' . $tag ?>
              </span>
              <?php 
                endforeach; 
              endif;
              ?>
            </div>
          </div>
          <a type="button" href="<?= base_url('news?id=' . $news['newsId']); ?>" class="btn-readmore align-bottom border-top py-3 ps-auto pe-5 text-end">
            Read More
            <i class="las la-arrow-right fs-5"></i>
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <button id="btnLoadMore" class="btn-primary px-3 text-decoration-none position-relative start-50 end-50 translate-middle" style="margin-top: 80px;" data-page="2">
      Load More
    </button>
  </div>
</section>
<!-- Latest News Section Start -->