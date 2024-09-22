<section id="home-post">
    <h2 class="cat-title">Phim Đề Xuất</h2>
    <div class="movie-grid">
        <?php
        $current_post_id = get_the_ID();
        $current_category = get_the_category($current_post_id);

        // Kiểm tra xem bài viết hiện tại có thuộc danh mục nào không
        if ($current_category) {
            $category_id = $current_category[0]->term_id; // Lấy ID của danh mục đầu tiên

            // Query các bài viết trong cùng danh mục với bài viết hiện tại
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 10,
                'category__in' => array($category_id),
                'post__not_in' => array($current_post_id), // Loại trừ bài viết hiện tại
                'orderby' => 'date',
                'order' => 'DESC',
                'meta_query' => array(
                    array(
                        'key' => '_thumbnail_id', // Chỉ lấy các bài viết có thumbnail
                        'compare' => 'EXISTS'
                    ),
                )
            );

            $related_posts = new WP_Query($args);

            // Nếu không có bài viết nào trong cùng danh mục, hiển thị bài viết ngẫu nhiên
            if (!$related_posts->have_posts()) {
                $args['category__in'] = '';
                $args['orderby'] = 'rand';
                $related_posts = new WP_Query($args);
            }

            // Hiển thị bài viết
            if ($related_posts->have_posts()) :
                while ($related_posts->have_posts()) : $related_posts->the_post();
                    ?>
                    <article class="movie-item">
                        <a href="<?php the_permalink(); ?>" class="movie-thumb">
                            <?php the_post_thumbnail('medium'); ?>
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
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>Không có phim đề xuất nào.</p>';
            endif;
        } else {
            echo '<p>Không có phim đề xuất nào.</p>';
        }
        ?>
    </div>
</section>