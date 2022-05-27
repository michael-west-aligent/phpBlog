
<?php require_once VIEW_PATH . '/header.php'; ?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg light mt-5">
        <h2> Make An Account</h2>
            <p> To start bloggin, please complete this form </p>
            <form action="/users/register" method="post">
                <div class="form-group">
                    <label for="name"> Name: <sup>*</sup></label>
                    <input type="text" name="name" class="form-control form-control-lg" <?php echo (!empty($this->params
                        ['name_err']) && ($this->params['name_err'] != '')) ? 'is-invalid' : ''; ?> value="<?php echo !empty($this->params['name']) ? $this->params['name'] : ''; ?>">
                    <span class="invalid-feedback"> <?php echo $this->params['name_err']; ?> </span>
                </div>

                <div class="form-group">
                    <label for="email"> Email: <sup>*</sup></label>
                    <input type="email" name="email" class="form-control form-control-lg" <?php echo (!empty($this->params
                        ['emial_err']) && ($this->params['email_err'] != '')) ? 'is-invalid' : ''; ?> value="<?php echo !empty($this->params['email']) ? $this->params['email'] : ''; ?>">
                    <span class="invalid-feedback"> <?php echo $this->params['email_err']; ?> </span>
                </div>

                <div class="form-group">
                    <label for="password"> Password: <sup>*</sup></label>
                    <input type="password" name="password" class="form-control form-control-lg" <?php echo (!empty($this->params
                        ['password_err']) && ($this->params['password_err'] != '')) ? 'is-invalid' : ''; ?> value="<?php echo !empty($this->params['password']) ? $this->params['password'] : ''; ?>">
                    <span class="invalid-feedback"> <?php echo $this->params['password_err']; ?> </span>
                </div>

                <div class="form-group">
                    <label for="confirm_password"> Confirm Password: <sup>*</sup></label>
                    <input type="password" name="confirm_password" class="form-control form-control-lg" <?php echo (!empty($this->params
                        ['confirm_password_err']) && ($this->params['confirm_password_err'] != '')) ? 'is-invalid' : ''; ?> value="<?php echo !empty($this->params['confirm_password']) ? $this->params['confirm_password'] : ''; ?>">
                    <span class="invalid-feedback"> <?php echo $this->params['confirm_password_err']; ?> </span>
                </div>

                <!--<div class="form-group">-->
<!--                    <label for="email"> Email: <sup>*</sup></label>-->
<!--                    <input type="email" name="email" class="form-control form-control-lg --><?php //echo (!empty($data
//                    ['email'])) ? 'is-invalid' : ''; ?><!--" value="--><?php //echo $data['email']; ?><!--">-->
<!--                    <span class="invalid-feedback"> --><?php //echo $data['email_err']; ?><!-- </span>-->
<!--                </div>-->

                <div class="row">
                    <div class="col">
                    <input type="submit" value="Register" class="btn btn-success btn-block"/>
                    </div>

                    <div class="col">
                    <a href="<?php VIEW_PATH . '/index.php';?>
                    /users/login" class="btn btn-light btn-block"> Already a blogger? Login instead.</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


<?php require_once VIEW_PATH . '/footer.php';?>


