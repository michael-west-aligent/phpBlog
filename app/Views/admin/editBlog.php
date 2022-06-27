<?php
require_once VIEW_PATH . '/header.php';
?>

<?php //echo ($this->params['id']) ?>
<?php //echo ($this->params['title']) ?>

<a href="/blogPosts" class="btn btn-light"> Back to All Blogs </a>

<div class="card card-body bg light mt-5">
    <h2> Admin Edit Blog -  ID <?php echo $this->params['id']?> </h2>
    <p> Edit the blog title or blog body!  </p>
    <form action="/blog/updatePost" method="post">
        <div class="form-group">
            <label for="title"> Title: <sup>*</sup></label>
            <input type="text" name="title" class="form-control form-control-lg"
                   value="<?php echo !empty($this->params['title']) ? $this->params['title'] : ''; ?>"/>
        </div>


        <div class="form-group">
            <label for="body"> Blog Body: <sup>*</sup></label>
            <textarea name="blog_body" class="form-control form-control-lg"
                   ><?php echo ($this->params['blog_body']); ?></textarea>
        </div>

        <input type="hidden" name="post_id" value="<?= $this->params['id'] ?>"/>
        <input type="submit" class="btn btn-success"  value="Make Blog Changes "/>
        <?php if (isset($this->params['error_message'])): ?>
        <span style="color: darkred"> <?php echo $this->params['error_message']; ?> </span>
        <?php endif ?>

    </form>

    <a href="/admin/approveBlogComment?<?php echo $this->params['id']?> " >
        <button type="submit" value="Update User" class="btn btn-success"> View Full Blog to Approve or Remove Comments </button>
    </a>
</div>