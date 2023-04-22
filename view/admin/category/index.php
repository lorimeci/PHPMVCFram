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
                    <a href="/admin/category/create" class="btn btn-success mb-3"><i class="material-icons">&#xE147;</i>
                        <span>Add New Category</span></a>
                </div>
            </div>
            <?php if(count($categories) > 0)  :?>
                <div class="col-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $data) { ?>
                                <tr>
                                    <th scope="row"><?= $data['id'] ?></th>
                                    <td> <?= $data['title'] ?></td>
                                    <td><?= $data['description'] ?></td>
                                    <td>
                                        <a href="/admin/category/edit?id=<?= $data['id'] ?>" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                        <a href="/admin/category/delete?id=<?= $data['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger"><i class="far fa-trash-alt"> </i></a>
                                    </td>
                                </tr>
                            <?php   } ?>    
                        </tbody>
                    </table>
                </div>   
                <nav aria-label="Page navigation example">
                    <ul class="pagination nav nav-pills">
                        <?php $previous = $currentpage - 1;
                        $next = $currentpage +1;
                        ?>
                        <li class="page-item">
                            <a class="<?php if($currentpage == 1){?>btn disabled<?php }?> page-link" href="/admin/categories?page=<?=$previous?>">
                                Previous 
                            </a>
                            <?php for ($i = 1; $i <= $totalPages; $i++) {
                            ?>
                        <li class="page-item"><a class="page-link <?php if($currentpage == $i):?>nav-link active<?php endif;?>" href="/admin/categories?page=<?= $i ?>"><?= $i ?></a></li>
                    <?php } ?>
                        <li class="page-item">
                            <a class="<?php if($currentpage >= $totalPages){?>btn disabled<?php }?> page-link" href="/admin/categories?page=<?=$next?>">
                                Next
                            </a>
                        </li>
                    </ul>
                </nav>
            <?php else:?>
                <div class="p-3 mb-2 bg-primary text-white col-12">No Category Found</div>
            <?php endif;?>     
    </form>  
</div>      