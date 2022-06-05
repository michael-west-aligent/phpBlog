
<?php require_once VIEW_PATH . '/header.php'; ?>

<?php //var_dump($this->params) ?>


 <?php $sigleBlog = explode('?', $_SERVER['REQUEST_URI']);
// var_dump($sigleBlog)
 ?>

<a href="/blogPosts" class="btn btn-light"> Back to All Blogs </a>
<br>
<h1> <?php  echo $this->params['title']; ?> </h1>


<br>
<h4 class="card-title"> <?php echo $this->params['title']; ?> </h4>
<h4 class="card-title"> <?php echo $this->params['id']; ?> </h4>
<h4 class="card-title"> <?php echo $this->params['blog_body']; ?> </h4>
<h4 class="card-title"> <?php echo $this->params['created_at']; ?> </h4>

<?php require_once VIEW_PATH . '/footer.php'; ?>
