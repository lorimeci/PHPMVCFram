<section style="background-color: #eee;" class="center">
  <div class="container py-2">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="card mb-4">
          <div class="card-body text-center">
            <img src="/uploads/avatar.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="my-3"><?= getUser()['firstname'] ?> <?= getUser()['lastname'] ?></h5>
            <p class="text-muted mb-1"><?php if (getUser()['role']  == 1) : ?>
                <td><?= 'Admin' ?></td>
              <?php elseif (getUser()['role']  == 2) : ?>
                <td><?= 'Content Creator' ?></td>
              <?php else : ?>
                <td><?= 'User' ?></td>
              <?php endif; ?>
            </p>
            <div class="d-flex justify-content-center mb-2">
              <button type="button" class="btn btn-outline-primary ms-1"><?= getUser()['email'] ?></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>