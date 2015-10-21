<!-- =========================
 SECTION: HOW WE TEACH
========================== -->
<?php
    $how_we_teach_image_1 = get_theme_mod('how_we_teach_image_1', parallax_get_file('/images/no-partner.png'));
    $how_we_teach_caption_1 = get_theme_mod('how_we_teach_caption_1', 'No partner needed');
    $how_we_teach_image_2 = get_theme_mod('how_we_teach_image_2', parallax_get_file('/images/rueda.png'));
    $how_we_teach_caption_2 = get_theme_mod('how_we_teach_caption_2', 'Rueda de casino');
    $how_we_teach_text = get_theme_mod('how_we_teach_text', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ...');

    if(!empty($how_we_teach_image_1) ||
        !empty($how_we_teach_caption_1) ||
        !empty($how_we_teach_image_2) ||
        !empty($how_we_teach_caption_2) ||
        !empty($how_we_teach_text)) {
?>
    <section id="how_we_teach">
        <div class="section-overlay-layer">
            <div class="container">
                <div class="how-we-teach-wrap">
                    <div class="how-we-teach-left">

                    <!-- HOW WE TEACH IMAGE 1 -->
                    <?php
                        if(!empty($how_we_teach_image_1) && !empty($how_we_teach_caption_1)) {
                            echo '<img class="how-we-teach-image-1" src="'.$how_we_teach_image_1.'" title="'.$how_we_teach_caption_1.'" alt="'.$how_we_teach_caption_1.'">';
                        }
                    ?>
                    </div>
                    <div class="how-we-teach-center">
                        <!-- HOW WE TEACH TEXT -->
                        <p class="how-we-teach-text">
                            <?php
                            if(!empty($how_we_teach_text)) {
                                echo $how_we_teach_text;
                            }
                            ?>
                        </p>
                    </div>
                    <div class="how-we-teach-right">

                        <!-- HOW WE TEACH IMAGE 2 -->
                        <?php
                            if(!empty($how_we_teach_image_2) && !empty($how_we_teach_caption_2)) {
                                echo '<img class="how-we-teach-image-2" src="'.$how_we_teach_image_2.'" title="'.$how_we_teach_caption_2.'" alt="'.$how_we_teach_caption_2.'">';
                            }
                        ?>
                    </div>
                </div>
            </div>	
        </div>
    </section>
<?php
    }
?>