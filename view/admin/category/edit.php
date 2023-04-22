<section class="vh-100 bg-image" style="background-image: url();">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="p-3">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                    <li class="breadcrumb-item "><a href="/admin/categories">Categories</a></li>
                    <li class="breadcrumb-item active"><a href="">Edit Category</a></li>
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
                            <form method="post" action="/admin/category/edit?id=<?= $category['id'] ?>">
                                <input type="hidden" id="id" class="form-control form-control-lg" name="id" value="<?= $category['id'] ?>" />
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example1cg">Title</label>
                                    <input type="text" id="form3Example1cg" class="form-control form-control-lg" name="title" value="<?= $category['title'] ?>" />
                                    <?php if (isset($validator) && $validator->hasError('title')) :  ?>
                                        <div class="text-danger">
                                            <?= $validator->getFirstError('title') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example1cg">Description</label>
                                    <input type="text" id="form3Example1cg" class="form-control form-control-lg" name="description" value="<?= $category['description'] ?>" />
                                    <?php if (isset($validator) && $validator->hasError('description')) :  ?>
                                        <div class="text-danger">
                                            <?= $validator->getFirstError('description') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
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