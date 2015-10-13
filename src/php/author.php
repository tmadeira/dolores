<?php
get_header();
$info = isset($_GET['author_name']) ? get_user_by('slug', $author_name) :
    get_userdata(intval($author));

require_once(__DIR__ . '/dlib/wp_util/user_meta.php');
$picture = dolores_get_profile_picture($info);
$pic_style = ' style="background-image: url(\'' . $picture. '\');"';
?>

<main class="profile">
  <div class="wrap">
    <div class="profile-picture"<?php echo $pic_style; ?>>
    </div>

    <div class="profile-info">
      <h2 class="profile-name"><?php echo $info->display_name; ?></h2>
      <p class="profile-stats">
        <?php echo $wp_query->found_posts; ?> ideias
        &bullet;
        <?php echo dolores_get_comment_count_for_user($info); ?> respostas
      </p>

      <h3 class="profile-data-title">Informações pessoais</h3>
      <!-- TODO -->
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
require_once(__DIR__ . '/grid-ideias.php');
dolores_grid_ideias();
?>

<?php
get_footer();
?>
