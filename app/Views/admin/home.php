<?php
require_once VIEW_PATH . '/header.php';
?>

<a href="/blogPosts" class="btn btn-light"> Back to All Blogs </a>

<div class="card card-body bg light mt-5">
<table>
    <h2> USERS </h2>
    <td>   <input href="/admin/addUser" type="submit" class="btn btn-success" value="Add A New User"/> </td>

    <tr>
        <th>id</th>
        <th>username</th>
        <th>pasword</th>
        <th>is_admin</th>
        <th>created_at</th>
    </tr>
    <tr>
        <td>DUMMY ID </td>

        <td>DUMMY  john.doe@example.com</td>
        <td>DUMMY password </td>
        <td>DUMMY is_admin</td>
        <td>DUMMY created_at</td>
        <td>   <input type="submit" class="btn btn-danger" value="Remove User"/> </td>
        <td>   <input type="submit" class="btn btn-blue" value="Update User "/> </td>

<?php
var_dump($this->params['users']);
?>

    </tr>

</table>

</div>