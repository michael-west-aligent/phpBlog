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
        <h2> USERS
            <div class="button">
                <a href="/admin/addUser" class="btn btn-success"> Add a New User </a>
            </div>
        </h2>
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
        <tr>
            <th>Title</th>
            <th>Blogged By</th>
            <th>Blog Body</th>
            <th>PostId</th>
            <th>Update Blog</th>
            <th>Remove Blog</th>
        </tr>
        <?php foreach ($allPosts as $posts) : ?>
            <tr>
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
                    <p> <?php echo $posts["postId"] ?></p>
                </td>
                <td>
                    <a href="/admin/editBlog?<?php echo $posts['postId'] ?>">
                        <button type="submit" value="Update User" class="btn btn-success"> Update Blog</button>
                    </a>
                </td>
                <td>
                    <form action="/admin/deleteBlog" method="post">
                        <input type="hidden" name="postId" value="<?= $posts['postId']; ?> ">
                        <input type="submit" value="Delete Blog" class="btn btn-danger">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
