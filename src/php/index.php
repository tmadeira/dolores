<?php
get_header();
?>

<section class="site-hero">
  <div id="react-hero-signup">
  </div>
</section>

<section class="site-presentation">
  <div class="wrap">
    <h3 class="presentation-title">Lorem ipsum dolor sit amet</h3>
    <p class="presentation-text">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua.
    </p>
  </div>
</section>

<section class="site-streaming">
  <div class="wrap">
    <iframe
        class="streaming-box"
        src="//youtube.com/embed/zE_I18HfeWM?controls=0&amp;showinfo=0"
        frameborder="0"
        allowfullscreen>
    </iframe>
  </div>
</section>

<section class="site-grid">
  <div class="wrap">
    <?php
    if (have_posts()) {
      echo '<ul>';
      while (have_posts()) {
        the_post();
        list($img_src) = wp_get_attachment_image_src(
          get_post_thumbnail_id($post->ID),
          'post-thumbnail'
        );
        $style = "background-image: url('$img_src');";
        ?>
        <li class="grid-post" style="<?php echo $style; ?>">
          <a href="<?php the_permalink(); ?>">
            <h3><?php the_title(); ?></h3>
          </a>
        </li>
        <?php
      }
      echo '</ul>';
    }
    ?>
  </div>
</section>

<?php
get_footer();
?>
