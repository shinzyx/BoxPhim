<?php get_header(); ?>

<section id="home-post">
    <?php
    // Lấy trang hiện tại
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    // Hiển thị tiêu đề dựa trên trang hiện tại
    if ($paged > 1) : // Kiểm tra nếu không phải trang đầu tiên ?>
        <h2 class="cat-title">Phim Mới Nhất - Trang <?php echo esc_html($paged); ?></h2>
    <?php else : ?>
        <h2 class="cat-title">Phim Mới Nhất</h2>
    <?php endif; ?>

    <div class="movie-grid">
        <?php
        // Arguments cho WP_Query
        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => 10, // Số bài viết mỗi trang
            'orderby'        => 'date', // Sắp xếp theo ngày đăng
            'order'          => 'DESC', // Mới nhất ở trên
            'paged'          => $paged // Phân trang
        );

        // Thực hiện query
        $query = new WP_Query($args);

        // Kiểm tra xem có bài viết nào không
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
            echo '<p>No posts found.</p>';
        }

        // Khôi phục dữ liệu gốc
        wp_reset_postdata();
        ?>
    </div>

    <nav class="pagination">
    <?php
    echo paginate_links(array(
        'total' => $query->max_num_pages,
        'current' => $paged,
        'format' => '?paged=%#%', // Đảm bảo rằng query string 'paged' đang được sử dụng
        'show_all' => false,
        'type' => 'list', // Cấu trúc dạng danh sách ul li
        'end_size' => 1, // Hiển thị số trang ở đầu và cuối danh sách (ví dụ: 1 ... 10)
        'mid_size' => 1, // Hiển thị số trang liền kề với trang hiện tại (ví dụ: 4 5 6)
        'prev_next' => false, // Bỏ nút "Trước" và "Tiếp"
        'before_page_number' => '<span class="pagination-number">', // Thêm class vào số trang
        'after_page_number' => '</span>',
    ));
    ?>
    </nav>

</section>

<?php get_footer(); ?>
