<section id="category-tags">
  <h2 class="cat-title">Danh Mục</h2>

  <?php
  // Định nghĩa các taxonomy muốn hiển thị
  $desired_taxonomies = ['the_loai', 'quoc_gia'];

  // Duyệt qua từng taxonomy trong danh sách mong muốn
  foreach ($desired_taxonomies as $taxonomy_slug) {
      // Lấy tất cả các terms của taxonomy này
      $terms = get_terms([
          'taxonomy' => $taxonomy_slug,
          'hide_empty' => true, // Ẩn những terms không có bài viết
          'parent' => 0 // Chỉ lấy các terms cấp cao nhất (parent)
      ]);

      // Kiểm tra nếu tồn tại terms
      if ($terms && !is_wp_error($terms)) {
          echo '<ul class="tags-list">';
          echo '<li>' . esc_html(get_taxonomy($taxonomy_slug)->labels->singular_name) . ':</li>'; // Hiển thị tên của taxonomy

          // Duyệt qua từng term và hiển thị mục con
          foreach ($terms as $term) {
              echo '<li><a href="' . esc_url(get_term_link($term)) . '" rel="tag">' . esc_html($term->name) . '</a></li>';
              
              // Hiển thị các mục con của term hiện tại
              $child_terms = get_terms([
                  'taxonomy' => $taxonomy_slug,
                  'hide_empty' => true,
                  'parent' => $term->term_id
              ]);

              if ($child_terms && !is_wp_error($child_terms)) {
                  echo '<ul class="child-tags-list">';
                  foreach ($child_terms as $child_term) {
                      echo '<li><a href="' . esc_url(get_term_link($child_term)) . '" rel="tag">' . esc_html($child_term->name) . '</a></li>';
                  }
                  echo '</ul>';
              }
          }

          echo '</ul>';
      } else {
          echo '<ul class="tags-list">';
          echo '<li>' . esc_html(get_taxonomy($taxonomy_slug)->labels->singular_name) . ':</li>'; 
          echo '<li>Đang cập nhật...</li>';
          echo '</ul>';
      }
  }
  ?>
</section>
