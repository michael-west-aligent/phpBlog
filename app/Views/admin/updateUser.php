<?php
require_once VIEW_PATH . '/header.php';
?>

<a href="/admin/home" class="btn btn-light"> Back to Admin Home </a>

<div class="card card-body bg light mt-5">
    <h2> Update User Details </h2>
    <p> Update  admin for user</p>
    <form method="post" action="/hello">
<!--        <form action="/admin/home" method="post">-->

<?php var_dump($_POST['id']) ?>
        <div class="form-group">
            <label for="is_admin"> Is Admin: <sup>Tick box to make admin </sup></label>
<!--            <input type="hidden" name="is_admin" class="form-control form-control-lg"  value="0"/>-->
            <input  type="checkbox"  name="is_admin"  class="form-control form-control-lg"  value="1">
        </div>
        </div>
    <input type="hidden" name="user_id" value="$_POST['id']">
        <input type="submit" class="btn btn-success" value="Submit"/>
    </form>
</div>



