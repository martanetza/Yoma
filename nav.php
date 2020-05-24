<?php
// require_once('has_access.php');

if (!isset($_SESSION['user_id'])) :
?>

    <nav>
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
    </nav>

<?php
else :
?>
    <nav>
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
    </nav>
<?php
endif;
?>