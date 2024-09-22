<section id="home-featured">
  <h2 class="cat-title">Thịnh Hành</h2>
  <div class="sliders-container">
    <button class="slider-btn prev" aria-label="Previous slide">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
        class="feather feather-chevron-left">
        <polyline points="15 18 9 12 15 6"></polyline>
      </svg>
    </button>
    <div class="sliders">
      <?php
            // Lấy các bài viết thịnh hành
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 10, // Số lượng bài viết muốn hiển thị
                'meta_key' => 'post_views_count',
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
                'date_query' => array(
                    array(
                        'after' => '2 weeks ago',
                    ),
                ),
            );

            $query = new WP_Query($args);

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
            ?>
          <article class="sliders-item">
            <a href="<?php the_permalink(); ?>" class="movie-thumb">
              <?php
              if (has_post_thumbnail()) {
                the_post_thumbnail('full', array('alt' => get_the_title()));
              } else {
                echo '<img src="https://via.placeholder.com/300x400" alt="' . get_the_title() . '" />';
              }
              ?>
            </a>
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="movie-title">
              <h3><?php the_title(); ?></h3>
              <span><?php echo esc_html(get_post_meta(get_the_ID(), '_eng_name', true)); ?></span>
            </a>
            <span class="movie-status">Thịnh Hành</span>
          </article>
      <?php
        }
      } else {
        echo '<p>No posts found.</p>';
      }

      // Restore original Post Data
      wp_reset_postdata();
      ?>
    </div>
    <button class="slider-btn next" aria-label="Next slide">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
        class="feather feather-chevron-right">
        <polyline points="9 18 15 12 9 6"></polyline>
      </svg>
    </button>
  </div>
</section>