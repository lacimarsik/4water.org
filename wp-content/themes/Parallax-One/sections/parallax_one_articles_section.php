<!-- =========================
 SECTION: ARTICLES
========================== -->
<?php
  $articles_title = get_theme_mod('articles_title', DefArticles::$title);
  $articles_content = get_theme_mod('articles_content', DefArticles::$content);

  if(!empty($articles_title) ||
     !empty($articles_content)) { ?>
    <section id="articles">
      <div class="section-overlay-layer">
        <div class="container">

          <!-- HEADER -->
          <div class="section-header"> <?php
            if(!empty($articles_title)) {
              echo '<h2 class="dark-text">'.esc_attr($articles_title).'</h2>';
            } ?>
          </div>

          <!-- ARTICLES CONTENT -->
          <?php
          if (!empty($articles_content)) {
            $articles_decoded = json_decode($articles_content);
            echo '<div id="articles-wrap">';
              $counter = 0;
              foreach($articles_decoded as $articles_item) {
                if (!empty($articles_item->text) ||
                   !empty($articles_item->link)) {
                  if ($counter % 2 == 0) {
                    if ($counter > 0) {
                      echo '</div>';
                    }
                    echo '<div class="articles-row col-md-12">';
                  }
                    echo '<div class="col-md-6 articles-box">';
                    if (!empty($articles_item->image) && !empty($articles_item->text)) {
                      echo '<img class="articles-img" src="'.$articles_item->image.'" alt="'.$articles_item->text.'">';
                    }

                    if (!empty($articles_item->text) && !empty($articles_item->link) && !empty($articles_item->link_text)) {
                      echo '<p class="colored-text">'.esc_attr($articles_item->text);
                        echo '<a class="articles-link" href="'. esc_attr($articles_item->link).'">' . esc_attr($articles_item->link_text) . '</a>';
                      echo '</p>';
                    }
                    echo '</div>';
                  $counter++;
                }
              }
            echo '</div>'; //articles-wrap
          } ?>
        </div>
      </div>
    </section> <?php
  } ?>