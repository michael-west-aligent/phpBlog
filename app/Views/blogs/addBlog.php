<?php
require_once VIEW_PATH . '/header.php';
?>

<?php require_once VIEW_PATH . '/header.php'; ?>
<a href="/blogPosts" class="btn btn-light"> Back to All Blogs </a>

<div class="card card-body bg light mt-5">
    <h2> Add A New Blog </h2>
    <p> Fill out the form to create a new blog  </p>
    <!--    <form action="/posts/addBlog" method="post">-->
    <form action="/blog/addBlog" method="post">
        <div class="form-group">
            <label for="title"> Title: <sup>*</sup></label>
            <input type="text" name="title" class="form-control form-control-lg" <?php echo (!empty($this->params
                ['title_err']) && ($this->params['title_err'] != '')) ? 'is-invalid' : ''; ?>
                   value="<?php echo !empty($this->params['title']) ? $this->params['title'] : ''; ?>">
            <span style="color: darkred"> <?php echo $this->params['title_err']; ?> </span>
        </div>


        <div class="form-group">
            <label for="body"> Blog Body: <sup>* This needs to be less than 76 characters</sup></label>
            <textarea name="blog_body" class="form-control form-control-lg" <?php echo (!empty($this->params
                ['blog_body_err']) && ($this->params['blog_body_err'] != '')) ? 'is-invalid' : ''; ?>
                <?php echo ($this->params['blog_body']); ?>> </textarea>
            <span style="color: darkred"> <?php echo $this->params['blog_body_err']; ?> </span>
        </div>

        <input type="submit" class="btn btn-success" value="Submit"/>

    </form>
</div>


<?php
require_once VIEW_PATH . '/footer.php';
?>
