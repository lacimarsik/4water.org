<!-- =========================
INTERGEO MAPS 
============================== -->
<?php
  $parallax_one_contact_map_shortcode = get_theme_mod('parallax_one_contact_map_shortcode');
  if( !empty($parallax_one_contact_map_shortcode) ){
?>
    <!-- OVERRIDE MAP STYLING -->
    <style>
      #cd-google-map .intergeo_map_canvas {
        height: 400px !important;
      }
    </style>
    <div id="container-fluid">
      <div class="parallax_one_map_overlay"></div>
      <div id="cd-google-map">
        <?php echo do_shortcode($parallax_one_contact_map_shortcode);?>
      </div>
    </div><!-- .container-fluid -->
<?php   
     }
?>
