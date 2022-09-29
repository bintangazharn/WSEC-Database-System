<?php
    session_start();

    include_once './connection.php';
    /**
     * @var $connection
     * @var $pdo
     */

    if(isset($_POST['submitSignup'])){
        $username = strtolower($_POST['usernameSignup']);
        $password = password_hash($_POST['passwordSignup'], PASSWORD_DEFAULT);
        $email = strtolower($_POST['emailSignup']);
        $name = ucwords(strtolower($_POST['nameSignup']));
        $role = $_POST['roleSignup'];

        $db_userCheck = sprintf("SELECT * FROM `user` WHERE `username` = '%s'", $username);
        $result = $connection -> query($db_userCheck);

        if ($result -> num_rows > 0) {
            if($row = $result -> fetch_assoc()) {
                if ($row['username'] == $username) {
                    echo "<script>
                            window.alert('Username Already Taken!');
                        </script>";
                }
            }
        }
        else {
            $stmt = $pdo ->prepare ("INSERT INTO `user` (username, password, role) VALUES (?, ?, ?)");
            if ($stmt -> execute([$username, $password, '1']) === TRUE) {
                echo "<script>
                            window.alert('Account successfully created, please wait to be approved on your email!');
                        </script>";
                header ('Location: ./index.php');
            }
            else {
                echo "<script>
                            window.alert('Unexpected error suffered, please wait later or call the administrator');
                        </script>". $connection ->error;
            }
        }
    }

    $rand = '91034931';

    if(isset($_GET['9YwZU4LbpedSEuA'])){
        $idReal = explode($rand, $_GET['9YwZU4LbpedSEuA']);
        if(@$idReal[1] == 'qy6YeuNMMfR56Y4'){
            echo '
                <form method="post">
                    <input type="hidden" name="submitSignup" value="1"/>
                
                    <label for="inputUsername" class="form-label">Username</label>
                    <input type="text" name="usernameSignup" class="form-control" id="inputUsername" placeholder="Username" aria-label="Username" pattern="^\S+$" required>
                
                    <input type="password" name="passwordSignup" class="form-control" id="inputPassword" placeholder="Password" aria-label="Password" required>
                    <button type="submit" class="btn btn-primary">Signup</button>
                
                </form>
            ';
        }
        else {
            echo '<h1 style="text-align: center">404 Not Found</h1>';
        }
    }
    elseif(!isset($_GET['9YwZU4LbpedSEuA'])) {
        echo '<h1 style="text-align: center">404 Not Found</h1>';
    }
?>