<!-- ======= Hero Slider Section ======= -->
<section id="hero-slider" class="hero-slider">
   <div class="container-md" data-aos="fade-in">
      <div class="row">
         <div class="col-12">
            <div class="swiper sliderFeaturedPosts">
               <div class="swiper-wrapper">
                  <?php foreach ($recentPosts as $post) { ?>
                     <div class="swiper-slide">
                        <a href="/post?id=<?= $post['id'] ?>" class="img-bg d-flex align-items-end" style='background-image: url("/uploads/<?php echo $post['image'] ?>");'>
                           <div class="img-bg-inner">
                              <h2><?= $post['title'] ?></h2>
                           </div>
                        </a>
                     </div>
                  <?php } ?>
               </div>
            </div>
            <div class="custom-swiper-button-next">
               <span class="bi-chevron-right"></span>
            </div>
            <div class="custom-swiper-button-prev">
               <span class="bi-chevron-left"></span>
            </div>
            <div class="swiper-pagination"></div>
         </div>
      </div>
   </div>
   </div>
</section>
<!-- End Hero Slider Section -->
<!-- ======= Post Grid Section ======= -->
<!-- End .row -->
<!-- End Post Grid Section -->
<!-- ======= Post Grid Section ======= -->
<section>
   <div class="container">
      <div class="row">
         <div class="col-md-9" data-aos="fade-up">
            <?php foreach ($posts as $post) { ?>
               <div class="d-md-flex post-entry-2 half">
                  <a href="/post?id=<?= $post['id'] ?>" class="me-4 thumbnail">
                     <img src="/uploads/<?= $post['image'] ?>" alt="" class="img-fluid" width="900px" height="571px">
                  </a>
                  <div>
                     <div class="post-meta"><span class="date"><?= $categoriesName[$post['category_id']] ?></span> <span class="mx-1">&bullet;</span> <span><?= $post['date'] ?></span></div>
                     <h3><a href="/post?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h3>
                     <p></p>
                     <div class="d-flex align-items-center author">
                        <div class="name">
                           <h3 class="m-0 p-0"><?= $users[$post['user_id']] ?></h3>
                        </div>
                     </div>
                  </div>
               </div>
            <?php } ?>
         </div>
         <div class="col-md-3">
            <div class="aside-block">
               <h3 class="aside-title">Search</h3>
               <div class="js-search-form-wrap">
                  <form method="GET" action="/search" class="search-form position-relative">
                     <input type="text" placeholder="Search" class="form-control" name="search" >
                     <button class="btn search-button " style="position:absolute; top:0px ;right:0px"><span class="icon bi-search"></span></button>
                  </form>
               </div>
            </div>
            <div class="aside-block">
               <h3 class="aside-title">Categories</h3>
               <ul class="aside-links list-unstyled">
                  <?php foreach ($categories as $category) : ?>
                     <li><a href="/category?id=<?= $category['id'] ?>"><i class="bi bi-chevron-right"></i><?= $category['title'] ?></a></li>
                  <?php endforeach; ?>
               </ul>
            </div>
            <!-- End Categories -->
         </div>
      </div>
   </div>
</section>
<!-- End Post Grid Section -->