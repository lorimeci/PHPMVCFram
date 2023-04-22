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
                        <li class="breadcrumb-item "><a href="/admin/users">Users</a></li>
                        <li class="breadcrumb-item active"><a href="">Edit User</a></li>
                    </ol>
                </nav>
            </div>
    </div>
    <div class="mask d-flex gradient-custom-3">
        <div class="container h-100">
            <div class="row d-flex justify-content-center ">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-5">
                            <form method="post" action="/admin/user/edit?id=<?= $user['id'] ?>">
                                <input type="hidden" id="id" class="form-control form-control-lg" name="id" value="<?= $user['id'] ?>" />
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example1cg">Your Name</label>
                                    <input type="text" id="form3Example1cg" class="form-control form-control-lg" name="firstname" value="<?= $user['firstname'] ?>" />
                                    <?php if (isset($validator) && $validator->hasError('firstname')) :  ?>
                                        <div class="text-danger">
                                            <?= $validator->getFirstError('firstname') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example1cg">Last Name </label>
                                    <input type="text" id="form3Example1cg" class="form-control form-control-lg" name="lastname" value=" <?= $user['lastname'] ?>" />
                                    <?php if (isset($validator) && $validator->hasError('lastname')) :  ?>
                                        <div class="text-danger">
                                            <?= $validator->getFirstError('lastname') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example3cg">Your Email</label>
                                    <input type="text" id="form3Example3cg" class="form-control form-control-lg" name="email" value="<?= $user['email'] ?>" />
                                    <?php if (isset($validator) && $validator->hasError('email')) :  ?>
                                        <div class="text-danger">
                                            <?= $validator->getFirstError('email') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example4cg">Password</label>
                                    <input type="password" id="form3Example4cg" class="form-control form-control-lg" name="password" value="" />
                                    <?php if (isset($validator) && $validator->hasError('password')) :  ?>
                                        <div class="text-danger">
                                            <?= $validator->getFirstError('password') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example4cdg">Confirm Password</label>
                                    <input type="password" id="form3Example4cdg" class="form-control form-control-lg" name="confirmPassword" />
                                    <?php if (isset($validator) && $validator->hasError('confirmPassword')) :  ?>
                                        <div class="text-danger">
                                            <?= $validator->getFirstError('confirmPassword') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label name="role"> Role </label>
                                    <select name="role">
                                        <option value="1" 
                                        <?php
                                        if ($user['role'] == '1') echo 'selected="selected"'; ?>>Admin</option>
                                        <option value="2" 
                                        <?php
                                        if ($user['role'] == '2') echo 'selected="selected"'; ?>>Content Creator</option>
                                        <option value="3"
                                         <?php
                                        if ($user['role'] == '3') echo 'selected="selected"'; ?>>User</option>
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