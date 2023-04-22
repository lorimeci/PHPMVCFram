<section class="vh-100 bg-image" style="background-color: #eee;">
   <div class="mask d-flex align-items-center h-100 gradient-custom-3">
      <div class="container h-100">
         <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6">
               <div class="card" style="border-radius: 15px;">
                  <div class="card-body p-5">
                     <h2 class="text-uppercase text-center mb-5">Login</h2>
                     <?php if (getFlash('success')) : ?>
                        <div class="alert alert-success">
                           <?php echo getFlash('success') ?>
                        </div>
                        <?php elseif (getFlash('error')) : ?>
                           <div class="alert alert-danger">
                           <?php echo getFlash('error') ?>
                        </div>
                     <?php endif; ?>
                     <form method="POST" action="">
                        <input type="hidden" name="id" value="" />
                        <div class="form-outline mb-4">
                           <label class="form-label" for="form3Example3cg">Your Email</label>
                           <input type="email" id="form3Example3cg" class="form-control form-control-lg " name="email" />
                           <?php if (isset($validator) && $validator->hasError('email')) :  ?>
                              <div class="text-danger">
                                 <?= $errors['email'][0] ?>
                              </div>
                           <?php endif; ?>
                        </div>
                        <div class="form-outline mb-4">
                           <label class="form-label" for="form3Example4cg">Password</label>
                           <input type="password" id="form3Example4cg" class="form-control form-control-lg" name="password" />
                           <?php if (isset($validator) && $validator->hasError('password')) :  ?>
                              <div class="text-danger">
                                 <?= $errors['password'][0] ?>
                              </div>
                           <?php endif; ?>
                        </div>
                        <div class="d-flex justify-content-center">
                           <button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Login</button>
                        </div>
                        <p class="text-center text-muted mt-5 mb-0">You don't have an account? <a href="/register" class="fw-bold text-body"><u>Register here</u></a></p>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>