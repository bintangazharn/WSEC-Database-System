<?php
    /**
     * @var $connClass
     */
    include_once './connectionClass.php';
    $connClass = new connectionClass();

    session_start();

    $deleteID = $_GET['id'];

    if(isset($_SESSION['id_user'])){
        if($connClass->opQuery(
                "DELETE FROM alumni WHERE id_alumni = ?",
                [$deleteID],
                "0#0"
            )
            == true){
            echo '
                <script>
                 history.back()
                </script>
            ';
            $_SESSION['occurrence'] = 'delete';
        }
        else {
            header('location: ./');
        }
    }
    else {
        header('location: ./');
    }
?>