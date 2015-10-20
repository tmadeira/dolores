<?php
require_once(__DIR__ . '/../assets.php');

require_once(__DIR__ . '/../wp_admin/settings/opengraph.php');

function dolores_add_opengraph() {
  $author_url = DoloresOGSettings::get_author_url();
  $author_name = DoloresOGSettings::get_author_name();

  $site_name = get_bloginfo('name');
  $image = DoloresAssets::get_image_uri('og-default.jpg');

  if (is_home()) {
    $description = get_bloginfo('description');
    $title = get_bloginfo('name');
    $type = 'website';
    $url = get_bloginfo('url');
  } else if (is_tax()) {
    $term = get_queried_object();
    $description = trim(strip_tags(category_description()));
    $title = single_cat_title('', false);
    $tax_img = get_term_meta($term->term_id, 'image', true);
    if ($tax_img) {
      $image = $tax_img;
    }
  } else if (is_author()) {
    global $_GET, $author;
    $info = isset($_GET['author_name']) ?
        get_user_by('slug', $_GET['author_name']) :
        get_userdata(intval($author));
    require_once(__DIR__ . '/user_meta.php');
    $picture = dolores_get_profile_picture($info);
    if ($picture) {
      $image = $picture;
    }
    $title = $info->display_name;
  } else if (is_single() || is_page()) {
    $tags = get_the_tags();
    if ($tags) {
      function dolores_get_tag_name($tag) {
        return $tag->name;
      }
      $keywords = implode(',', array_map('dolores_get_tag_name', $tags));
    }

    $description = get_the_excerpt();
    $title = get_the_title();
    $type = 'article';
    $url = get_permalink();

    if (has_post_thumbnail()) {
      list($image) = wp_get_attachment_image_src(
        get_post_thumbnail_id(get_the_ID()),
        apply_filters('post_thumbnail_size', 'post-thumbnail'),
        false
      );
    } else if (preg_match(
        '/<img[^>]+src=[\'"]([^\'"]+)[\'"]/i',
        get_the_content(),
        $matches)) {
      $image = $matches[1];
    } else if (get_post_type() === 'ideia') {
      $terms = get_the_terms($post->ID, 'tema');
      foreach ($terms as $term) {
        if ($term->parent == 0) {
          $tax_img = get_term_meta($term->term_id, 'image', true);
          if ($tax_img) {
            $image = $tax_img;
          }
          break;
        }
      }
    }

    $published = get_the_time('Y-m-d H:i:s');

    $categories = get_the_category();
    if ($categories) {
      foreach ($categories as $cat) {
        $section = $cat->name;
        break;
      }
    }

    if (get_post_type() === 'ideia') {
      $author_url = get_author_posts_url(get_the_author_meta('ID'));
      $author_name = get_the_author();
    }
  } else {
    $url = get_bloginfo('url') .
      preg_replace('/\?.*/', '', $_SERVER["REQUEST_URI"]);
  }

  $description = esc_attr($description);
  if ($description) {
    echo "<meta name='description' content='$description' />\n";
    echo "<meta property='og:description' content='$description' />\n";
  }

  $image = esc_attr($image);
  if ($image) {
    echo "<meta property='og:image' content='$image' />\n";
  }

  $keywords = esc_attr($keywords);
  if ($keywords) {
    echo "<meta name='keywords' content='$keywords' />\n";
  }

  $site_name = esc_attr($site_name);
  if ($site_name) {
    echo "<meta property='og:site_name' content='$site_name' />\n";
  }

  $title = esc_attr($title);
  if ($title) {
    echo "<meta property='og:title' content='$title' />\n";
  }

  $type = esc_attr($type);
  if ($type) {
    echo "<meta property='og:type' content='$type' />\n";
  }

  $published = esc_attr($published);
  if ($published) {
    echo "<meta property='article:published_time' content='$published' />\n";
  }

  $section = esc_attr($section);
  if ($section) {
    echo "<meta property='article:section' content='$section' />\n";
  }

  $url = esc_attr($url);
  if ($url) {
    echo "<meta property='og:url' content='$url' />\n";
  }

  echo "<meta property='article:author' content='$author_url' />\n";
  echo "<meta name='author' content='$author_name' />\n";

  if (defined('FACEBOOK_APP_ID')) {
    $fbAppID = FACEBOOK_APP_ID;
    echo "<meta property='fb:app_id' content='$fbAppID' />\n";
  }
}

add_action('wp_head', 'dolores_add_opengraph');
