<?php require 'views/YonPanel/header.php'; ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

    <!-- Page Heading -->


    <div class="row">
        <div class="col-xl-12 col-md-12 mb-12 text-center">

            <?php




            if (isset($veri["bilgi"])) :


                echo $veri["bilgi"];


            endif;

            if (isset($veri["sistembakim"])) :




                    ?>

                    <!-- BAŞLIK -->

                    <div class="row text-left border-bottom-mvc mb-2">

                        <div class="col-xl-12 col-md-12 mb-12 border-left-mvc text-left p-2 mb-2">
                            <h1 class="h3 mb-0 text-gray-800"> <i class="fas fa-th basliktext"></i> SİSTEM BAKIM </h1></div>


                    </div>
                    <!-- BAŞLIK -->


                    <!--  FORMUN İSKELETİ-->

                    <div class="col-xl-12 col-md-12  text-center">



                        <div class="row text-center">

                            <div class="col-xl-4 col-md-6 mx-auto">


                                <div class="row bg-gradient-beyazimsi">

                                    <div class="col-lg-12 col-md-12 col-sm-12 bg-gradient-mvc pt-2 basliktext2"><h3>Sistem Bakımı Yap</h3></div>





                                    <div class="col-lg-12 col-md-12 col-sm-12 formeleman nocizgi"><?php


                                        Form::Olustur("1", array(
                                            "action" => URL . "/panel/bakimyap",
                                            "method" => "POST"
                                        ));


                                        Form::Olustur("2",array("type"=>"submit","value"=>"BAKIMI BAŞLAT","class"=>"btn btn-success","name"=>"sistembtn"));

                                        Form::Olustur("kapat");	 ?>
                                    </div>



                                    <div class="col-lg-12 col-md-12 col-sm-12 formeleman nocizgi"><?php


                                        $geldi=$PanelHarici->tekverial("ayarlar");

                                        echo "Son Bakım : ".$geldi[0]["bakimzaman"];	 ?>
                                    </div>







                                </div>






                            </div>


                        </div>
                    </div>

                    <!--  FORMUN İSKELETİ-->


                <?php








            endif; // BAKIM

            //*****************************************************************************

                ?>

            </div>


        </div>
        <!-- /.row bitiyor -->

    </div>
    <!-- /.container-fluid -->





<?php require 'views/YonPanel/footer.php'; ?>