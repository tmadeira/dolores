<?php
require_once(__DIR__ . '/../assets.php');
require_once(__DIR__ . '/../config.php');

function dolores_add_opengraph() {
  $site_name = get_bloginfo('name');
  $image = DoloresAssets::get_image_uri(DoloresConfig::ogDefaultImage);

  if (is_home()) {
    $description = get_bloginfo('description');
    $title = get_bloginfo('name');
    $type = 'website';
    $url = get_bloginfo('url');
  } else if (is_category()) {
    $description = category_description();
    $title = single_cat_title('', false);
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
    }

    $published = get_the_time('Y-m-d H:i:s');

    $categories = get_the_category();
    if ($categories) {
      foreach ($categories as $cat) {
        $section = $cat->name;
        break;
      }
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

  $author_url = DoloresConfig::ogAuthorUrl;
  $author = DoloresConfig::ogAuthorName;
  $fbAppID = DoloresConfig::facebookAppID;
  $fbAdmins = DoloresConfig::facebookAdmins;

  echo "<meta property='article:author' content='$author_url' />\n";
  echo "<meta name='author' content='$author' />\n";
  echo "<meta property='fb:app_id' content='$fbAppID' />\n";
  echo "<meta property='fb:admins' content='$fbAdmins' />\n";
}

add_action('wp_head', 'dolores_add_opengraph');
