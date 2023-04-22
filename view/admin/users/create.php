<section class="vh-100 bg-image">
<div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="p-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item "><a href="/admin/users">Users</a></li>
                        <li class="breadcrumb-item active"><a href="">Add User</a></li>
                    </ol>
                </nav>
            </div>
    </div>
   <div class="mask d-flex  gradient-custom-3">
      <div class="container h-100">
         <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6">
               <div class="card" style="border-radius: 15px;">
                  <div class="card-body p-5">
                     <form method="post" action ="/admin/user/create">
                        <div class="form-outline mb-4">
                           <label class="form-label" for="form3Example1cg">First Name</label>
                           <input type="text" id="form3Example1cg" class="form-control form-control-lg" name="firstname" />
                           <?php if (isset($validator) && $validator->hasError('firstname')) :  ?>
                           <div class="text-danger">
                              <?= $validator->getFirstError('firstname') ?>
                           </div>
                           <?php endif; ?>
                        </div>
                        <div class="form-outline mb-4">
                           <label class="form-label" for="form3Example1cg">Last Name </label>
                           <input type="text" id="form3Example1cg" class="form-control form-control-lg" name="lastname" />
                           <?php if (isset($validator) && $validator->hasError('lastname')) :  ?>
                           <div class="text-danger">
                              <?= $validator->getFirstError('lastname') ?>
                           </div>
                           <?php endif; ?>
                        </div>
                        <div class="form-outline mb-4">
                           <label class="form-label" for="form3Example3cg">Email</label>
                           <input type="text" id="form3Example3cg" class="form-control form-control-lg" name="email" />
                           <?php if (isset($validator) && $validator->hasError('email')) :  ?>
                           <div class="text-danger">
                              <?= $validator->getFirstError('email') ?>
                           </div>
                           <?php endif; ?>
                        </div>
                        <div class="form-outline mb-4">
                           <label class="form-label" for="form3Example4cg">Password</label>
                           <input type="password" id="form3Example4cg" class="form-control form-control-lg" name="password" />
                           <?php if (isset($validator) && $validator->hasError('password')) :  ?>
                           <div class="text-danger">
                              <?= $validator->getFirstError('password') ?>
                           </div>
                           <?php endif; ?>
                        </div>
                           <div class="form-group">
                           <label name ="role"> Role </label>
                           <select name="role">
                              <option value="1">Admin</option>
                              <option value="2">Content Creator</option>
                              <option value="3">User</option>
                           </select>
                     </div>
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
   