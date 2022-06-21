<?php require_once VIEW_PATH . '/header.php'; ?>

    <div class="row mb-4">
        <div class="col-md-6">
            <h1> Blog Posts</h1>
        </div>
        <div class="col-md-6">
            <?php if($_SESSION != null && $_SESSION['is_admin']) : ?>

                <a href="/blog/addBlog" class="btn btn-primary float-right"> Add A Blog </a>
                <a href="/admin/home" class="btn float-right"> Return To Admin Home  </a>

            <?php else : ?>
                <a href="/blog/addBlog" class="btn btn-primary float-right"> Add A Blog </a>
            <?php endif ?>
        </div>
    </div>

<?php foreach($this->params['posts'] as $posts) : ?>

    <div class="card card-body mb-3">
        <h4 class="card-title"> Blog Title:  <?php echo $posts['title']; ?> </h4>
        <div class="bg-light p-2 mb-3">
            Blogged By <?php echo $posts['username']; ?> on <?php echo $posts['postCreated']; ?>
        </div>

        <p class="card-text"><?php echo $posts['blog_body']?> </p>
        <a href="/blog/show?<?php echo $posts['postId'];?>" class="btn btn-dark"> View the Full Blog</a>
        <p> Number of Blog Replies  <?php echo $posts['postComments']['postComments']; ?>  </p>


    </div>

<?php endforeach; ?>

<?php require_once VIEW_PATH . '/footer.php'; ?>