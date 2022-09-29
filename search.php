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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Search result for "<?php echo $_GET['s'] ?>" | Dashboard Alumni WSEC</title>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

        <!-- styling start -->
        <link rel="stylesheet" href="assets/style/main.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.2.0/fonts/remixicon.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
        <!-- styling end -->

    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9 col-sm-12 left_container">
                    <div class="title_header">
                        <span><i class="ri-search-2-line"></i> Search result for <?php echo $_GET['s'] ?></span>
                    </div>

                    <table id="dataAlumni" class="display">
                        <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Alias</th>
                            <th>Perusahaan</th>
                            <th>Tahun</th>
                            <th>Link</th>
                        </tr>
                        </thead>
                        <tbody>

                    <?php
                        @$alumniResult = $connClass->runQuery(
                            'SELECT * FROM alumni WHERE name LIKE ? || alias LIKE ? || year_in LIKE ? || prodi LIKE ? || company LIKE ? || phone LIKE ? || email LIKE ? || bio LIKE ?',
                            ['%'.$_GET['s'].'%', '%'.$_GET['s'].'%', '%'.$_GET['s'].'%', '%'.$_GET['s'].'%', '%'.$_GET['s'].'%', '%'.$_GET['s'].'%', '%'.$_GET['s'].'%', '%'.$_GET['s'].'%'],
                            'if'
                        );

                        if(is_array($alumniResult) == 1) {
                            foreach ($alumniResult as $alumniRow) {
                                $alumniId = $alumniRow['id_alumni'];
                                $alumniName = $alumniRow['name'];
                                $alumniAlias = $alumniRow['alias'];
                                $alumniYear = $alumniRow['year_in'];
                                $alumniDinasty = $alumniYear - 1995;
                                $alumniCompany = $alumniRow['company'];

                                echo '
                                    <tr>
                                        <td>' . $alumniName . '</td>
                                        <td>' . $alumniAlias . '</td>
                                        <td>' . $alumniCompany . '</td>
                                        <td>' . $alumniYear . ' (D' . $alumniDinasty . ')</td>
                                        <td><a href="./details.php?id='.$alumniId.'" class="btn btn-primary mini_text">Lihat</a></td>
                                    </tr>
                                ';
                            }
                        }
                    ?>

                        </tbody>
                    </table>
                </div>
                <div class="col-md-3 col-sm-12 right_container">
                    <div class=" sticky-top">
                        chat
                    </div>
                </div>
            </div>
        </div>

        <!-- scripting start -->
        <script>
            $(document).ready(function () {
                $('#dataAlumni').DataTable({
                    searching: false
                });
            });
        </script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

        <!-- scripting end -->
    </body>
</html>
