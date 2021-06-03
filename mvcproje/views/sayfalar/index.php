<?php require 'views/header.php'; ?>


<div id="carousel-example" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php

        for ($a=0; $a<count($Harici->slider); $a++) :

            if ($a==0):
                echo '<li data-target="#carousel-example" data-slide-to="'.$a.'" class="active"></li>';
            else:
                echo '<li data-target="#carousel-example" data-slide-to="'.$a.'"></li>';
            endif;

        endfor;

        ?>

    </ol>

    <div class="carousel-inner">

        <?php
        $sayi=0;
        foreach ($Harici->slider as $anahtar => $deger) :


            ?>
            <div class="item <?php if ($sayi==0): echo "active"; endif;  ?>">
                <a href="#">

                    <img alt="" src="<?php echo RESİMGORUNTULE.$Harici->slider[$anahtar]["resim"]; ?>" /></a>

                <div class="carousel-caption">
                    <h3><?php echo $Harici->slider[$anahtar]["sloganUst"]; ?></h3>
                    <p><?php echo $Harici->slider[$anahtar]["sloganAlt"]; ?></p>
                </div>
            </div>
            <?php
            $sayi=1;


        endforeach;

        ?>


    </div>

    <a class="left carousel-control" href="#carousel-example" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-example" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>
<!-- content-section-starts-here -->
<div class="container">
    <div class="main-content">




        <div class="products-grid">
            <header>
                <h3 class="head text-center">YENİ ÜRÜNLER</h3>
            </header>


            <?php

            foreach ($veri["data1"] as $value) :
                ?>

                <div class="col-md-4 product simpleCart_shelfItem text-center">
                    <a href="<?php echo URL; ?>/urunler/detay/<?php  echo $value["id"]; ?>/<?php  echo $Harici->seo($value["urunad"]); ?>"><img src="<?php echo URL; ?>/views/design/images/<?php  echo $value["res1"]; ?>" alt="<?php  echo $value["urunad"]; ?>" /></a>
                    <div class="mask">
                        <a href="<?php echo URL; ?>/urunler/detay/<?php  echo $value["id"]; ?>/<?php  echo $Harici->seo($value["urunad"]); ?>">İNCELE</a>
                    </div>
                    <a class="product_name" href="<?php echo URL; ?>/urunler/detay/<?php  echo $value["id"]; ?>/<?php  echo $Harici->seo($value["urunad"]); ?>"><?php  echo $value["urunad"]; ?></a>
                    <p><a class="item_add" href="<?php echo URL; ?>/urunler/detay/<?php  echo $value["id"]; ?>/<?php  echo $Harici->seo($value["urunad"]); ?>"><i></i> <span class="item_price"><?php  echo  number_format($value["fiyat"],2,'.',','); ?></span></a></p>
                </div>


            <?php




            endforeach;


            ?>





            <div class="clearfix"></div>
        </div>
    </div>

</div>
<div class="other-products">
    <div class="container">
        <h3 class="like text-center">EN ÇOK SATANLAR</h3>
        <ul id="flexiselDemo3">


            <?php

            foreach ($veri["data2"] as $value2) :
                ?>


                <li><a href="<?php echo URL; ?>/urunler/detay/<?php  echo $value2["id"]; ?>/<?php  echo $Harici->seo($value2["urunad"]); ?>"><img src="<?php echo URL; ?>/views/design/images/<?php  echo $value2["res2"]; ?>" class="img-responsive" alt="<?php  echo $value2["urunad"]; ?>" /></a>
                    <div class="product liked-product simpleCart_shelfItem">
                        <a class="like_name" href="<?php echo URL; ?>/urunler/detay/<?php  echo $value2["id"]; ?>/<?php  echo $Harici->seo($value2["urunad"]); ?>"><?php  echo $value2["urunad"]; ?></a>
                        <p><a class="item_add" href="<?php echo URL; ?>/urunler/detay/<?php  echo $value2["id"]; ?>/<?php  echo $Harici->seo($value2["urunad"]); ?>"><i></i> <span class=" item_price"><?php  echo  number_format($value2["fiyat"],2,'.',','); ?></span></a></p>
                    </div>
                </li>


            <?php




            endforeach;


            ?>






        </ul>
        <script type="text/javascript">
            $(window).load(function() {
                $("#flexiselDemo3").flexisel({
                    visibleItems: 4,
                    animationSpeed: 1000,
                    autoPlay: true,
                    autoPlaySpeed: 3000,
                    pauseOnHover: true,
                    enableResponsiveBreakpoints: true,
                    responsiveBreakpoints: {
                        portrait: {
                            changePoint:480,
                            visibleItems: 1
                        },
                        landscape: {
                            changePoint:640,
                            visibleItems: 2
                        },
                        tablet: {
                            changePoint:768,
                            visibleItems: 3
                        }
                    }
                });

            });
        </script>
        <script type="text/javascript" src="<?php echo URL; ?>/views/design/js/jquery.flexisel.js"></script>
    </div>
</div>
<!-- content-section-ends-here -->
<div class="news-letter">
    <div class="container">



        <?php $Harici->bulten(); ?>




    </div>
</div>

<?php require 'views/footer.php'; ?>



