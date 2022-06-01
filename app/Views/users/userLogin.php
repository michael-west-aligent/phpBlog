
<?php

require_once VIEW_PATH . '/header.php';

?>

<?php require_once VIEW_PATH . '/header.php'; ?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg light mt-5">
            <h2> Login </h2>
            <p> Enter username and password </p>
            <form action="/users/userLogin" method="post">
                <div class="form-group">
                    <label for="email"> Email: <sup>*</sup></label>
                    <input type="email" name="email" class="form-control form-control-lg" <?php echo (!empty($this->params
                        ['email_err']) && ($this->params['email_err'] != '')) ? 'is-invalid' : ''; ?> value="<?php echo !empty($this->params['email']) ? $this->params['email'] : ''; ?>">
                    <span style="color: darkred"> <?php echo $this->params['email_err']; ?> </span>
                </div>

                <div class="form-group">
                    <label for="password"> Password: <sup>*</sup></label>
                    <input type="password" name="password" class="form-control form-control-lg" <?php echo (!empty($this->params
                        ['password_err']) && ($this->params['password_err'] != '')) ? 'is-invalid' : ''; ?> value="<?php echo !empty($this->params['password']) ? $this->params['password'] : ''; ?>">
                    <span style="color: darkred"> <?php echo $this->params['password_err']; ?> </span>
                </div>

                <div class="row">
                    <div class="col">
                        <input type="submit" value="Login" class="btn btn-success btn-block"/>
                    </div>
                    <div class="col">
                        <a href="/users/register" class="btn btn-light btn-block"> Not registered? Register to login .</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


<?php require_once VIEW_PATH . '/footer.php';?>

<?php
require_once VIEW_PATH . '/footer.php';
?>


