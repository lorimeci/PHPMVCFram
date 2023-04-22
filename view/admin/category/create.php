<section class="vh-100 bg-image" style="background-image: url();">
   <div class="mask d-flex align-items-center h-100 gradient-custom-3">
      <div class="container h-100">
         <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6">
               <div class="card" style="border-radius: 15px;">
                  <div class="card-body p-5">
                     <h3 class="text-uppercase text-center mb-5">Add Category</h3>
                     <form method="post" action ="/admin/category/create">
                        <input type="hidden" name="id" value="<?= $category['id'] ?>">
                        <div class="form-outline mb-4">
                           <label class="form-label" for="form3Example1cg">Title </label>
                           <input type="text" id="form3Example1cg" class="form-control form-control-lg" name="title" />
                           <?php if (isset($validator) && $validator->hasError('title')) :  ?>
                           <div class="text-danger">
                              <?= $validator->getFirstError('title') ?>
                           </div>
                           <?php endif; ?>
                        </div>
                        <div class="form-outline mb-4">
                           <label class="form-label" for="form3Example1cg">Description </label>
                           <textarea type="text" id="form3Example1cg" class="form-control form-control-lg" name="description"> </textarea>
                           <?php if (isset($validator) && $validator->hasError('description')) :  ?>
                           <div class="text-danger">
                              <?= $validator->getFirstError('description') ?>
                           </div>
                           <?php endif; ?>
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