<?php
require_once VIEW_PATH . '/header.php';
?>

<a href="/blogPosts" class="btn btn-light"> Back to All Blogs </a>

<div class="card card-body bg light mt-5">
    <table>
        <h2> USERS   <input href="/admin/addUser" type="submit" class="btn btn-success" value="Add A New User"/> </h2>
                <td>
<!--                    <input href="/admin/addUser" type="submit" class="btn btn-success" value="Add A New User"/>-->
                </td>
        <tr>
            <th>id</th>
            <th>username</th>
            <th>pasword</th>
            <th>is_admin</th>
            <th>created_at</th>
            <th>Remove User</th>
            <th>Update User</th>
        </tr>
        <?php foreach ($this->params['users'] as $users) : ?>
            <tr>
                <td>
                    <p> <?php echo $users['id'] ?> </p>
                </td>
                <td>
                    <p> <?php echo $users['username'] ?> </p>
                </td>
                <td>
                    <p> <?php echo $users['password'] ?> </p>
                </td>
                <td>
                    <p> <?php echo $users['is_admin'] ?> </p>
                </td>
                <td>
                    <p> <?php echo $users['created_at'] ?> </p>
                </td>
                <td>
                    <button type="submit" value="Remove User"> Remove User</button>
                </td>
                <td>
                    <button type="submit" value="Update User "> Update User</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>