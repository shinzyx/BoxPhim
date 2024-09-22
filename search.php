<?php
/**
 * Template for displaying search results.
 *
 * @package YourThemeName
 */

get_header();
?>

<div class="left-content">
<section id="home-post">
    <h2 class="cat-title">
      <?php
      // Hiển thị tiêu đề kết quả tìm kiếm
      printf( __( 'Kết quả tìm kiếm cho: %s', 'your-text-domain' ), '<span>' . get_search_query() . '</span>' );
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
      echo '<p>Không có bài viết nào khớp với từ khóa tìm kiếm của bạn.</p>';
    }
    ?>
  </div>
  
  <!-- Điều hướng trang -->
  <div class="pagination">
    <?php
    // Hiển thị phân trang
    the_posts_pagination( array(
      'mid_size' => 2,
      'prev_text' => __( '« Trước', 'your-text-domain' ),
      'next_text' => __( 'Tiếp »', 'your-text-domain' ),
    ) );
    ?>
  </div>
</section>

</div>

<?php get_template_part("template-parts/side-bar"); ?>

<?php
get_footer();
?>
