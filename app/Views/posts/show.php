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

        <a href="/blog/edit?<?php echo $this->params['id'];?> " class="btn btn-dark"> Edit </a>
        <form class="float-right" action="delete?<?php echo $this->params['id'];?>" method="post">
            <input type="submit" value="Delete" class="btn btn-danger">
        </form>
<?php endif; ?>

<div class="form-group">
    <label for="comment"> Add Comment To Blog </label>
    <textarea name="blog_body" class="form-control form-control-lg" <?php echo (!empty($this->params
        ['blog_body_err']) && ($this->params['blog_body_err'] != '')) ? 'is-invalid' : ''; ?>
        <?php echo ($this->params['blog_body']); ?>> </textarea>
    <input type="submit" value="Submit Comment" class="btn btn-success">
</div>




<!--<a href="/blog/edit?--><?php //echo $posts['postId'];?><!-- " class="btn btn-dark"> Edit </a>-->
<!--THIS IS NOT WORKING-->
<!--<h4 class="card-title"> --><?php //echo $this->params['title']; ?><!-- </h4>-->
<!--<h4 class="card-title"> --><?php //echo $this->params['id']; ?><!-- </h4>-->
<!--<h4 class="card-title"> --><?php //echo $this->params['blog_body']; ?><!-- </h4>-->
<!--<h4 class="card-title"> --><?php //echo $this->params['created_at']; ?><!-- </h4>-->
<!--<h4 class="card-title"> --><?php //echo $this->params['username']; ?><!-- </h4>-->


<?php require_once VIEW_PATH . '/footer.php'; ?>
