<?php require_once VIEW_PATH . '/header.php'; ?>

 <?php $singleBlog = explode('?', $_SERVER['REQUEST_URI']);
 ?>

<a href="/blogPosts" class="btn btn-light"> Back to All Blogs </a>

<h1> <?php  echo $this->params['title']; ?> </h1>

<div class="bg-secondary text-white p-2 mb-3">
Blogged By <?php echo $this->params['username'];?> on <?php echo $this->params['created_at']; ?>
</div>

<p>  <?php echo $this->params['blog_body']; ?> </p>
<?php if($this->params['user_id'] == $_SESSION['user_id']) : ?>

        <a href="/blog/edit?<?php echo $this->params['id'];?> " class="btn btn-dark"> Edit Blog </a>
        <form class="float-right" action="delete?<?php echo $this->params['id'];?>" method="post">
            <input type="submit" value="Delete Blog" class="btn btn-danger">
        </form>

<?php endif; ?>
<hr>
<h3> Blog Replies </h3>
<?php foreach ($this->params['comments'] as $comment) : ?>
<div class="bg-secondary text-white p-2 mb-3">
Replied by <?php echo $comment['username'];?> at <?php echo $comment['created_at'];?>
</div>
    <p class="card-text"><?php echo $comment['body'];?> </p>
    <hr>
<?php endforeach;?>


<div class="form-group">
    <label for="comment"> Add Comment To Blog </label>
    <textarea
            name="comment_body" class="form-control form-control-lg" <?php echo (!empty($this->params
        ['body_err']) && ($this->params['body_err'] != '')) ? 'is-invalid' : ''; ?>
        >

    </textarea>
    <input type="submit" value="Submit Comment" class="btn btn-success">
</div>

<?php //var_dump($this->params['comments']); ?>

<?php require_once VIEW_PATH . '/footer.php'; ?>
