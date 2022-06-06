<?php require_once VIEW_PATH . '/header.php'; ?>
<!---->
<?php //var_dump($this->params) ?>


 <?php $singleBlog = explode('?', $_SERVER['REQUEST_URI']);
// var_dump($singleBlog)
 ?>

<a href="/blogPosts" class="btn btn-light"> Back to All Blogs </a>

<h1> <?php  echo $this->params['title']; ?> </h1>

<div class="bg-secondary text-white p-2 mb-3">
Blogged By <?php echo $this->params['username'];?> on <?php echo $this->params['created_at']; ?>
Blogged By <?php echo $this->params['username'];?> on <?php echo $this->params['created_at']; ?>
</div>


<p>  <?php echo $this->params['blog_body']; ?> </p>


<?php //if ($this->paramas['user_id'] == $_SESSION['user_id']) : ?>
<hr>
<!--    <a href="" class="btn btn-dark"> Edit </a>-->

<!--  <form action="--><?php //echo "/posts/delete"?><!-- --><?php //$this->params['id'];?><!--  method="post">-->
<!--    <input type="submit" value="Delete" class="btn btn-danger" />-->
<!--    </form>-->


<?php //endif; ?>

<a href="" class="btn btn-dark"> Edit </a>
//Want to have an edit and delete button but only if it belongs to the user


<!--<h4 class="card-title"> --><?php //echo $this->params['title']; ?><!-- </h4>-->
<!--<h4 class="card-title"> --><?php //echo $this->params['id']; ?><!-- </h4>-->
<!--<h4 class="card-title"> --><?php //echo $this->params['blog_body']; ?><!-- </h4>-->
<!--<h4 class="card-title"> --><?php //echo $this->params['created_at']; ?><!-- </h4>-->
<h4 class="card-title"> <?php echo $this->params['username']; ?> </h4>


<?php require_once VIEW_PATH . '/footer.php'; ?>
