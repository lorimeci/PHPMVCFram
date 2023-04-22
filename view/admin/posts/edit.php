<section class="vh-100 bg-image">
<div class="row">
    <div class="col">
        <nav aria-label="breadcrumb" class="p-3">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                <li class="breadcrumb-item "><a href="/admin/posts">Posts</a></li>
                <li class="breadcrumb-item active"><a href="">Edit Post</a></li>
            </ol>
        </nav>
    </div>
</div>
<div class="mask d-flex  h-100 gradient-custom-3">
    <div class="container h-100">
        <div class="row d-flex justify-content-center h-100">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                <div class="card" style="border-radius: 15px;">
                    <div class="card-body p-5">
                        <form method="post" action="/admin/post/edit?id=<?= $post['id'] ?>" enctype="multipart/form-data">
                            <div class="form-outline mb-4">
                                <label class="form-label" for="form3Example1cg">Title</label>
                                <input type="text" id="form3Example1cg" class="form-control form-control-lg" name="title" value="<?= $post['title'] ?>" />
                                <?php if (isset($validator) && $validator->hasError('title')) :  ?>
                                    <div class="text-danger">
                                        <?= $validator->getFirstError('title') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="form3Example1cg">Description</label>
                                <input type="text" id="form3Example1cg" class="form-control form-control-lg" name="description" value="<?= $post['description'] ?>" />
                                <?php if (isset($validator) && $validator->hasError('description')) :  ?>
                                    <div class="text-danger">
                                        <?= $validator->getFirstError('description') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="form3Example3cg">Image</label>
                                <input type="file" class="form-control form-control-lg" name="image" value="" />
                                <?php if (isset($validator) && $validator->hasError('image')) :  ?>
                                    <div class="text-danger">
                                        <?= $validator->getFirstError('image') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label name="category_id"> Categories </label>
                                <select name="category_id" value="" class="form-select form-select-lg mb-3">
                                    <?php $selction = array($categories['title'])?>
                                    <?php foreach ($categories as $category) :  ?>
                                        <option value="<?= $category['id'] ?>" <?php  if($post['category_title'] == $category['title'] ) echo 'selected="selected"'; ?>> <?= $category['title'] ?></option>
                                    <?php  endforeach; ?>
                                </select>
                            </div>
                            <input type="hidden" name="user_id" value="<?= getUser()['id'] ?>">
                            <input type="hidden" name="date">
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>