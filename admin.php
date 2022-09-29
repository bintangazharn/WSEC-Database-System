<?php
    /**
     * @var $connection
     * @var $pdo
     */
    include_once './connection.php';
    include_once './connectionClass.php';
    $connClass = new connectionClass();
    include "./menu.php";

    if(!isset($_SESSION['id_user'])){
        header("location: ./index.php");
    }
    else {
        if($_SESSION['role'] != 1){
            echo '
            <style>
                .privilege_admin {display: none}
            </style>
        ';
        }
    }
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin | Dashboard Alumni WSEC</title>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

        <!-- styling start -->
        <link rel="stylesheet" href="assets/style/main.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <!-- styling end -->

        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    </head>
    <body>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9 col-sm-12 left_container">
                    <div>
                        <?php
                            if(isset($_POST['name'])) {
                                $name = $_POST['name'];
                                $alias = $_POST['alias'];
                                $year_in = $_POST['year'];
                                $prodi = $_POST['prodi'];
                                $company = $_POST['company'];
                                $phone = $_POST['phone'];
                                $email = $_POST['email'];
                                $bio = $_POST['bio'];

                                if(is_uploaded_file($_FILES['avatar']['name'])){
                                    $avatarExplode = explode(".", $_FILES['avatar']['name']);
                                    $avatarExtension = end($avatarExplode);
                                    $avatarDbUrl = $avatarExplode[0] . '-'. $name .'-' . rand() . '.' . end($avatarExplode);
                                    $avatarNewUrl = './assets/img/public/avatar/' . $avatarDbUrl;
                                    $avatarTemp = $_FILES['avatar']['tmp_name'];
                                    $avatarAllowedExtension = array('jpg', 'gif', 'png', 'svg');
                                    //chmod('postThumbnail', 0777);

                                    if(in_array($avatarExtension, $avatarAllowedExtension)){
                                        if(move_uploaded_file($avatarTemp, $avatarNewUrl)){
                                            return true;
                                        }
                                    }
                                }
                                else {
                                    $avatarDbUrl = 'no';
                                }

                                if($connClass->opQuery(
                                    "INSERT INTO alumni (name, alias, year_in, picture, prodi, company, phone, email, bio) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                                    [$name, $alias, $year_in, $avatarDbUrl, $prodi, $company, $phone, $email, $bio],
                                    "0#0"
                                )
                                == true){
                                    echo '
                                                <div class="card notifier_top bg_green">
                                                    <div class="card-body">
                                                        Adding alumni "'. $name .'" success!
                                                    </div>
                                                </div>
                                            ';
                                }
                                        else {
                                    echo '
                                                <div class="card notifier_top bg_red">
                                                    <div class="card-body">
                                                        Adding alumni "'. $name .'" failed, please contact developer!
                                                    </div>
                                                </div>
                                            ';
                                }

                                /*$newwidth = 500;
                                $newheight = 556;
                                $pic = new Imagick($avatarNewUrl);//specify name
                                $pic->resizeImage($newwidth,$newheight,Imagick::FILTER_LANCZOS,1);
                                unlink($avatarNewUrl);
                                $pic->writeImage($avatarNewUrl);
                                $pic->destroy();

                                echo 'ya';*/
                            }

                            if(isset($_POST['addusername'])) {
                                $addusername = $_POST['addusername'];
                                $addpassword = password_hash($_POST['addpassword'], PASSWORD_DEFAULT);
                                $addemail = $_POST['addemail'];

                                if(isset($_POST['addroleadmin'])){
                                    $readrole = $_POST['addroleadmin'];
                                    if($readrole == "on"){
                                        $addrole = 1;
                                    }
                                    else {
                                        $addrole = 0;
                                    }
                                }
                                else {
                                    $addrole = 0;
                                }

                                $db_userCheck = sprintf("SELECT * FROM `user` WHERE `username` = '%s'", $addusername);
                                $result = $connection -> query($db_userCheck);

                                if ($result -> num_rows > 0) {
                                    if($row = $result -> fetch_assoc()) {
                                        if ($row['username'] == $addusername) {
                                            echo "<script>
                                                        window.alert('Username Already Taken!');
                                                    </script>";
                                        }
                                    }
                                }
                                else {
                                    if($connClass->opQuery(
                                            "INSERT INTO user (username, password, role, email) VALUES (?, ?, ?, ?)",
                                            [$addusername, $addpassword, $addrole, $addemail],
                                            "0#0"
                                        )
                                        == true){
                                        echo '
                                            <div class="card notifier_top bg_green">
                                                <div class="card-body">
                                                    Adding user "'. $addusername .'" success!
                                                </div>
                                            </div>
                                        ';
                                    }
                                    else {
                                        echo '
                                            <div class="card notifier_top bg_red">
                                                <div class="card-body">
                                                    Adding user "'. $addusername .'" failed, please contact developer!
                                                </div>
                                            </div>
                                        ';
                                    }
                                }
                            }

                            if(isset($_POST['humasName'])){
                                $humasArray = Array(
                                    "humasName" => $_POST['humasName'],
                                    "humasPhone" => $_POST['humasPhone']
                                );
                                $jsonHumas = json_encode($humasArray);
                                if(file_put_contents('./assets/json/config_humas.json', $jsonHumas)){
                                    echo '
                                        <div class="card notifier_top bg_green">
                                            <div class="card-body">
                                                Editing humas profile is success!
                                            </div>
                                        </div>
                                    ';
                                }
                                else {
                                    echo '
                                        <div class="card notifier_top bg_red">
                                            <div class="card-body">
                                                Editing humas profile failed, please contact developer!
                                            </div>
                                        </div>
                                    ';
                                }
                            }
                        ?>


                        <div class="title_header">
                            <span><i class="ri-user-add-line"></i> Add Alumni</span>
                        </div>

                        <form class="row g-3" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <div class="row g-2">
                                    <div class="col">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="name" name="name">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Alias/Panggilan</label>
                                        <input type="text" class="form-control" id="alias" name="alias">
                                    </div>
                                </div>

                                <br/>

                                <div class="row g-2">
                                    <div class="col">
                                        <label class="form-label">Tahun Masuk WSEC</label>
                                        <input type="number" min="1995" max="2099" step="1" class="form-control" id="year" name="year" placeholder="ex: 2005">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Prodi saat di WSEC</label>
                                        <input type="text" class="form-control" id="prodi" name="prodi" placeholder="ex: D4 Teknik Elektronika">
                                    </div>
                                </div>

                                <br/>

                                <label class="form-label">Foto Profil</label>
                                <input class="form-control" type="file" id="avatar" name="avatar">

                                <br/>

                                <label class="form-label">Perusahaan tempat bekerja</label>
                                <input type="text" class="form-control" id="company" name="company">

                                <br/>

                                <div class="row g-2">
                                    <div class="col">
                                        <label class="form-label">Nomor Telepon</label>
                                        <input type="phone" class="form-control" id="phone" name="phone">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                </div>

                                <br/>

                                <label class="form-label">Biografi</label>
                                <textarea class="form-control" id="summernote" name="bio"></textarea>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100">Add Alumni</button>
                            </div>
                        </form>
                    </div>

                    <br/>

                    <div class="privilege_admin">
                        <div class="title_header">
                            <span><i class="ri-user-add-line"></i> Add User</span>
                        </div>

                        <form class="row g-3" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <div class="row g-2">
                                    <div class="col">
                                        <label class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="addusername">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="addpassword">
                                    </div>
                                </div>

                                <br/>

                                <div class="col">
                                    <label class="form-label">Email</label>
                                    <input class="form-control" type="email" id="email" name="addemail">
                                </div>

                                <br/>

                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="roleadmin" name="addroleadmin">
                                    <label class="form-check-label mini_text" for="roleadmin">Set as administrator <span class="text-danger">(can add other user or administrator and change configuration)</span></label>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100">Add User</button>
                            </div>
                        </form>
                    </div>

                    <br/>

                    <div class="privilege_admin">
                        <div class="title_header">
                            <span><i class="ri-settings-3-line"></i> Configuration</span>
                        </div>
                    </div>

                    <form class="row g-3" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <div class="row g-2 align-items-center">
                                <div class="col">
                                    <label class="form-label">Nama Humas</label>
                                    <input type="text" class="form-control" id="name" name="humasName">
                                </div>
                                <div class="col">
                                    <label class="form-label">WhatsApp Humas</label>
                                    <input type="phone" class="form-control" id="alias" name="humasPhone" placeholder="ex: +62xxx">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100">Edit Humas</button>
                        </div>
                    </form>
                    </div>
                <div class="col-md-3 col-sm-12 right_container">
                    <div class="sidebar_header">
                        <span><i class="ri-task-line"></i> Latest Alumni Added</span>
                    </div>

                    <div>
                        <ul class="list-group">
                            <?php
                            @$newResult = $connClass->runBaseQuery(
                                'SELECT * FROM alumni ORDER BY id_alumni DESC LIMIT 5',
                                'while'
                            );

                            if(is_array($newResult) == 1){
                                foreach ($newResult as $newRow){
                                    $newID = $newRow['id_alumni'];
                                    $newName = $newRow['name'];

                                    echo '
                                            <li class="list-group-item d-flex justify-content-between align-items-start link_stylized">
                                                <div class="ms-2 me-auto">
                                                    <a href="./details.php?id='.$newID.'">'.$newName.'</a>
                                                </div>
                                            </li>           
                                        ';
                                }
                            }
                            ?>
                        </ul>
                    </div>

                    <br/>

                    <div class="sidebar_header">
                        <span><i class="ri-customer-service-line"></i> Humas Profile</span>
                    </div>

                    <?php
                        $humasJsonRead = file_get_contents('./assets/json/config_humas.json');
                        $humasJsonDecode = json_decode($humasJsonRead, true)
                    ?>

                    <div class="card">
                        <div class="card-body mini_text">
                            Humas: <?php echo $humasJsonDecode['humasName']  ?><br/>
                            WhatsApp: <?php echo $humasJsonDecode['humasPhone']  ?><br/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#summernote').summernote({
                    toolbar: [
                        // [groupName, [list of button]]
                        ['style', ['bold', 'italic', 'underline']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['para', ['ul', 'ol']]
                    ]
                });
            });
        </script>
    </body>
</html>
