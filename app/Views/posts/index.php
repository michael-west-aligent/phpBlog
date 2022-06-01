<?php require_once VIEW_PATH . '/header.php'; ?>

<div class="row">
    <div class="col-md-6">
        <h1> Blog Posts</h1>
    </div>
    <div class="col-md-6">
        <a href="<?php VIEW_PATH . 'blog/add.php';?>" class="btn btn-primary float-right"> Add A Blog </a>
    </div>
</div>

<?php var_dump($this->params['posts']); ?>


<?php require_once VIEW_PATH . '/footer.php'; ?>
