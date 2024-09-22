<section id="home-post">
  <div class="heading-box">
    <h2 class="cat-title">Phim Mới</h2>
    <a href="<?php echo esc_url( home_url( '/phim-moi/' ) ); ?>" class="viewmore">Xem Thêm</a>
  </div>
  <div class="movie-grid">
    <?php
    // Arguments for the query
    $args = array(
      'post_type'      => 'post',
      'posts_per_page' => 12, // Lấy tất cả các bài viết
      'orderby'        => 'date', // Sắp xếp theo ngày đăng
      'order'          => 'DESC'  // Mới nhất ở trên
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
              the_post_thumbnail('full', array('alt' => get_the_title()));
            } else {
              echo '<img src="https://via.placeholder.com/500x150" alt="' . get_the_title() . '" />';
            }
            ?>
      </a>
      <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="movie-title">
    <h3>
        <?php 
        // Lấy meta 'Tên Phim' từ meta box
        $ten_phim = get_post_meta(get_the_ID(), '_ten_phim', true);
        
        // Kiểm tra nếu 'Tên Phim' không trống thì hiển thị, ngược lại hiển thị tiêu đề bài viết
        if (!empty($ten_phim)) {
            echo esc_html($ten_phim);
        } else {
            the_title();
        }
        ?>
    </h3>
    <?php 
    // Lấy meta 'Tên Tiếng Anh' từ meta box
    $eng_name = get_post_meta(get_the_ID(), '_eng_name', true);
    
    // Kiểm tra nếu 'Tên Tiếng Anh' không trống thì hiển thị
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
      echo '<p>No posts found.</p>';
    }

    // Restore original Post Data
    wp_reset_postdata();
    ?>
  </div>
</section>