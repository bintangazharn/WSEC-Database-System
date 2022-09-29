<?php
session_start();

include_once './connection.php';
/**
 * @var $connection
 * @var $pdo
 */

/*
 * Role:
 *  Student = 1
 *  Teacher = 2
 *  Homeroom Teacher = 3
 *  Curriculum = 4
 *  Headmaster = 5
 *  Dev Mode = 0
 */

echo '
<form method="post">
    <label>Username</label>
    <input type="text" name="usernameSecure" placeholder="kmelked" required>
    <input type="password" name="passwordSecure" placeholder="kenfknew" required>
    <button type="submit" class="btn btn-primary">kefnewj</button>
</form>
';

if(isset($_POST['usernameSecure'])){
    if($_POST['usernameSecure'] == "akmj69"){
        if($_POST['passwordSecure']== "oioioi"){
            header("location: ./7C789e8V22YQt7PHrMXvyW4cWpU82q.php?9YwZU4LbpedSEuA=".rand(0,99999)."91034931"."qy6YeuNMMfR56Y4"."91034931".rand(0,99999));
        }
    }
}
?>
