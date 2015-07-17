<?php
get_header();
?>

<section class="site-hero">
  <div id="react-hero-signup">
  </div>
</section>

<section class="site-presentation">
  <div class="wrap">
    <p>
      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua.
    </p>
  </div>
</section>

<section class="site-streaming">
  <div class="wrap">
    <iframe
        src="//youtube.com/embed/u-sbPpxxYpo?controls=0&amp;showinfo=0"
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
        ?>
        <li>
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
