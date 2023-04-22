 <section class="vh-100 bg-image" style="background-color: #eee;">
   <div class="mask d-flex align-items-center h-100 gradient-custom-3">
      <div class="container h-100">
         <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6">
               <div class="card" style="border-radius: 15px;">
                  <div class="card-body p-5">
                     <h2 class="text-uppercase text-center mb-5">Register</h2>
                     <form method="post">
                        <div class="form-outline mb-4">
                           <!-- <label class="form-label" for="form3Example1cg">Your Name</label> -->
                           <input type="text" id="form3Example1cg" class="form-control form-control-lg" name="firstname" placeholder="Name" value="<?=$data['firstname'] ?? ''?>" />
                           <?php if (isset($validator) && $validator->hasError('firstname')) :  ?>
                           <div class="text-danger">
                              <?= $validator->getFirstError('firstname') ?>
                           </div>
                           <?php endif; ?>
                        </div>
                        <div class="form-outline mb-4">
                           <!-- <label class="form-label" for="form3Example1cg">Last Name </label> -->
                           <input type="text" id="form3Example1cg" class="form-control form-control-lg" name="lastname" placeholder="Lastname" />
                           <?php if (isset($validator) && $validator->hasError('lastname')) :  ?>
                           <div class="text-danger">
                              <?= $validator->getFirstError('lastname') ?>
                           </div>
                           <?php endif; ?>
                        </div>
                        <div class="form-outline mb-4">
                           <!-- <label class="form-label" for="form3Example3cg">Your Email</label> -->
                           <input type="text" id="form3Example3cg" class="form-control form-control-lg" name="email"  placeholder="Email"/>
                           <?php if (isset($validator) && $validator->hasError('email')) :  ?>
                           <div class="text-danger">
                              <?= $validator->getFirstError('email') ?>
                           </div>
                           <?php endif; ?>
                        </div>
                        <div class="form-outline mb-4">
                           <!-- <label class="form-label" for="form3Example4cg">Password</label> -->
                           <input type="password" id="form3Example4cg" class="form-control form-control-lg" name="password" placeholder="Password"/>
                           <?php if (isset($validator) && $validator->hasError('password')) :  ?>
                           <div class="text-danger">
                              <?= $validator->getFirstError('password') ?>
                           </div>
                           <?php endif; ?>
                        </div>
                        <div class="form-outline mb-4">
                           <!-- <label class="form-label" for="form3Example4cdg">Repeat your password</label> -->
                           <input type="password" id="form3Example4cdg" class="form-control form-control-lg" name="confirmPassword" placeholder="Confirm Password" />
                           <?php if (isset($validator) && $validator->hasError('confirmPassword')) :  ?>
                           <div class="text-danger">
                              <?= $validator->getFirstError('confirmPassword') ?>
                           </div>
                           <?php endif; ?>
                        </div>
                        <input type="hidden" id="role" class="form-control form-control-lg" name="role" value="3" />
                        <input type="hidden" id="id" class="form-control form-control-lg" name="id" value="" />
                        <div class="d-flex justify-content-center">
                           <button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Register</button>
                        </div>
                        <p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="/login" class="fw-bold text-body"><u>Login here</u></a></p>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>