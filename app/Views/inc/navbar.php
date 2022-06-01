<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <div class="container">
    <a class="navbar-brand" href="/">PhpBlog </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/">Home</a>
            </li>
        </ul>



<!--                THIS IS THE ORIGINAL CODE-->
<!--        --><?php //if($_SESSION['user_id'] = null) : ?>
<!--            --><?php //echo $_SESSION['user_id'] ?>
<!--            <ul class="navbar-nav ml-auto">-->
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link" href="/users/register">Register</a>-->
<!--                </li>-->
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link" href="/users/login">Login</a>-->
<!--                </li>-->
<!--            </ul>-->
<!--        --><?php //else :  ?>
<!--            <li class="nav-item">-->
<!--                <a class="nav-link" href="/users/login">Logout</a>-->
<!--            </li>-->
<!--        --><?php //endif ?>



        <?php if(empty($_SESSION['user_id'] )) : ?>
<!--            --><?php //echo $_SESSION['user_id'] ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/users/register">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/users/login">Login</a>
                </li>
            </ul>
        <?php else : ?>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/users/logout">Logout</a>
            </li>
        </ul>
        <?php endif ?>


    </div>
    </div>
</nav>