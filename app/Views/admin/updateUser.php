<?php
require_once VIEW_PATH . '/header.php';
?>

<a href="/admin/home" class="btn btn-light"> Back to Admin Home </a>

<div class="card card-body bg light mt-5">
    <h2> Update Details of User <?php echo $this->params['username'] ?> </h2>
    <p> Update admin for user</p>
    <form method="post" action="/admin/updateUser">
        <div class="form-group">
            <label for="is_admin"> Is Admin: <sup>Tick box to make admin </sup></label>
            <?php if ($this->params['is_admin'] == 0): ?>
                <input type="checkbox" name="is_admin" class="form-control form-control-lg" value="0">
            <?php else: ?>
                <input type="checkbox" name="is_admin" class="form-control form-control-lg" value="<?php echo 1 ?>"
                       checked>
            <?php endif ?>
        </div>

        <input type="hidden" name="user_id" value="<?php echo $this->params['user_id'] ?>">
        <input type="submit" class="btn btn-success" value="Submit"/>
    </form>

    <div class="form-group">
        <label for="user_id"> Remove User <sup></sup></label>
<!--        <form action="/admin/delete?--><?php //echo $this->params['user_id'] ?><!--" method="post">-->
        <form action="delete?<?php echo $this->params['user_id'] ?>" method="post">
            <input type="submit" name="user_id" class="btn btn-danger" value="Delete User ">
        </form>
    </div>


</div>




