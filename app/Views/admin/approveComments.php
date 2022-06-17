<?php require_once VIEW_PATH . '/header.php'; ?>

<?php $singleBlog = explode('?', $_SERVER['REQUEST_URI']) [1];
?>

<a href="/blogPosts" class="btn btn-light"> Back to All Blogs </a>

<h1> <?php echo $this->params['title']; ?> </h1>

<div class="bg-secondary text-white p-2 mb-3">
    Blogged By<?php echo $this->params['username']; ?> on <?php echo $this->params['created_at']; ?>
</div>
<h3>  <?php echo $this->params['blog_body']; ?> </h3>
<?php
if ($_SESSION != null) :
    ?>
    <?php if ($this->params['user_id'] == $_SESSION['user_id']) : ?>
    <a href="/blog/edit?<?php echo $this->params['id']; ?> " class="btn btn-dark"> Edit Blog </a>
    <form class="float-right" action="/blog/delete" method="post">
        <input type="hidden" name="postId" value="<?= $this->params['id']; ?> ">
        <input type="submit" value="Delete Blog" class="btn btn-danger">
    </form>
<?php endif; ?>
<?php endif; ?>

<h3> Blog Replies </h3>
<?php //var_dump($this->params['comments']) ?>

<?php foreach ($this->params['comments'] as $comment) : ?>
<!--    --><?php //var_dump($comment['approved']) ?>

    <td>
        <form action="/admin/deleteBlogComment" method="post">
            <input type="hidden" name="comment_id" value="<?= $comment['id']; ?> ">
            <input type="submit" value="Delete Comment" class="float-right btn btn-danger">
        </form>
    </td>

    <form method="post" action="/admin/approvedComment">
        <input type="hidden">
        <div class="bg-secondary text-white p-2 mb-3">
            Replied by <?php echo $comment['username']; ?> at <?php echo $comment['created_at']; ?>
        </div>

        <h4 class="card-text"><?php echo $comment['body']; ?>    </h4>

        <label for="approved"> Approve Comment: <sup>Tick box to Approve Comment </sup></label>
        <?php if ($comment['approved'] == 0 || $comment['approved'] == null) : ?>
            <input type="checkbox" class="form-control form-control-lg" value="0">
            <input type="hidden" name="comment_id" value="<?php echo $comment['id'] ?>">
        <?php else: ?>
            <input type="checkbox" class="form-control form-control-lg" value="<?php echo 1 ?>" checked>
            <input type="hidden" name="comment_id" value="<?php echo $comment['id'] ?>">
        <?php endif ?>
        <input type="hidden" name="post_id" value="<?php echo $singleBlog ?>">
        <input type="hidden" name="approved" value="<?php echo 1 ?>">
        <input type="submit" class="btn btn-success" value="Approve Comment"/>
    </form>

<?php endforeach; ?>

<?php if ($_SESSION != null) : ?>
    <form action="/blog/addComment" method="post">
        <div class="form-group">
            <label for="comment"> Add Comment To Blog </label>
            <textarea name="body" class="form-control form-control-lg"
            <!--            --><?php //echo $comment['body'];?>
            </textarea>
            <input type="hidden" name="username" value="<?= $comment['username']; ?> ">
            <input type="hidden" name="post_id" value="<?= $this->params['id']; ?> ">
            <input type="submit" value="Submit Comment" class="btn btn-success">
        </div>
    </form>
<?php else : ?>
    <h2> Register or Login to make a comment </h2>
<?php endif; ?>
