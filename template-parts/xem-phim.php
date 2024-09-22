<?php
get_header();
?>

<div class="left-content">
    <?php
    $xem_phim_slug = get_query_var('xem_phim_slug');
    $tap_index = intval(get_query_var('tap', 1)) - 1;

    $args = array(
        'post_type' => 'post',
        'name' => $xem_phim_slug,
    );
    $movie_query = new WP_Query($args);

    if ($movie_query->have_posts()) : while ($movie_query->have_posts()) : $movie_query->the_post();
        $episodes = get_post_meta(get_the_ID(), 'episode_list', true);
        $episodes = explode("\n", $episodes);

        $default_episode = !empty($episodes[0]) ? explode('|', $episodes[0])[1] : '#';
        $current_episode_url = isset($episodes[$tap_index]) ? explode('|', $episodes[$tap_index])[1] : $default_episode;
        $current_episode_name = isset($episodes[$tap_index]) ? explode('|', $episodes[$tap_index])[0] : 'Tập 1';
    ?>
        <div class="xem-phim-content">
            <h2 class="cat-title"><?php the_title(); ?> - <?php echo esc_html($current_episode_name); ?></h2>
            
            <div class="movie-player">
                <div class="loading-overlay">
                <svg alt="Loading" class="loading-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>
                </div>

                <!-- Tùy thuộc vào định dạng video, chọn player phù hợp -->
                <?php
                $is_m3u8 = strpos($current_episode_url, '.m3u8') !== false;
                $is_mpd = strpos($current_episode_url, '.mpd') !== false;
                $is_mp4 = strpos($current_episode_url, '.mp4') !== false;
                $is_iframe = strpos($current_episode_url, 'player.phimapi.com/player/') !== false; // Xác định URL iframe đặc biệt

                if ($is_mp4): ?>
                    <video controls>
                        <source src="<?php echo esc_url($current_episode_url); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php elseif ($is_m3u8 && !$is_iframe): ?>
                    <video id="video" controls></video>
                    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
                    <script>
                        if(Hls.isSupported()) {
                            var video = document.getElementById('video');
                            var hls = new Hls();
                            hls.loadSource('<?php echo esc_url($current_episode_url); ?>');
                            hls.attachMedia(video);
                            hls.on(Hls.Events.MANIFEST_PARSED,function() {
                                video.play();
                            });
                        }
                    </script>
                <?php elseif ($is_mpd): ?>
                    <video id="video" controls></video>
                    <script src="https://cdn.jsdelivr.net/npm/dashjs@latest/dist/dash.all.min.js"></script>
                    <script>
                        var video = document.getElementById('video');
                        var player = dashjs.MediaPlayer().create();
                        player.initialize(video, '<?php echo esc_url($current_episode_url); ?>', true);
                    </script>
                <?php elseif ($is_iframe): ?>
                    <iframe src="<?php echo esc_url($current_episode_url); ?>" frameborder="0" allowfullscreen></iframe>
                <?php else: ?>
                    <iframe src="<?php echo esc_url($current_episode_url); ?>" frameborder="0" allowfullscreen></iframe>
                <?php endif; ?>
            </div>

            <div class="action-bar">
    <button aria-label="Like" class="btns like-btn" data-action="like">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg> Like <span class="count"><?php echo esc_html( get_post_meta( get_the_ID(), '_likes_count', true ) ); ?></span>
    </button>
    <button aria-label="Dislike" class="btns dislike-btn" data-action="dislike">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg> Dislike <span class="count"><?php echo esc_html( get_post_meta( get_the_ID(), '_dislikes_count', true ) ); ?></span>
    </button>
    <button aria-label="Share" class="btns share-btn" data-action="share">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg> Share <span class="count"><?php echo esc_html( get_post_meta( get_the_ID(), '_shares_count', true ) ); ?></span>
    </button>
</div>

        <div class="episode-list">
            <h2>Danh Sách Tập Phim</h2>
            <ul>
                <?php foreach ($episodes as $index => $episode) :
                    $parts = explode('|', $episode); // Tách tên tập và URL
                    $episode_name = $parts[0];
                    ?>
                    <li>
                        <a href="<?php echo esc_url(add_query_arg('tap', $index + 1)); ?>">
                            <?php echo esc_html($episode_name); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        </div>
    <?php endwhile; else: ?>
        <p>Phim không tìm thấy.</p>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>

    <?php get_template_part("template-parts/related-movies"); ?>
</div>

<?php get_template_part("template-parts/side-bar"); ?>
<?php get_footer(); ?>
