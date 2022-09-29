<?php
    /**
     * @var $connClass
     */
    include_once './connectionClass.php';
    $connClass = new connectionClass();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="icon" type="image/x-icon" href="./assets/img/assets/vector.svg">
        <title>Details: Dashboard Alumni WSEC</title>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

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
        <?php include "./menu.php" ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9 col-sm-12 left_container">
                    <?php
                        if(isset($_GET['id'])){
                            $connClass->opQuery(
                                "UPDATE alumni SET view = view + 1 WHERE id_alumni = ?",
                                [$_GET['id']],
                                "0#0"
                            );

                            @$alumniResult = $connClass->runQuery(
                                'SELECT * FROM alumni WHERE id_alumni = ?',
                                [$_GET['id']],
                                'if'
                            );

                            if(is_array($alumniResult) == 1){
                                foreach ($alumniResult as $alumniRow){
                                    $alumniId = $alumniRow['id_alumni'];
                                    $alumniName = $alumniRow['name'];
                                    $alumniAlias = $alumniRow['alias'];
                                    $alumniYear = $alumniRow['year_in'];
                                    $alumniDinasty = $alumniYear-1995;
                                    $alumniProdi = $alumniRow['prodi'];
                                    $alumniCompany = $alumniRow['company'];
                                    $alumniPhone = $alumniRow['phone'];
                                    $alumniEmail = $alumniRow['email'];
                                    $alumniBio = $alumniRow['bio'];
                                    $alumniView = $alumniRow['view'];

                                    if(isset($alumniRow['picture'])){
                                        if($alumniRow['picture']!='no') {
                                            $alumniPicture = './assets/img/public/avatar/'.$alumniRow['picture'];
                                        }
                                        else {
                                            $alumniPicture = './assets/img/assets/avatar.png';
                                        }
                                    }
                                    else {
                                        $alumniPicture = './assets/img/assets/avatar.png';
                                    }

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

                                            if(in_array($avatarExtension, $avatarAllowedExtension)){
                                                if(move_uploaded_file($avatarTemp, $avatarNewUrl)){
                                                    return true;
                                                }
                                            }
                                        }
                                        else {
                                            $avatarDbUrl = $alumniRow['picture'];
                                        }

                                        if($connClass->opQuery(
                                            "UPDATE alumni SET name = ?,  alias = ?, year_in = ?, picture = ?, prodi = ?, company = ?, phone = ?, email = ?, bio = ? WHERE id_alumni = ?",
                                            [$name, $alias, $year_in, $avatarDbUrl, $prodi, $company, $phone, $email, $bio, $alumniId],
                                            "0#0"
                                        )
                                        == true){
                                            echo '
                                                <div class="card notifier_top bg_green">
                                                    <div class="card-body">
                                                        Editing alumni "'. $name .'" success, refresh page to see the differences!
                                                    </div>
                                                </div>
                                            ';
                                        }
                                        else {
                                            echo '
                                                <div class="card notifier_top bg_red">
                                                    <div class="card-body">
                                                        Editing alumni "'. $name .'" failed, please contact developer!
                                                    </div>
                                                </div>
                                            ';
                                        }
                                    }

                                    echo '
                                        <div class="row align-items-center">
                                            <div class="col-md-9 col-sm-12">
                                                <div class="title_header">
                                                    <span><i class="ri-account-circle-line"></i> Profile: '.$alumniName.'</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="icon_vertical_center text-disabled mini_text left_align_forced" style="text-align: right">
                                                    <span><i class="ri-eye-line"></i> '.$alumniView.'</span>&nbsp;&nbsp;
                                                    <span><i class="ri-printer-line"></i> <a onclick="window.print()" style="cursor: pointer">Print</a></span>
                                                </div> 
                                            </div>
                                        </div>
                    
                                        <div class="row details_wrapper">
                                            <div class="col-md-3 col-sm-12">
                                                <img src="'.$alumniPicture.'"/>
                                            </div>
                                            <div class="col-md-9 col-sm-12">
                                                <ul class="list-group list_profile">
                                                    <li class="list-group-item">Nama: '.$alumniName.'</li>
                                                    <li class="list-group-item">Dinasty '.$alumniDinasty.' ('.$alumniYear.')</li>
                                                    <li class="list-group-item">Prodi: '.$alumniProdi.'</li>
                                                    <li class="list-group-item">Telepon: '.$alumniPhone.'</li>
                                                    <li class="list-group-item">Email: '.$alumniEmail.'</li>
                                                    <li class="list-group-item">Perusahaan: '.$alumniCompany.'</li>
                                                </ul>
                                            </div>
                    
                                            <div class="list_bio">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <div class="profile_title">Bio</div>
                                                        '.$alumniBio.'
                                                    </li>
                                                </ul>
                                            </div>    
                                        </div> 
                                    ';

                                    if(isset($_SESSION['id_user'])){
                                        echo '
                                            <div class="edit_bar">
                                                <button type="button" class="btn btn-primary icon_vertical_center mini_text" data-bs-toggle="modal" data-bs-target="#editModal">
                                                    <span><i class="ri-edit-2-line"></i> Edit alumni</span>
                                                </button>
                                                <a href="./deletealumni.php?id='.$alumniId.'" class="btn btn-danger icon_vertical_center mini_text">
                                                    <span><i class="ri-delete-bin-2-line"></i> Delete Alumni</span>
                                                </a>
                                            </div>
                                            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="title_header modal-title" id="editModalLabel" style="margin-bottom: -0.75em!important;">
                                                                <span><i class="ri-edit-2-line"></i> Edit: '.$alumniName.'</span>
                                                            </div>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="row g-3" method="post" enctype="multipart/form-data">
                                                                <div class="mb-3">
                                                                    <div class="row g-2">
                                                                        <div class="col">
                                                                            <label class="form-label">Nama Lengkap</label>
                                                                            <input type="text" class="form-control" id="name" name="name" value="'.$alumniName.'">
                                                                        </div>
                                                                        <div class="col">
                                                                            <label class="form-label">Alias/Panggilan</label>
                                                                            <input type="text" class="form-control" id="alias" name="alias" value="'.$alumniAlias.'">
                                                                        </div>
                                                                    </div>
                                    
                                                                    <br/>
                                    
                                                                    <div class="row g-2">
                                                                        <div class="col">
                                                                            <label class="form-label">Tahun Masuk WSEC</label>
                                                                            <input type="number" min="1995" max="2099" step="1" class="form-control" id="year" name="year" placeholder="ex: 2005" value="'.$alumniYear.'">
                                                                        </div>
                                                                        <div class="col">
                                                                            <label class="form-label">Prodi saat di WSEC</label>
                                                                            <input type="text" class="form-control" id="prodi" name="prodi" placeholder="ex: D4 Teknik Elektronika" value="'.$alumniProdi.'">
                                                                        </div>
                                                                    </div>
                                    
                                                                    <br/>
                                    
                                                                    <label class="form-label">Foto Profil</label>
                                                                    <input class="form-control" type="file" id="avatar" name="avatar">
                                    
                                                                    <br/>
                                    
                                                                    <label class="form-label">Perusahaan tempat bekerja</label>
                                                                    <input type="text" class="form-control" id="company" name="company" value="'.$alumniCompany.'">
                                    
                                                                    <br/>
                                    
                                                                    <div class="row g-2">
                                                                        <div class="col">
                                                                            <label class="form-label">Nomor Telepon</label>
                                                                            <input type="phone" class="form-control" id="phone" name="phone" value="'.$alumniPhone.'">
                                                                        </div>
                                                                        <div class="col">
                                                                            <label class="form-label">Email</label>
                                                                            <input type="email" class="form-control" id="email" name="email" value="'.$alumniEmail.'">
                                                                        </div>
                                                                    </div>
                                    
                                                                    <br/>
                                    
                                                                    <label class="form-label">Biografi</label>
                                                                    <textarea class="form-control" name="bio" id="summernote">'.$alumniBio.'</textarea>
                                                                </div>
                                    
                                                                <div class="col-12">
                                                                    <button type="submit" class="btn btn-primary w-100">Edit Alumni</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        ';
                                    }
                                }
                            }
                            elseif(isset($_SESSION['occurrence'])){
                                if($_SESSION['occurrence'] = 'delete'){
                                    echo '
                                        <div class="card notifier_top bg_green">
                                            <div class="card-body">
                                                Alumni has successfully deleted!
                                            </div>
                                        </div>
                                    ';
                                    $_SESSION['occurrence'] = NULL;
                                }
                            }
                            else {
                                echo '
                                    <div class="card notifier_top bg_red">
                                        <div class="card-body">
                                            Alumni not found, please use our search database!
                                        </div>
                                    </div>
                                ';
                            }
                        }
                        elseif(isset($_SESSION['occurrence'])){
                            if($_SESSION['occurrence'] = 'delete'){
                                echo '
                                    <div class="card notifier_top bg_green">
                                        <div class="card-body">
                                            Alumni has successfully deleted!
                                        </div>
                                    </div>
                                ';
                                $_SESSION['occurrence'] = NULL;
                            }
                        }
                        else {
                            echo '
                                <div class="card notifier_top bg_red">
                                    <div class="card-body">
                                        Alumni not found, please use our search database!
                                    </div>
                                </div>
                            ';
                        }
                    ?>
                </div>
                <div class="col-md-3 col-sm-12 right_container">
                    <?php include "./sidebar.php" ?>

                    <br/>

                    <div class="sidebar_header">
                        <span><i class="ri-question-line"></i> Quick Help</span>
                    </div>

                    <div class="card">
                        <div class="card-body mini_text" style="line-height: 1.65em">
                            Want to add your own bio or editing your own profile (edit company, name, phone, email, etc)? Contact us via our Humas<br/>
                            <a href="//wa.me/<?php echo $humasJsonDecode['humasPhone']  ?>" class="btn btn-success button_login"><span><i class="ri-whatsapp-line"></i> <?php echo $humasJsonDecode['humasName']  ?></span></a>
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
