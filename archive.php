<?php
/**
 * Template for displaying archive pages.
 *
 * @package YourThemeName
 */

get_header();
?>

<section id="home-post">
    <h2 class="cat-title">
      <?php
      if (is_category()) {
        single_cat_title();
      } elseif (is_tag()) {
        single_tag_title();
      } elseif (is_author()) {
        echo 'Bài viết của: ' . get_the_author();
      } elseif (is_day()) {
        echo 'Lưu trữ theo ngày: ' . get_the_date();
      } elseif (is_month()) {
        echo 'Lưu trữ theo tháng: ' . get_the_date('F Y');
      } elseif (is_year()) {
        echo 'Lưu trữ theo năm: ' . get_the_date('Y');
      } elseif (is_tax('movie_genre')) {
        single_term_title();
      } else {
        echo 'Lưu trữ';
      }
      ?>
    </h2>

  <div class="movie-grid">
    <?php
    if (have_posts()) {
      while (have_posts()) {
        the_post();
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
        <h3><?php the_title(); ?></h3>
        <span><?php echo esc_html(get_post_meta(get_the_ID(), '_eng_name', true)); ?></span>
      </a>
      <span class="movie-status">
        <?php 
        if (is_tax('movie_genre')) {
          echo esc_html(get_post_meta(get_the_ID(), '_movie_type', true));
        } else {
          echo esc_html(get_post_meta(get_the_ID(), '_trang_thai', true)); 
        }
        ?>
      </span>
    </article>
    <?php
      }
    } else {
      echo '<p>Không có bài viết nào.</p>';
    }
    ?>
  </div>

  <div class="pagination">
    <?php
    the_posts_pagination( array(
      'mid_size' => 2,
      'prev_text' => __( '« Trước', 'your-text-domain' ),
      'next_text' => __( 'Tiếp »', 'your-text-domain' ),
    ) );
    ?>
  </div>

</section>

<?php
get_footer();
