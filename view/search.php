<section>
  <div class="container">
    <div class="row">
      <div class="col-md-9" data-aos="fade-up">
        <?php if (count($posts) == 0) : ?>
          <div class="d-md-flex post-entry-2 half">
            <div>
              <div class="p-3 mb-2 bg-primary text-white">No Posts Found</div>
            </div>
          </div>
        <?php else : ?>
          <?php foreach ($posts as $post) : ?>
            <div class="d-md-flex post-entry-2 half">
              <a href="/post?id=<?= $post['id'] ?>" class="me-4 thumbnail">
                <img src="/uploads/<?= $post['image'] ?>" alt="" class="img-fluid post-image">
              </a>
              <div>
                <div class="post-meta"><span class="date"><?= $post['name']  ?></span> <span class="mx-1">&bullet;</span> <span><?= $post['date'] ?></span></div>
                <h3><a href="/post?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h3>
                <p><?= $post['description'] ?></p>
                <div class="d-flex align-items-center author">
                  <div class="name">
                    <h3 class="m-0 p-0"><?= $post['author']  ?></h3>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
          <?php
          $previous = $currentpage - 1;
          $next = $currentpage + 1;
          ?>
          <div class="text-start py-4">
            <div class="custom-pagination">
              <a href="/search?page=<?= $previous ?>&<?= getQueryString('page') ?>" class="<?php if ($currentpage == 1) : ?> disabled <?php endif ?> page-link prev">
                Previous
              </a>
              <?php for ($i = 1; $i <= $totalPages; $i++) {
              ?>
                <a href="/search?page=<?= $i ?>&<?= getQueryString('page') ?>" class="<?php if ($currentpage == $i) : ?> active <?php endif ?>"><?= $i ?></a>
              <?php } ?>
              <a href="/search?page=<?= $next ?>&<?= getQueryString('page') ?>" class="<?php if ($currentpage >= $totalPages) : ?> disabled <?php endif ?> page-link next">
                Next
              </a>
            </div>
          </div>
        <?php endif; ?>
      </div>
      <div class="col-md-3">
        <!-- ======= Sidebar ======= -->
        <div class="aside-block">
          <h3 class="aside-title">Search</h3>
          <div class="js-search-form-wrap">
            <form method="GET" action="/search" class="search-form position-relative">
              <input type="text" placeholder="Search" class="form-control" name="search" value="<?= $search ?>">
              <button class="btn search-button " style="position:absolute; top:0px ;right:0px"><span class="icon bi-search"></span></button>
            </form>
          </div>
        </div>
        <div class="aside-block">
          <h3 class="aside-title">Categories</h3>
          <ul class="aside-tags list-unstyled">
            <?php foreach ($categories as $category) : ?>
              <li><a href="/category?id=<?= $category['id'] ?>"><?= $category['title'] ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <!-- End Tags -->
      </div>
    </div>
  </div>
</section>