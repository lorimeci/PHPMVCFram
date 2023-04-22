<?php if (getFlash('error')) : ?>
    <div class="alert alert-danger">
        <?php echo getFlash('error') ?>
    </div>
<?php elseif (getFlash('success')) : ?>
    <div class="alert alert-success">
        <?php echo getFlash('success') ?>
    </div>
<?php endif; ?>
<section class="vh-100 bg-image">
    <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="p-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item "><a href="/admin/comments">Comments</a></li>
                        <li class="breadcrumb-item active"><a href="">Edit Comment</a></li>
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
                        <form method="post" action="">
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example1cg">Message</label>
                                    <input type="text" id="form3Example1cg" class="form-control form-control-lg" name="message" value="<?= $comment['message'] ?>" />
                                    <?php if (isset($validator) && $validator->hasError('message')) :  ?>
                                        <div class="text-danger">
                                            <?= $validator->getFirstError('message') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label name="status"> Status </label>
                                    <select name="status">
                                        <option value="0" 
                                        <?php
                                         if ($comment['status'] == '0') echo 'selected="selected"'; ?>>Pending
                                        </option>
                                        <option value="1"
                                        <?php
                                        if ($comment['status'] == '1') echo 'selected="selected"'; ?>>Approved
                                        </option>
                                        <option value="2" 
                                        <?php
                                         if ($comment['status'] == '2') echo 'selected="selected"'; ?>>Unapproved
                                        </option>
                                    </select>
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