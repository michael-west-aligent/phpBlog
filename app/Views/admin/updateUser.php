<?php
require_once VIEW_PATH . '/header.php';
?>

<a href="/admin/home" class="btn btn-light"> Back to Admin Home </a>

<div class="card card-body bg light mt-5">
    <h2> Update User Details </h2>
    <p> Update  admin for user</p>
    <form method="post" action="/admin/updateUser">
<!--        <form action="/admin/home" method="post">-->

<?php //var_dump($_POST['id']) ?>
<!--        --><?php //var_dump($this->params['is_admin'])?>
<!--                --><?php //var_dump($this->params['id'])?>

        <div class="form-group">
            <label for="is_admin"> Is Admin: <sup>Tick box to make admin </sup></label>
<!--            <input type="hidden" name="is_admin" class="form-control form-control-lg"  value="0"/>-->
<!--            <input  type="checkbox"  name="is_admin"  class="form-control form-control-lg"  value="1">-->
            <?php if($this->params['is_admin'] == 0): ?>
            <input type="checkbox"  name="is_admin"  class="form-control form-control-lg"  value="0">
            <?php else: ?>
            <input type="checkbox"  name="is_admin"  class="form-control form-control-lg"  value="<?php echo 1?>" checked>
            <?php endif ?>
        </div>
        <input type="hidden" name="user_id" value="<?php echo$this->params['user_id']?>">
        <input type="submit" class="btn btn-success" value="Submit"/>
    </form>
</div>




