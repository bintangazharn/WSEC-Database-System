<?php
    /*
         * ROLE
         * 0 = SUPER/FOUNDER
         * 1 = WEB DEV
         * 2 = UI UX DESIGNER
         * 3 = MARKETING
         * 4 = PROJECT MANAGER
         */

    session_start();

    include_once './connection.php';
    /**
     * @var $connection
     * @var $pdo
     */

    $humasJsonRead = file_get_contents('./assets/json/config_humas.json');
    $humasJsonDecode = json_decode($humasJsonRead, true);

    if(isset($_POST['searchBox'])){
        header("Location: ./search.php?s=".$_POST['searchBox']);
    }

    if(isset($_POST['username'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if($connection -> connect_errno) {
            echo 'connection error: '. $connection -> connect_errno;
        }

        //using easy method but vulnerable to sql injection
        //$checkUsername = sprintf("SELECT * FROM `account` WHERE `username` = '%s'", $username);
        //$result = $connection -> query($checkUsername);

        //using parametered queries avoid sql injection
        $checkUsername = $connection -> prepare("SELECT * FROM `user` WHERE `username` = ?");
        $checkUsername -> bind_param('s', $username);
        $checkUsername -> execute();
        $result = $checkUsername -> get_result();
        if((int)$result -> num_rows > 0) {
            if($row = $result -> fetch_assoc()) {
                $dbPassword = $row['password'];

                if(password_verify($password, $dbPassword) > 0) {
                    $id_user = $row['id_user'];
                    $username = $row['username'];
                    $password = $row['password'];
                    $role = $row['role'];

                    $_SESSION['id_user'] = $id_user;
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    $_SESSION['role'] = $role;
                    $_SESSION['occurrence'] = 'success';
                }
                else {
                    $_SESSION['id_user'] = NULL;
                    $_SESSION['username'] = NULL;
                    $_SESSION['password'] = NULL;
                    $_SESSION['role'] = NULL;
                    $_SESSION['occurrence'] = 'failed';
                }
            }
        }
        else {
            $_SESSION['occurrence'] = 'failed';
        }
    }
?>

<nav class="nav sticky-top nav_menu_top">
    <a class="nav-link active" data-bs-toggle="offcanvas" href="#offcanvasMenu" role="button" aria-controls="offcanvasMenu">
        <i class="ri-menu-2-fill"></i>
    </a>
    <a class="nav-link active" aria-current="page" href="./">Workshop Electro: Alumni Database System</a>
</nav>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
    <div class="offcanvas-header">
        <div class="offcanvas-title" id="offcanvasMenuLabel">
            <img height="100px" src="assets/img/assets/logo.png"/>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body menu_wrapper">
        <?php
         if (!isset($_SESSION['id_user'])){
             echo '
                <form class="row g-3" method="post">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username"><br/>
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"><br/>
                        <button type="submit" class="btn btn-primary mb-3 button_login w-100"><span><i class="ri-login-box-line"></i> Login</span></button>
                    </div>
                </form>
             ';
         }
         else {
             echo '
                Halo '.$_SESSION['username'].'!<br/><br/>
                <a href="./admin.php" class="btn btn-primary mb-3 button_login w-100"><span><i class="ri-settings-3-line"></i> Admin</span></a>
                <a href="./logout.php" class="btn btn-primary mb-3 button_login w-100"><span><i class="ri-logout-box-line"></i> Logout</span></a>
             ';
         }
        ?>

        <div class="mini_text credit_text link_stylized">
            &copy; 2022 Workshop Electro Politeknik Negeri Malang. <br/>Developed by <a href="https://www.linkedin.com/in/bintangazharn">Bintang Azhar Nafis</a> Dinasty 25.
        </div>

        <div class="mini_text link_stylized">
            <a href="./changelog.php">Version 1.1.1 Changelog</a>
        </div>
    </div>
</div>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>