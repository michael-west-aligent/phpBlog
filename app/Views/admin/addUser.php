<?php require_once VIEW_PATH . '/header.php'; ?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg light mt-5">
            <h2> Hello Admin, make an account! </h2>
            <p> Create a new user </p>
<!--            <form action="/admin/home" method="post">-->
                <form method="post">
                <div class="form-group">
                    <label for="name"> Name: <sup>*</sup></label>
                    <input type="text" name="name" class="form-control form-control-lg" <?php echo (!empty($this->params
                        ['name_err']) && ($this->params['name_err'] != '')) ? 'is-invalid' : ''; ?> value="<?php echo !empty($this->params['name']) ? $this->params['name'] : ''; ?>">
                    <span style="color: darkred"> <?php echo $this->params['name_err']; ?> </span>
                </div>

                <div class="form-group">
                    <label for="email"> Email: <sup>*</sup></label>
                    <input type="email" name="email" class="form-control form-control-lg" <?php echo (!empty($this->params
                    ['email_err'])) ? 'is-invalid' : ''; ?> value="<?php echo !empty($this->params['email']) ? $this->params['email'] : ''; ?>">
                    <span style="color: darkred"> <?php echo $this->params['email_err']; ?>  </span>
                </div>

                <div class="form-group">
                    <label for="password"> Password: <sup>*</sup></label>
                    <input type="password" name="password" class="form-control form-control-lg" <?php echo (!empty($this->params
                        ['password_err']) && ($this->params['password_err'] != '')) ? 'is-invalid' : ''; ?> value="<?php echo !empty($this->params['password']) ? $this->params['password'] : ''; ?>">
                    <span style="color: darkred"><?php echo $this->params['password_err']; ?> </span>
                </div>

                <div class="form-group">
                    <label for="confirm_password"> Confirm Password: <sup>*</sup></label>
                    <input type="password" name="confirm_password" class="form-control form-control-lg" <?php echo (!empty($this->params
                        ['confirm_password_err']) && ($this->params['confirm_password_err'] != '')) ? 'is-invalid' : ''; ?> value="<?php echo !empty($this->params['confirm_password']) ? $this->params['confirm_password'] : ''; ?>">
                    <span style="color: darkred"> <?php echo $this->params['confirm_password_err']; ?> </span>
                </div>

<!--                <div class="form-group">-->
<!--                    <label for="is_admin"> Is Admin: <sup>0=No Admin, 1 = Admin</sup></label>-->
<!--                    <input type="text" name="is_admin" class="form-control form-control-lg"  value="--><?php //echo !empty($this->params['is_admin']) ? $this->params['is_admin'] : ''; ?><!--">-->
<!--                </div>-->

<!--                    <div class="form-group">-->
<!--                        <label for="is_admin"> Is Admin: <sup>Tick box to make admin </sup></label>-->
<!--                        <input type="checkbox" name="is_admin" class="form-control form-control-lg"  value="--><?php //echo !empty($this->params['is_admin'] == 1) ? $this->params['is_admin'] : ''; ?><!--">-->
<!--                    </div>-->

                    <div class="form-group">
                        <label for="is_admin"> Is Admin: <sup>Tick box to make admin </sup></label>
                        <input type="hidden" name="is_admin" class="form-control form-control-lg"  value="0"/>
                        <input type="checkbox" name="is_admin" class="form-control form-control-lg"  value="1">
                    </div>


                <div class="row">
                    <div class="col">
                        <input type="submit" value="Register" class="btn btn-success btn-block"/>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


<?php require_once VIEW_PATH . '/footer.php';?>

