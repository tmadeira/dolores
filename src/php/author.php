<?php
get_header();
$info = isset($_GET['author_name']) ? get_user_by('slug', $author_name) :
    get_userdata(intval($author));
?>

<main class="profile">
  <div class="wrap">
    <div class="profile-picture" style="background-image: url('https://scontent-gru1-1.xx.fbcdn.net/hphotos-xaf1/v/t1.0-9/10906253_775306259215602_5837899258610604724_n.jpg?oh=198c4ed2ff891f0b03ee43d8984b46c1&oe=56A85D84');">
    </div>

    <div class="profile-info">
      <h2 class="profile-name"><?php echo $info->display_name; ?></h2>
      <p class="profile-stats">
        <?php echo $wp_query->found_posts; ?> ideias
        &bullet;
        200 comentários
      </p>

      <h3 class="profile-data-title">Informações básicas</h3>
      <ul class="profile-data">
        <li><strong>Aniversário</strong> 8 de janeiro</li>
        <li><strong>Instituição de ensino</strong> UFF</li>
        <li><strong>Curso</strong> História</li>
      </dl>
    </div>
  </div>
</main>

<h2 class="author-grid-title">Ideias de <?php echo $info->display_name; ?></h3>

<?php
include(__DIR__ . '/grid-ideias.php');
?>

<?php
get_footer();
?>
