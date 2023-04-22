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
                    <a href="/admin/post/create" class="btn btn-success mb-3"><i class="material-icons">&#xE147;</i>
                        <span>Add New Post</span></a>
                </div>
            </div>
            <?php if(count($posts) > 0) :?>
                <div class="col-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Date</th>
                                <th scope="col">Image</th>
                                <th scope="col">User </th>
                                <th scope="col">Category </th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php
                                foreach ($posts as $data) : ?>
                                    <tr>
                                        <th scope="row"><?= $data['id'] ?></th>
                                        <td><a href = "/post?id=<?= $data['id'] ?>"> <?= $data['title'] ?></a></td>
                                        <td><?= $data['description'] ?></td>
                                        <td><?= $data['date'] ?></td>
                                        <td><img src="/uploads/<?= $data['image'] ?>" class="rounded-3" style="width: 150px; height:100px; object-fit:cover;" alt="Avatar" /></td>
                                        <td><?= $users[$data['user_id']] ?></td>
                                        <td><?= $categories[$data['category_id'] ]?></td>
                                        <td>
                                            <a href="/admin/post/edit?id=<?= $data['id'] ?>" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                            <a href="/admin/post/delete?id=<?= $data['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger"><i class="far fa-trash-alt"> </i></a>
                                        </td>
                                    </tr>
                                <?php   endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination nav nav-pills">
                        <?php $previous = $currentpage - 1;
                        $next = $currentpage +1;
                        ?>
                        <li class="page-item">
                            <a class="<?php if($currentpage == 1){?>btn disabled<?php }?> page-link" href="/admin/posts?page=<?=$previous?>">
                                Previous 
                            </a>
                            <?php for ($i = 1; $i <= $totalPages; $i++) {
                            ?>
                        <li class="page-item"><a class="page-link <?php if($currentpage == $i):?>nav-link active<?php endif;?>" href="/admin/posts?page=<?= $i ?>"><?= $i ?></a></li>
                    <?php } ?>
                        <li class="page-item">
                            <a class="<?php if($currentpage >= $totalPages){?>btn disabled<?php }?> page-link" href="/admin/posts?page=<?=$next?>">
                                Next
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php else:?>
                <div class="p-3 mb-2 bg-primary text-white col-12">No Posts Found</div>
            <?php endif;?>  
        </div>
    </form>
</div>