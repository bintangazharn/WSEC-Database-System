<?php
    /**
     * @var $connClass
     */
    include_once './connectionClass.php';
    $connClass = new connectionClass();
    include "./menu.php";
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="icon" type="image/x-icon" href="./assets/img/assets/vector.svg">
        <title>Dashboard Alumni WSEC</title>

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

    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9 col-sm-12 left_container">

                    <?php
                        if(isset($_SESSION['occurrence'])){
                            if($_SESSION['occurrence'] == 'success'){
                                echo '
                                    <div class="card notifier_top bg_green">
                                        <div class="card-body">
                                            Login admin success :)
                                        </div>
                                    </div>
                                ';
                                $_SESSION['occurrence'] = NULL;
                            }
                            elseif($_SESSION['occurrence'] == 'failed'){
                                echo '
                                    <div class="card notifier_top bg_red">
                                        <div class="card-body">
                                            Check your username and password :(
                                        </div>
                                    </div>
                                ';
                                $_SESSION['occurrence'] = NULL;
                            }
                        }
                    ?>

                    <div class="title_header">
                        <span><i class="ri-search-2-line"></i> Search Alumni</span>
                    </div>

                    <div>
                        <?php
                            if(isset($_POST['searchBox'])){
                                header("Location: ./search.php?s=".$_POST['searchBox']);
                            }
                        ?>
                        <form class="row g-3" method="post">
                            <div class="col">
                                <label class="visually-hidden">Cari Alumni</label>
                                <input type="search" class="form-control" name="searchBox" placeholder="Cari Alumni">
                            </div>
                            <div class="col-auto">
                                <div class="btn-group" role="group" aria-label="BT-Search">
                                    <button type="submit" class="btn btn-primary mb-3"><i class="ri-search-2-line"></i></button>
                                    <a href="./browse.php" class="btn btn-primary mb-3 active button_login"><span><i class="ri-earth-line"></i> Browse Alumni</span></a>
                                </div>
                            </div>
                        </form>
                    </div>



                    <div class="title_header">
                        <span><i class="ri-alarm-warning-line"></i> New Database Added</span>
                    </div>

                    <div class="database_wrapper mini_text">
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
                                                <span class="badge bg-danger rounded-pill mini_text"><i class="ri-information-line"></i></span>
                                            </li>           
                                        ';
                                    }
                                }
                            ?>
                        </ul>
                    </div>

                    <div class="title_header">
                        <span><i class="ri-question-line"></i> Frequently Asked Questions</span>
                    </div>

                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Cara Mencari Alumni?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Untuk mencari alumni gunakan fitur pencarian di atas, masukkan kata kunci berupa nama/dinasty/perusahaan (salah satu atau lebih).
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Apa Itu Browse Alumni?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Browse alumni adalah fitur untuk melakukan listing seluruh alumni tanpa filter pencarian. Filter pencarian tetap dapat dilakukan di dalam menu.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Saya Anggota Workshop Electro Namun Belum Terdata!
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Apabila pendataan kami ada yang terlewat silakan hubungi humas kami via WhatsApp di <a href="//wa.me/<?php echo $humasJsonDecode['humasPhone']  ?>" class="btn btn-success button_login"><span><i class="ri-whatsapp-line"></i> <?php echo $humasJsonDecode['humasName']  ?></span></a> dengan menyebutkan angkatan tahun berapa/dinasty berapa.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-12 right_container">
                    <?php include "./sidebar.php" ?>
                </div>
            </div>
        </div>
    </body>
</html>
