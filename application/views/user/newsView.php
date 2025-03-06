<!-- News Section Start -->
<section class="news px-1 px-md-3 px-lg-4 w-100">
  <div class="container-xxl pb-5 pt-3">
    <div class="row gy-4">
      <div class="col-12 col-lg-8 pe-auto pe-lg-2">
        <div class="news-content mb-5">
          <h2 class="news-title fw-bold mb-3" style="text-align: justify;"><?= $news['newsTitle']; ?></h2>
          <span class="badge bg-warning text-white py-2 px-3">
            <i class="las la-history text-white"></i>
            <?= date('D, j F Y', strtotime($news['createdAt'])); ?>
          </span>
          <span class="badge bg-primary text-white py-2 px-3">
            <i class="las la-newspaper text-white"></i>
            <?= $news['newsType']; ?>
          </span>
          <hr class="mt-3 mb-4">
          <div class="news-thumbnail ratio ratio-16x9 mb-4">
            <img class="rounded border" src="<?= base_url('uploads/news/' . $news['newsThumbnail']); ?>" alt="News Thumbnail" draggable="false">
          </div>
          <div class="news-body">
            <?= $news['newsContent']; ?>
          </div>
        </div>
        <div class="news-tag-badges">
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
        <a type="button" href="<?= base_url('news'); ?>" class="btn-primary text-decoration-none px-4 mt-5 d-inline-flex gap-1 align-items-center">
          <i class="las la-arrow-left text-white fs-5 align-self-center"></i>
          See Other News
        </a>
      </div>
      <div class="col-12 col-lg-4 pe-lg-0 ps-lg-5">
        <h3 class="fw-bold">Similar News</h3>
        <hr class="hr my-0">
        <?php 
          if (!empty($similarNews)):
          foreach($similarNews as $simNews): 
        ?>
        <a href="<?= base_url('news?id=' . $simNews['newsId']); ?>" class="similar-news-item py-2 px-1">
          <div class="similar-news-thumbnail">
            <img class="rounded border" src="<?= base_url('uploads/news/' . $simNews['newsThumbnail']); ?>" alt="Similar News Thumbnail" draggable="false">
          </div>
          <p class="fs-6 lh-sm mb-0">
            <?= $simNews['newsTitle']; ?>
          </p>
        </a>
        <hr class="hr my-0">
        <?php 
          endforeach; 
          else:
        ?>
        <p class="text-center fs-6 my-5">No similar news found.</p>
        <hr class="hr my-0">
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<!-- News Section End -->