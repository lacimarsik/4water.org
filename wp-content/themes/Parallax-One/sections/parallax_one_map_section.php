<!-- =========================
INTERGEO MAPS 
============================== -->
<?php
  $parallax_one_contact_map_shortcode = get_theme_mod('parallax_one_contact_map_shortcode');
  $maps_content = get_theme_mod('maps_content', DefContact::$maps_content);
  $title_above = get_theme_mod('maps_title_above', DefContact::$title_above);
  $use_links = get_theme_mod('maps_use_links', DefContact::$use_links);

  if (!empty($maps_content)) {
?>
  <div id="map-section">
    <!-- Override Google map styling -->
    <style>
      #cd-google-map .intergeo_map_canvas {
        height: 400px !important;
      }
    </style>
<?php
    if (!empty($title_above)) {
?>
      <h2 class="maps-title dark-text"><?php echo $title_above; ?></h2>
<?php
    }
?>
    <!-- jQuery for switching the maps -->
    <script>
      $(document).ready(function() {
        var buttons = $('.map-selection-button');
        var maps = $('.map-section');

        // XXX: Map loading issue - they need to be visible on the first load, and then we hide with JS, and show only the selected one
        setTimeout(function(){
          maps.css('display','none');
          $('#map-0').css('display','block');
        }, 2000);

        $('.map-selection-button').on('click', function() {
          var hrefUrl = ($(this).attr('href'));
          // we do not switch maps if the button serves as link
          if (!hrefUrl) {
            buttons.removeClass('map-selection-button-selected');
            $(this).addClass('map-selection-button-selected');

            elementId = $(this).attr('id');
            var mapId = elementId.substr(elementId.indexOf("-") + 1);

            maps.removeClass('map-section-selected');
            $('#map-' + mapId).addClass('map-section-selected');
            // XXX: Map loading issue - changing class only has some issues with Google Maps - they don't display well
            maps.css('display','none');
            $('#map-' + mapId).css('display','block');
          }
        });
      });
    </script>

    <!-- Map selection -->
<?php
    $maps_content_decoded = json_decode($maps_content);
    if (sizeof($maps_content_decoded) > 1) {
      echo '<div id="map-selection-wrap">';
      $counter = 0;
      foreach ($maps_content_decoded as $map) {
        ?>
        <a class="map-selection-button <?php if (($counter == 0) && (!$use_links)) {
          echo "map-selection-button-selected";
        } ?>" <?php if (!empty($map->link)) {
          echo 'href="' . $map->link . '" target="_blank"';
        } ?> id="mapselection-<?php echo $counter; ?>">
          <?php echo $map->label; ?>
        </a>
        <?php
        $counter++;
      }
    }
?>
    </div>
    <!-- Maps -->
    <div id="map-section-wrap">
<?php
    $counter = 0;
    foreach($maps_content_decoded as $map) {
      if (!empty($map->shortcode_id)) {
?>
        <div class="map-section <?php if ($counter == 0) {
          echo 'map-section-selected';
        } ?>" id="map-<?php echo $counter; ?>">
          <div class="map-container-fluid">
            <div class="parallax_one_map_overlay"></div>
            <div id="cd-google-map">
              <?php echo do_shortcode('[intergeo id="' . $map->shortcode_id . '"][/intergeo]'); ?>
            </div>
          </div><!-- .map-container-fluid -->
        </div><!-- .map-section -->
        <?php
      }
      $counter++;
    }
  }
?>
    </div>
  </div>
