<?php get_header(); ?>

<div class="left-content">
  <section id="movie-main">
    <div class="main-box">
      <div class="movie-thumb">
        <?php
        if (has_post_thumbnail()) {
          the_post_thumbnail('full', array('alt' => esc_attr(get_the_title())));
        } else {
          echo '<img src="' . esc_url('https://via.placeholder.com/500x150') . '" alt="' . esc_attr(get_the_title()) . '" />';
        }
        ?>
      </div>
      <ul class="main-info">
        <li><h1><?php the_title(); ?></h1></li>
        <li>Eng Name: 
    <?php 
    $eng_name = get_post_meta(get_the_ID(), '_eng_name', true);
    echo !empty($eng_name) ? esc_html($eng_name) : 'Unknown'; 
    ?>
</li>
<li>Trạng Thái: 
    <?php 
    $trang_thai = get_post_meta(get_the_ID(), '_trang_thai', true);
    echo !empty($trang_thai) ? esc_html($trang_thai) : 'Unknown'; 
    ?>
</li>
        <li>Diễn Viên: 
        <?php 
        $dien_vien_terms = get_the_terms(get_the_ID(), 'dien_vien'); 
        if ($dien_vien_terms && !is_wp_error($dien_vien_terms)) {
            $dien_vien_links = array();
            foreach ($dien_vien_terms as $term) {
                $dien_vien_links[] = '<a href="' . esc_url(get_term_link($term)) . '" rel="tag">' . esc_html($term->name) . '</a>';
            }
            echo implode(', ', $dien_vien_links); 
        } else {
            echo 'Đang cập nhật...';
        }
        ?>
    </li>
    
    <li>Thể Loại: 
        <?php 
        $the_loai_terms = get_the_terms(get_the_ID(), 'the_loai'); 
        if ($the_loai_terms && !is_wp_error($the_loai_terms)) {
            $the_loai_links = array();
            foreach ($the_loai_terms as $term) {
                $the_loai_links[] = '<a href="' . esc_url(get_term_link($term)) . '" rel="tag">' . esc_html($term->name) . '</a>';
            }
            echo implode(', ', $the_loai_links); 
        } else {
            echo 'Đang cập nhật...';
        }
        ?>
    </li>

    <li>Quốc Gia: 
        <?php 
        $quoc_gia_terms = get_the_terms(get_the_ID(), 'quoc_gia'); 
        if ($quoc_gia_terms && !is_wp_error($quoc_gia_terms)) {
            $quoc_gia_links = array();
            foreach ($quoc_gia_terms as $term) {
                $quoc_gia_links[] = '<a href="' . esc_url(get_term_link($term)) . '" rel="tag">' . esc_html($term->name) . '</a>';
            }
            echo implode(', ', $quoc_gia_links); 
        } else {
            echo 'Đang cập nhật...';
        }
        ?>
    </li>

    <li>Năm: 
        <?php 
        $nam_terms = get_the_terms(get_the_ID(), 'nam'); 
        if ($nam_terms && !is_wp_error($nam_terms)) {
            $nam_links = array();
            foreach ($nam_terms as $term) {
                $nam_links[] = '<a href="' . esc_url(get_term_link($term)) . '" rel="tag">' . esc_html($term->name) . '</a>';
            }
            echo implode(', ', $nam_links); 
        } else {
            echo 'Đang cập nhật...';
        }
        ?>
    </li>
        <li>Lượt Xem: <?php echo esc_html(get_post_view(get_the_ID())); ?></li>
        <li class="view-now">
          <a class="view-btn" href="<?php echo esc_url(home_url('/xem-phim/' . get_post_field('post_name', get_the_ID()))); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-play">
              <polygon points="5 3 19 12 5 21 5 3"></polygon>
            </svg>
            Xem Ngay
          </a>
        </li>
      </ul>
    </div>

    <?php
    // Lấy danh sách tập phim từ meta field
    $episodes = get_post_meta(get_the_ID(), 'episode_list', true);
    if (!empty($episodes)) :
        $episodes = explode("\n", $episodes); // Tách các tập phim
        ?>
        <div class="episode-list">
            <h2>Danh Sách Tập Phim</h2>
            <ul>
                <?php foreach ($episodes as $index => $episode) :
                    $parts = explode('|', $episode); // Tách tên tập và URL
                    $episode_name = $parts[0];
                    ?>
                    <li>
                        <!-- Tạo URL với query parameter 'tap' đồng bộ -->
                        <a href="<?php echo esc_url(add_query_arg('tap', $index + 1, home_url('/xem-phim/' . get_post_field('post_name', get_the_ID())))); ?>">
                            <?php echo esc_html($episode_name); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="line"></div>

    <div class="movie-content">
      <?php the_content(); ?>
      <?php wp_link_pages(); ?>
      <ul class="movie-tag-seo">
    <li>
        Từ Khoá:
    </li>
    <?php
    // Lấy danh sách thẻ tag của bài post hiện tại
    $post_tags = get_the_tags();

    if ($post_tags) {
        foreach ($post_tags as $tag) {
            echo '<li><a href="' . esc_url(get_tag_link($tag->term_id)) . '" title="' . esc_attr($tag->name) . '">';
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line>';
            echo '</svg>';
            echo esc_html($tag->name) . '</a></li>';
        }
    } else {
        echo '<li>Chưa có thẻ tag</li>';
    }
    ?>
</ul>


    </div>
  </section>

  <?php get_template_part("template-parts/related-movies"); ?>
</div>

<?php get_template_part("template-parts/side-bar"); ?>

<?php get_footer(); ?>