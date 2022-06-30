<?php
require_once VIEW_PATH . '/header.php';
?>

<?php
$post = new \App\Models\Post();
$allPosts = $post->adminBlogInfoHome();
?>



<a href="/blogPosts" class="btn btn-light"> Back to All Blogs </a>

<div class="card card-body bg light mt-5">
    <table>
        <h2> USERS </h2>
            <div class="button">
                <a href="/admin/addUser" class="btn btn-success"> Add a New User </a
            </div
            <div class="search">
            <form method="post" action="/admin/updateUserStatus">
                <input type="text"  name="id" placeholder="search by id" style="margin-top: 10px">
                <button type="submit" class="btn btn-primary"> Search </button>
            </form>
            </div>

        <tr>
            <th>id</th>
            <th>username</th>
            <th>is_admin</th>
            <th>created_at</th>
            <th>Update Status / Remove User</th>
        </tr>
        <?php foreach ($this->params['users'] as $users) : ?>
            <form action="/admin/updateUserStatus" method="post">
                <input name="id" value="<?php echo $users['id'] ?>" type="hidden">
                <input name="is_admin" value="<?php echo $users['is_admin'] ?>" type="hidden">
                <tr>
                    <td>
                        <p> <?php echo $users['id'] ?> </p>
                    </td>
                    <td>
                        <p> <?php echo $users['username'] ?> </p>
                    </td>
                    <td>
                        <p> <?php echo $users['is_admin'] ?> </p>
                    </td>
                    <td>
                        <p> <?php echo $users['created_at'] ?> </p>
                    </td>
                    <td>
                        <button type="submit" value="Update User" class="btn btn-success"> Update / Remove User</button>
                    </td>
                </tr>
            </form>
        <?php endforeach; ?>
    </table>
</div>

<div class="card card-body bg light mt-5">
    <table>
        <h2> BLOGS </h2>
        <div class="button">
            <a href="/blog/addBlog" class="btn btn-success"> Add Blog Post </a>
        </div>
        <div class="search">
            <form method="post" action="/admin/editBlog">
            <input type="text"  name="id" placeholder="search by post id" style="margin-top: 10px" >
<!--                how to access data here so postID submit direct to same location as updateBlog button -->
                <button type="submit" class="btn btn-primary"> Search </button>
            </form>
        </div>

        <tr>
            <th>PostId</th>
            <th>Title</th>
            <th>Blogger</th>
            <th>Blog Body</th>
            <th>Created At</th>
            <th>Update Blog</th>
            <th>Remove Blog</th>
        </tr>
        <?php foreach ($allPosts as $posts) : ?>
            <tr>
                <td>
                    <p> <?php echo $posts["postId"] ?></p>
                </td>
                <td>
                    <p> <?php echo $posts["title"] ?></p>
                </td>
                <td>
                    <p> <?php echo $posts["username"] ?></p>
                </td>
                <td>
                    <p> <?php echo $posts["blog_body"] ?></p>
                </td>
                <td>
                    <p> <?php echo $posts["created_at"] ?></p>
                </td>
                <td>
                    <form action="/blog/updatePost?<?=$posts['postId'];?>" method="post">
                        <input type="hidden" name="post_id" value="<?= $posts['postId']; ?> ">
                        <input type="submit" value="Update" class="btn btn-success">
                    </form>
                </td>

                <td>
                    <form action="/admin/deleteBlog" method="post">
                        <input type="hidden" name="post_id" value="<?= $posts['postId']; ?> ">
                        <input type="submit" value="Delete" class="btn btn-danger">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
