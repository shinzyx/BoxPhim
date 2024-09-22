<?php
function sphim_breadcrumb() {
    if (!is_front_page()) {
        echo '<nav id="breadcrumb" aria-label="breadcrumb">';
        echo '<ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">';

        // Home link
        echo '<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<a href="' . esc_url(home_url('/')) . '" itemprop="item">';
        echo '<span itemprop="name">' . esc_html__('Home', 'sphim') . '</span>';
        echo '</a>';
        echo '<meta itemprop="position" content="1" />';
        echo '</li>';

        $position = 2;

        if (is_category() || is_single()) {
            $category = get_the_category();
            if ($category) {
                // Category link
                $category_link = get_category_link($category[0]->term_id);
                echo '<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                echo '<a href="' . esc_url($category_link) . '" itemprop="item">';
                echo '<span itemprop="name">' . esc_html($category[0]->name) . '</span>';
                echo '</a>';
                echo '<meta itemprop="position" content="' . esc_attr($position) . '" />';
                echo '</li>';
                $position++;
            }

            if (is_single()) {
                // Single post title
                echo '<li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                echo '<span itemprop="name">' . esc_html(get_the_title()) . '</span>';
                echo '<meta itemprop="position" content="' . esc_attr($position) . '" />';
                echo '</li>';
            }
        } elseif (is_page()) {
            if ($post->post_parent) {
                // Parent pages
                $anc = get_post_ancestors($post->ID);
                $anc = array_reverse($anc);
                foreach ($anc as $ancestor) {
                    echo '<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                    echo '<a href="' . esc_url(get_permalink($ancestor)) . '" itemprop="item">';
                    echo '<span itemprop="name">' . esc_html(get_the_title($ancestor)) . '</span>';
                    echo '</a>';
                    echo '<meta itemprop="position" content="' . esc_attr($position) . '" />';
                    echo '</li>';
                    $position++;
                }
            }
            // Current page title
            echo '<li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<span itemprop="name">' . esc_html(get_the_title()) . '</span>';
            echo '<meta itemprop="position" content="' . esc_attr($position) . '" />';
            echo '</li>';
        } elseif (is_search()) {
            // Search results
            echo '<li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<span itemprop="name">' . sprintf(esc_html__('Search Results for: %s', 'sphim'), get_search_query()) . '</span>';
            echo '<meta itemprop="position" content="' . esc_attr($position) . '" />';
            echo '</li>';
        } elseif (is_404()) {
            // 404 page
            echo '<li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<span itemprop="name">' . esc_html__('404 - Not Found', 'sphim') . '</span>';
            echo '<meta itemprop="position" content="' . esc_attr($position) . '" />';
            echo '</li>';
        }

        echo '</ol>';
        echo '</nav>';
    }
}
