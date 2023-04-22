<section class="single-post-content">
    <div class="container">
        <div class="row">
            <div class="col-md-9 post-content" data-aos="fade-up">
                <!-- ======= Single Post Content ======= -->
                <div class="single-post">
                    <div class="post-meta"><span class="date"><?= $category?></span> <span class="mx-1">&bullet;</span> <span><?= $post['date'] ?></span></div>
                    <h1 class="mb-3">
                        <?= $post['title'] ?>
                    </h1>
                    <h3 class="m-0 p-0"></h3>
                    <p>
                        <?= $post['description'] ?>
                    </p>
                    <figure class="my-4 ">
                        <img src="/uploads/<?= $post['image'] ?>" alt="Post Image" class="img-fluid post-single-image">
                    </figure>
                </div>
                <!-- End Single Post Content -->
                <!-- ======= Comments ======= -->
                <?php if (isLoggedIn()) : ?>
                    <div class="comments">
                        <h5 class="comment-title">
                            <?= count($comments).' ' ."comments" ?>
                        </h5>
                        <div class="comment d-flex mb-4">
                            <div class="flex-grow-1 ms-2 ms-sm-3">
                                <?php foreach ($comments as $comment) : ?>
                                <div class="comment-meta d-flex align-items-baseline mt-4">
                                    <h6 class="me-2">
                                        <?= $comment['author']?>
                                    </h6>
                                </div>
                                <div class="comment-body mb-3">
                                    <?= $comment['message'] ?>
                                </div>
                                <form method="POST" action="/post?post_id=<?= $comment['post_id'] ?>">
                                    <input type="hidden" name="parent_id" value="<?= $comment['id'] ?>">
                                    <input type="hidden" name="user_id" value="<?= getUser()['id'] ?>">
                                    <div class="flex-grow-1 ms-2 ms-sm-3">
                                        <div class="reply-body mb-2">
                                            <input class="form-control" name="message" placeholder="Reply">
                                        </div>
                                        <?php if (isset($validator) && $validator->hasError('message') && $comment['id'] == $parent_id ) : ?>
                                        <div class="text-danger">
                                            <?= $validator->getFirstError('message') ?>
                                        </div>
                                        <?php endif; ?>
                                        <div class="col-12">
                                            <input type="submit" class="btn btn-primary" value="Reply">
                                        </div>
                                    </div>
                                </form>
                                <?php foreach ($comment['replies'] as $reply) : ?>
                                <div class="comment-replies bg-light p-3 mt-3 rounded">
                                    <div class="reply d-flex mb-6">
                                        <div class="flex-grow-1 ms-2 ms-sm-3">
                                            <div class="reply-meta d-flex align-items-baseline">
                                                <h6 class="mb-0 me-2">
                                                    <?= $reply['replyAuthor']  ?>
                                                </h6>
                                                <!-- <span class="text-muted">2d</span> -->
                                            </div>
                                            <div class="reply-body">
                                                <?= $reply['message'] ?? '' ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach;?>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                    <!-- End Comments -->
                    <!-- ======= Comments Form ======= -->
                    <div class="row justify-content-center mt-5">
                        <form method="POST" action="/post?post_id=<?= $post['id'] ?>">
                            <input type="hidden" name="user_id" value="<?= getUser()['id'] ?>">
                            <input type="hidden" name="parent_id" value="0">
                            <div class="col-lg-12">
                                <h5 class="comment-title">Leave a Comment</h5>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <textarea class="form-control" name="message" placeholder="Enter your message" cols="30" rows="5"></textarea>
                                        <?php if (isset($validator) && $validator->hasError('message') && $parent_id == 0) : ?>
                                        <div class="text-danger">
                                            <?= $validator->getFirstError('message') ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-12">
                                        <input type="submit" class="btn btn-primary" value="Post comment">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
                <!-- End Comments Form -->
            </div>
            <div class="col-md-3">
                <div class="aside-block">
                    <h3 class="aside-title">Categories</h3>
                    <ul class="aside-links list-unstyled">
                        <?php foreach ($categories as $category) : ?>
                        <li><a href="/category?id=<?= $category['id'] ?>"><i class="bi bi-chevron-right"></i><?= $category['title'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>