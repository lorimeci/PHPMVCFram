<?php if (getFlash('success')) : ?>
    <div class="alert alert-success">
        <?php echo getFlash('success') ?>
    </div>
<?php endif; ?>
<div class="container">
    <form method="GET">
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Post</th>
                            <th scope="col">Message</th>
                            <th scope="col">Status</th>
                            <th scope="col">User</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($comments as $data) : ?>
                            <tr>
                                <th scope="row"><?= $data['id'] ?></th>
                                <td><a href ="/post?id=<?= $data['post_id'] ?>"><?= $postTitle[$data['post_id']] ?? ''?></a></td>
                                <td><?= $data['message'] ?></td>
                                <td><?php if ($data['status'] == '0') echo '<p class="text-warning">Pending</p>'?>
                                <?php if ($data['status'] == '1') echo '<p class="text-success">Approved</p>'?>
                                <?php if ($data['status'] == '2') echo '<p class="text-danger">Unapproved</p>'?>
                                </td>
                                <td><?= $userName[$data['user_id']] ?? ''?></td>
                                <td>
                                    <a href="/admin/comment/edit?id=<?= $data['id'] ?>" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                    <a href="/admin/comment/delete?id=<?= $data['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger"><i class="far fa-trash-alt"> </i></a>

                                </td>
                            </tr>
                    </tbody>
                <?php endforeach; ?>
                </table>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination nav nav-pills">
                    <?php $previous = $currentpage - 1;
                    $next = $currentpage + 1;
                    ?>
                    <li class="page-item">
                        <a class="<?php if ($currentpage == 1) { ?>btn disabled<?php } ?> page-link" href="/admin/comments?page=<?= $previous ?>">
                            Previous
                        </a>
                        <?php for ($i = 1; $i <= $totalPages; $i++) {
                        ?>
                    <li class="page-item"><a class="page-link <?php if ($currentpage == $i) : ?>nav-link active<?php endif; ?>" href="/admin/comments?page=<?= $i ?>"><?= $i ?></a></li>
                <?php } ?>
                <li class="page-item">
                    <a class="<?php if ($currentpage >= $totalPages) { ?>btn disabled<?php } ?> page-link" href="/admin/comments?page=<?= $next ?>">
                        Next
                    </a>
                </li>
                </ul>
            </nav>
        </div>
    </form>
</div>