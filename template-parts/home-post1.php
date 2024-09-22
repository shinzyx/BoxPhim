<section id="home-post">
  <div class="heading-box">
    <h2 class="cat-title">Phim Bộ Mới Nhất</h2>
    <a href="<?php echo esc_url(get_category_link(get_category_by_slug('phim-bo')->term_id)); ?>" class="viewmore">Xem Thêm</a>
  </div>
  <div class="movie-grid">
    <?php
    // Arguments for the query
    $args = array(
      'post_type'      => 'post',
      'posts_per_page' => 12, // Lấy 12 bài viết mới nhất
      'orderby'        => 'date', // Sắp xếp theo ngày đăng
      'order'          => 'DESC',  // Mới nhất ở trên
      'category_name'  => 'phim-bo', // Lấy bài viết từ category 'phim-bo'
      'ignore_sticky_posts' => 1 // Bỏ qua các bài viết sticky
    );

    // Custom query
    $query = new WP_Query($args);

    // Check if the query returns any posts
    if ($query->have_posts()) {
      while ($query->have_posts()) {
        $query->the_post();
    ?>
    <article class="movie-item">
      <a href="<?php the_permalink(); ?>" class="movie-thumb">
        <?php
        if (has_post_thumbnail()) {
          the_post_thumbnail('full', array('alt' => esc_attr(get_the_title())));
        } else {
          echo '<img src="https://via.placeholder.com/500x150" alt="' . esc_attr(get_the_title()) . '" />';
        }
        ?>
      </a>
      <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="movie-title">
        <h3><?php the_title(); ?></h3>
        <?php
        $eng_name = get_post_meta(get_the_ID(), '_eng_name', true);
        if (!empty($eng_name)) : ?>
          <span><?php echo esc_html($eng_name); ?></span>
        <?php endif; ?>
      </a>
      <?php
      $trang_thai = get_post_meta(get_the_ID(), '_trang_thai', true);
      if (!empty($trang_thai)) : ?>
        <span class="movie-status">
          <?php echo esc_html($trang_thai); ?>
        </span>
      <?php endif; ?>
    </article>
    <?php
      }
    } else {
      echo '<p>Không có bài viết nào được tìm thấy.</p>';
    }

    // Restore original Post Data
    wp_reset_postdata();
    ?>
  </div>
</section>
