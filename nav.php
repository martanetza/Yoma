<header>
    <div class="logo-container">
        <img src="img/yoma_logo.png" alt="" />
    </div>

    <nav>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <img class="menu" src="img/menu.svg" alt="" />
        </a>
        <?php
        // require_once('has_access.php');
        if (!isset($_SESSION['user_id'])) :
        ?>


            <ul class="desktop-nav">
                <li>
                    <a href="index.php">Courses</a>
                </li>
                <li>
                    <a href="">About</a>
                </li>
                <li>
                    <a href="login.php">Login</a>
                </li>
            </ul>
        <?php else : ?>
            <ul class="desktop-nav">
                <li>
                    <a href="index.php">Courses</a>
                </li>
                <li>
                    <a href="">About</a>
                </li>
                <li>
                    <a href="user_profile.php">Your profile</a>
                </li>
                <li>
                    <a href="logout.php">Log out</a>
                </li>
            </ul>

        <?php
        endif;
        ?>
    </nav>

    <div id="menuLinks">
        <?php if (!isset($_SESSION['user_id'])) : ?>

            <ul>
                <li>
                    <a href="index.php">Courses</a>
                </li>
                <li>
                    <a href="">About</a>
                </li>
                <li>
                    <a href="login.php">Login</a>
                </li>
            </ul>
        <?php else : ?>
            <ul>
                <li>
                    <a href="index.php">Courses</a>
                </li>
                <li>
                    <a href="">About</a>
                </li>
                <li>
                    <a href="user_profile.php">Your profile</a>
                </li>
                <li>
                    <a href="logout.php">Log out</a>
                </li>
            </ul>
        <?php endif; ?>
    </div>
</header>
<script src="script.js"></script>