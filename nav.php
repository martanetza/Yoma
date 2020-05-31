<header>
    <a href="index.php" class="logo-container">
        <img src="img/yoma_logo.png" alt="" />
    </a>

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
                    <a href="all_courses.php">Courses</a>
                </li>
                <li>
                    <a href="">About</a>
                </li>
                <li>
                    <a href="login.php">
                        <button class="login-btn">Login</button>
                    </a>
                </li>
                <li>
                    <a href="signup.php">
                        <button class="signup-btn">Signup</button>
                    </a>
                </li>
            </ul>
        <?php else : ?>
            <ul class="desktop-nav">
                <li>
                    <a href="all_courses.php">Courses</a>
                </li>
                <li>
                    <a href="">About</a>
                </li>
                <li>
                    <a href="user_profile.php">Your profile</a>
                </li>
                <li>
                    <a href="logout.php">
                        <button class="signup-btn">Log out</button>
                    </a>
                </li>
            </ul>

        <?php
        endif;
        ?>
    </nav>

    <div id="menuLinks">

        <img onclick="xFunction()" class="x" src="img/close.svg" alt="" />
        <?php if (!isset($_SESSION['user_id'])) : ?>

            <ul>
                <li>
                    <a href="all_courses.php">Courses</a>
                </li>
                <li>
                    <a href="">About</a>
                </li>
                <li>
                    <a href="login.php">
                        <button class="login-btn">Login</button>
                    </a>
                </li>
                <li>
                    <a href="signup.php">
                        <button class="signup-btn">Signup</button>
                    </a>
                </li>
            </ul>
        <?php else : ?>
            <ul>
                <li>
                    <a href="all_courses.php">Courses</a>
                </li>
                <li>
                    <a href="">About</a>
                </li>
                <li>
                    <a href="user_profile.php">Your profile</a>
                </li>
                <li>
                    <a href="logout.php">
                        <button class="signup-btn">Log out</button>
                    </a>
                </li>
            </ul>
        <?php endif; ?>

    </div>
</header>
<script src="script.js"></script>