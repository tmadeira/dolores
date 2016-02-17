<?php
the_post();
get_header();
?>

<main class="wrap default-wrap">
  <article class="single-content">
    <h2 class="single-title">
      Página não encontrada
    </h2>

    <div class="entry">
      <p>
        A página que você está buscando não foi encontrada no servidor. Ela
        pode ter sido removida, ter mudado de endereço ou estar temporariamente
        indisponível.
      </p>

      <p>
        Se você acredita que esse erro não deveria ter ocorrido, por favor
        <a href="/contato">entre em contato</a>.
      </p>
    </div>
  </article>

  <?php
  get_sidebar();
  ?>
</main>

<?php
get_footer();
?>
