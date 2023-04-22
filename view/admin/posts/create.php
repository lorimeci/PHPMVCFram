<?php if(getFlash('success')) :?>
    <div class ="alert alert-danger">
        <?php echo getFlash('success') ?>
    </div>
<?php endif;?>
<section class="vh-100 bg-image" style="background-image: url();">
    <div class="mask d-flex align-items-center h-100 gradient-custom-3">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-5">
                            <form method="post" action="/admin/post/create" enctype="multipart/form-data">
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example1cg">Title</label>
                                    <input type="text" id="form3Example1cg" class="form-control form-control-lg" name="title" />
                                    <?php if(isset($validator) && $validator->hasError('title')) :  ?>
                                        <div class="text-danger">
                                            <?= $validator->getFirstError('title') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example1cg">Description</label>
                                    <textarea rows="5" cols="45" name = "description"></textarea>
                                    <?php if (isset($validator) && $validator->hasError('description')) :  ?>
                                        <div class="text-danger">
                                            <?= $validator->getFirstError('description') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example3cg">Image</label>
                                    <input type="file" id="form3Example3cg" class="form-control form-control-lg" name="image" accept="image/png, image/jpeg, image/jpg"  />
                                    <?php if (isset($validator) && $validator->hasError('image')) :  ?>
                                        <div class="text-danger">
                                            <?= $validator->getFirstError('image') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                        <label name="category_id"> Categories </label>
                                        <select name="category_id" value = "" class="form-select form-select-lg mb-3"  >
                                        <?php foreach ($categories as $category) :  ?>
                                            <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php if (isset($validator) && $validator->hasError('category_id')) :  ?>
                                        <div class="text-danger">
                                            <?= $validator->getFirstError('category_id') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <input type="hidden" name="user_id" value="<?= getUser()['id'] ?>">
                                <input type="hidden" name="date">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
