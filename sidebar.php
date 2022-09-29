<?php
    /**
     * @var $connClass
     */
    include_once './connectionClass.php';
    $connClass = new connectionClass();
?>

<div class="sidebar_header">
    <span><i class="ri-fire-line"></i> Most Viewed Alumni</span>
</div>

<div>
    <ul class="list-group">
        <?php
        @$mostResult = $connClass->runBaseQuery(
            'SELECT * FROM alumni ORDER BY view DESC LIMIT 7',
            'while'
        );

        if(is_array($mostResult) == 1){
            foreach ($mostResult as $mostRow){
                $mostID = $mostRow['id_alumni'];
                $mostName = $mostRow['name'];
                $mostCount = $mostRow['view'];

                echo '
                                            <li class="list-group-item d-flex justify-content-between align-items-start link_stylized">
                                                <div class="ms-2 me-auto">
                                                    <a href="./details.php?id='.$mostID.'">'.$mostName.'</a> <span class="mini_text icon_vertical_center"><span><i class="ri-eye-line"></i> '.$mostCount.'</span></span>
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
    <span><i class="ri-links-line"></i> Fast Links</span>
</div>

<div class="card">
    <div class="card-body line_height_custom">
        <div class="icon_vertical_center mini_text link_stylized">
            <a href="https://www.wsecpolinema.com/"><span><i class="ri-global-line"></i> wsecpolinema.com</span></a>
        </div>
        <div class="icon_vertical_center mini_text link_stylized">
            <a href="https://www.instagram.com/wsecpolinema/?hl=en"><span><i class="ri-instagram-line"></i> @wsecpolinema</span></a>
        </div>
        <div class="icon_vertical_center mini_text link_stylized">
            <a href="https://goo.gl/maps/zyHcU3pM4ivZrXwNA"><span><i class="ri-map-pin-line"></i> Gedung AJ Lt.1 Politeknik Negeri Malang</span></a>
        </div>
        <div class="icon_vertical_center mini_text link_stylized">
            <a href="//wa.me/<?php echo $humasJsonDecode['humasPhone']  ?>"><span><i class="ri-whatsapp-line"></i> <?php echo $humasJsonDecode['humasName']  ?>-Humas</span></a>
        </div>
    </div>
</div>