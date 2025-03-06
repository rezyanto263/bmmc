<!-- Hero Section Start -->
<section class="hero px-1 px-md-3 px-lg-4 w-100 py-4">
  <div class="container-xxl py-md-3">
    <div class="row align-items-center gy-4">
      <div class="col-12 col-md-6 order-md-0 order-1">
        <div class="hero-content d-flex flex-column">
          <h1 class="hero-title fw-bold display-5 text-center text-md-start">Protect Your Business and Employees with <span class="text-primary">Reliable Coverage.</span></h1>
          <p class="hero-description fs-5 text-center text-md-start">
            Gain peace of mind with comprehensive health protection designed for your needs
          </p>
          <a type="button" href="#benefits" class="btn-primary text-decoration-none px-3 me-auto ms-auto ms-md-0">
            Learn More
          </a>
        </div>
      </div>
      <div class="col-12 col-md-6 order-md-1 order-0 mt-0 mt-auto-md">
        <div class="hero-image">
          <img class="img-fluid" src="<?= base_url('assets/images/hero.gif'); ?>" alt="Hero Image" draggable="false">
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Hero Section End -->

<!-- Achievements Section Start -->
<section class="achievements px-1 px-md-3 px-lg-4 w-100">
  <div class="container-xxl pt-5 d-flex justify-content-center">
    <div class="achievement-box d-flex align-items-center justify-content-around rounded py-5 py-md-4 flex-md-row flex-column gap-md-0 gap-5 border">
      <div class="achievement-item text-center">
        <h2 class="achievement-title mb-3 fs-5">Total Members</h2>
        <span class="achievement-count display-3 fw-bold text-primary">
          <?= $totalMembers; ?>+
        </span>
      </div>
      <div class="achievement-item text-center">
        <h2 class="achievement-title mb-3 fs-5">Total Hospitals</h2>
        <span class="achievement-count display-3 fw-bold text-primary">
          <?= $totalHospitals; ?>+
        </span>
      </div>
      <div class="achievement-item text-center">
        <h2 class="achievement-title mb-3 fs-5">Total Companies</h2>
        <span class="achievement-count display-3 fw-bold text-primary">
          <?= $totalCompanies; ?>+
        </span>
      </div>
    </div>
  </div>
</section>
<!-- Achievements Section End -->

<!-- Partners Section Start -->
<section class="partners px-1 px-md-3 px-lg-4 py-5 w-100">
  <div class="container-xxl py-5">
    <h2 class="text-center display-6 fw-bold mb-4">Trusted by Hospitals & Companies for a <br class="d-none d-md-block"><span class="text-primary">Healthier Future.</span></h2>
    <div class="partners-slider d-flex flex-column gap-4">
      <div class="splide normal">
        <div class="splide__track">
          <ul class="splide__list">
            <?php foreach($allHospitalsLogo as $logo): ?>
            <li class="splide__slide">
              <img class="img-fluid" src="<?= base_url('uploads/logos/' . $logo); ?>" alt="">
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
      <div class="splide reverse">
        <div class="splide__track">
          <ul class="splide__list">
            <?php foreach($allCompaniesLogo as $logo): ?>
            <li class="splide__slide">
              <img class="img-fluid" src="<?= base_url('uploads/logos/' . $logo); ?>" alt="">
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Partners Section Start -->

<!-- Benefits Section Start -->
<section class="benefits px-1 px-md-3 px-lg-4 py-5 w-100" id="benefits">
  <div class="container-xxl py-5">
    <div class="row gy-4">
      <div class="col-12 col-lg-6 d-flex align-items-center">
        <img class="img-fluid" src="<?= base_url('assets/images/benefits.png'); ?>" alt="Benefits Image" draggable="false" style="margin-left: -15px;">
      </div>
      <div class="col-12 col-lg-6 d-flex flex-column justify-content-center">
        <h2 class="benefits-title fw-bold display-6 text-center text-lg-start">
          Comprehensive Protection for Your <br class="d-lg-none">
          <span class="text-primary">Peace of Mind.</span>
        </h2>
        <p class="benefits-description text-center text-lg-start fs-5">
          Enjoy comprehensive coverage tailored to your needs and lifestyle.
        </p>
        <ul class="benefits-list ps-0 px-3 px-lg-0 mt-4 d-flex flex-column gap-xl-3 gap-md-1 gap-sm-0 mx-auto mx-lg-0">
          <li class="benefits-item d-flex align-items-start gap-2" style="list-style: none;">
            <img src="<?= base_url('assets/images/check.gif'); ?>" draggable="false" width="27">
            <div class="benefits-item-content">
              <h3 class="benefits-item-title fs-4 mb-0">Extensive Coverage</h3>
              <p class="benefits-item-description fs-6">
                Protection that fits your lifestyle—health, travel, and life insurance options.
              </p>
            </div>
          </li>
          <li class="benefits-item d-flex align-items-start gap-2" style="list-style: none;">
            <img src="<?= base_url('assets/images/check.gif'); ?>" draggable="false" width="27">
            <div class="benefits-item-content">
              <h3 class="benefits-item-title fs-4 mb-1">Affordable Premiums</h3>
              <p class="benefits-item-description fs-6">
                Flexible and budget-friendly plans without compromising on coverage.
              </p>
            </div>
          </li>
          <li class="benefits-item d-flex align-items-start gap-2" style="list-style: none;">
            <img src="<?= base_url('assets/images/check.gif'); ?>" draggable="false" width="27">
            <div class="benefits-item-content">
              <h3 class="benefits-item-title fs-4 mb-1">24/7 Customer Support</h3>
              <p class="benefits-item-description fs-6">
                Get assistance anytime, anywhere with our dedicated support team.
              </p>
            </div>
          </li>
          <li class="benefits-item d-flex align-items-start gap-2" style="list-style: none;">
            <img src="<?= base_url('assets/images/check.gif'); ?>" draggable="false" width="27">
            <div class="benefits-item-content">
              <h3 class="benefits-item-title fs-4 mb-1">Fast & Hassle-Free Claims</h3>
              <p class="benefits-item-description fs-6">
                A quick and seamless claim process for a stress-free experience.
              </p>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section Start -->
<section class="cta px-1 px-md-3 px-lg-4 pb-5 w-100">
  <div class="container-xxl pb-5">
    <div class="cta-box text-center rounded rounded-3 mx-auto border py-5 px-3 px-sm-5">
      <h2 class="cta-title display-6 fw-bold">Ready to Take Control of Your <br class="d-none d-md-block"><span class="text-primary">Health Insurance?</span></h2>
      <p class="cta-description fs-5 mb-4">
        Start your journey today and let us help you find <br class="d-none d-md-block">the right plan that fits your needs.
      </p>
      <a type="button" href="#" class="cta-button btn-primary text-decoration-none px-3 bg-gradient">
        Get Insurance Now
      </a>
    </div>
  </div>
</section>
<!-- CTA Section End -->

<!-- FAQ Section Start -->
<section class="faq px-1 px-md-3 px-lg-4 py-5 w-100">
  <div class="container-xxl py-5">
    <div class="row">
      <div class="col-12 col-lg-5 d-flex align-items-center">
        <img class="img-fluid" src="<?= base_url('assets/images/faq.png') ?>" alt="FAQ Image" draggable="false">
      </div>
      <div class="col-12 col-lg-7 d-flex flex-column justify-content-center">
        <h2 class="text-center display-5 fw-bold mb-4">Frequently Asked <span class="text-primary">Questions.</span></h2>
        <div class="accordion accordion-flush w-100" id="accordionFAQ">
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="false">
                How do I choose the right health insurance plan?
              </button>
            </h2>
            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#accordionFAQ">
              <div class="accordion-body">
                Choose a plan that aligns with your needs, budget, and lifestyle. Make sure to consider factors such as coverage, premiums, and customer support.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false">
                How much does my health insurance plan cost?
              </button>
            </h2>
            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
              <div class="accordion-body">
                The cost of your health insurance plan depends on factors such as coverage, premiums, and the number of policies you have. It may also include additional fees or discounts for certain plans.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false">
                What does my health insurance plan cover?
              </button>
            </h2>
            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
              <div class="accordion-body">
                Most plans cover hospital stays, doctor visits, medications, and preventive care. However, coverage varies, so review your policy details to understand what's included.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false">
                Can I change my health insurance plan later?
              </button>
            </h2>
            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
              <div class="accordion-body">
                Yes, you can usually change your health insurance plan during open enrollment or after a qualifying life event, such as marriage, childbirth, or job change.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5" aria-expanded="false">
                How do I use my health insurance with a QR code?
              </button>
            </h2>
            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
              <div class="accordion-body">
                You can use your health insurance by scanning your unique QR code at partnered hospitals and clinics. The system will automatically verify your coverage and eligibility, allowing for a seamless and paperless experience.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- FAQ Section End -->

<!-- Latest News Section Start -->
<section class="latest-news px-1 px-md-3 px-lg-4 pb-5 w-100">
  <div class="container-xxl pb-5">
    <hr class="hr mb-5">
    <h2 class="text-center fw-bold display-5 mb-5">Latest <span class="text-primary">News.</span></h2>
    <div class="row g-4 justify-content-center">
      <?php foreach($latestNews as $news): ?>
      <div class="col-12 col-md-4 col-lg-3">
        <div class="card">
          <img class="card-img-top mb-0 border-bottom" src="<?= base_url('uploads/news/' . $news['newsThumbnail']); ?>" alt="Latest News Image" draggable="false">
          <div class="card-body py-3">
            <h5 class="card-title my-0"><?= $news['newsTitle'];  ?></h5>
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
    <a type="button" href="<?= base_url('news'); ?>" class="btn-primary px-3 text-decoration-none position-relative start-50 end-50 translate-middle" style="margin-top: 80px;">
      Browse All News
    </a>
  </div>
</section>
<!-- Latest News Section Start -->