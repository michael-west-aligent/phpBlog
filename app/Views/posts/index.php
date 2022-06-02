<?php require_once VIEW_PATH . '/header.php'; ?>

<div class="row mb-4">
    <div class="col-md-6">
        <h1> Blog Posts</h1>
    </div>
    <div class="col-md-6">
        <a href="/blog/addBlog" class="btn btn-primary float-right"> Add A Blog </a>
    </div>
</div>

<?php //var_dump($this->params['posts']); ?>

<?php foreach($this->params['posts'] as $posts) : ?>

<div class="card card-body mb-3">
    <h4 class="card-title"> <?php echo $posts['title']; ?> </h4>
    <div class="bg-light p-2 mb-3">
        Blogged By <?php echo $posts['username']; ?> on <?php echo $posts['postCreated']; ?>
    </div>
    <p class="card-text"><?php echo $posts['blog_body']?> </p>
<!-- ORIGINAL    <a href="--><?php //VIEW_PATH . 'blog/posts/show/';?><!-- --><?php //echo $posts['postId'];?><!--" class="btn btn-dark"> View the Full Blog</a>-->
    <a href="/blog/show/<?php echo $posts['postId'];?>" class="btn btn-dark"> View the Full Blog</a>
<!--IT IS GETTING THE SHOW/ID NUMVER FROM THE ABOVE LINE -->
</div>

<?php endforeach; ?>

<?php require_once VIEW_PATH . '/footer.php'; ?>