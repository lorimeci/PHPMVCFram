<?php if (getFlash('success')) : ?>
    <div class="alert alert-success">
        <?php echo getFlash('success') ?>
    </div>
<?php endif; ?>
<div class="container">
    <form method="GET">
        <div class="row">
            <div class="col-6">
                <div class="col-sm-6">
                    <a href="/admin/user/create" class="btn btn-success mb-3"><i class="material-icons">&#xE147;</i>
                        <span>Add New User</span></a>
                </div>
            </div>
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($users as $data) { ?>
                            <tr>
                                <th scope="row"><?= $data['id'] ?></th>
                                <td> <?= $data['firstname'] ?></td>
                                <td><?= $data['lastname'] ?></td>
                                <td><?= $data['email'] ?></td>
                                <?php if ($data['role'] == 1) : ?>
                                    <td><?= 'Admin' ?></td>
                                <?php elseif ($data['role'] == 2) : ?>
                                    <td><?= 'Content Creator' ?></td>
                                <?php else : ?>
                                    <td><?= 'User' ?></td>
                                <?php endif; ?>
                                <td>
                                    <a href="/admin/user/edit?id=<?= $data['id'] ?>" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                    <?php if (isAdmin() && $data['id'] == 1) : ?>
                                    <?php else :  ?>
                                        <a href="/admin/user/delete?id=<?= $data['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger"><i class="far fa-trash-alt"> </i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                    </tbody>
                <?php   } ?>
                </table>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination nav nav-pills">
                    <?php $previous = $currentpage - 1;
                    $next = $currentpage + 1;
                    ?>
                    <li class="page-item">
                        <a class="<?php if ($currentpage == 1) { ?>btn disabled<?php } ?> page-link" href="/admin/users?page=<?= $previous ?>">
                            Previous
                        </a>
                        <?php for ($i = 1; $i <= $totalPages; $i++) {
                        ?>
                    <li class="page-item"><a class="page-link <?php if ($currentpage == $i) : ?>nav-link active<?php endif; ?>" href="/admin/users?page=<?= $i ?>"><?= $i ?></a></li>
                <?php } ?>
                <li class="page-item">
                    <a class="<?php if ($currentpage >= $totalPages) { ?>btn disabled<?php } ?> page-link" href="/admin/users?page=<?= $next ?>">
                        Next
                    </a>
                </li>
                </ul>
            </nav>
        </div>
    </form>
</div>