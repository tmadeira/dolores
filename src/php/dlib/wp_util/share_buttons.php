<?php
function dolores_print_share_buttons() {
  ?>
  <span class="social-buttons">
    <a class="social-button share-facebook"
        href="https://facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"
        target="_blank">
      <i class="fa fa-fw fa-lg fa-facebook"></i>
      Compartilhar
    </a>
    <a class="social-button share-twitter"
        href="https://twitter.com/share?text=<?php
            esc_attr_e(get_the_title());
            ?>&amp;url=<?php the_permalink(); ?>"
        target="_blank">
      <i class="fa fa-fw fa-lg fa-twitter"></i>
      Tuitar
    </a>
  </span>
  <?php
}
