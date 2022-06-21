<?php
require_once VIEW_PATH . '/header.php'; ?>

<?php
$post = new \App\Models\Post();
$allPosts = $post->blogsPostsForHomePage();
?>

    <div class="jumbotron jumbotron-fluid text-center">
        <div class="container">
            <h1 class="display-3"> Bloggin from ya noggin </h1>
            <p class="lead"> A place to blog </p>
            <p class="lead"> Register or Login to write your own blog  </p>
        </div>
    </div>

<?php foreach( $allPosts as $posts) : ?>
    <div class="card card-body mb-3">
        <h4 class="card-title"> <?php echo $posts['title']; ?> </h4>
        <div class="bg-light p-2 mb-3">
            Blogged By <?php echo $posts['username']; ?> on <?php echo $posts['postCreated']; ?>
        </div>
        <p class="card-text"><?php echo $posts['blog_body']?> </p>
        <a href="/blog/show?<?php echo $posts['postId'];?>" class="btn btn-dark"> View the Full Blog</a>
    </div>
<?php endforeach; ?>

<?php
require_once VIEW_PATH . '/footer.php'; ?>
