<?php
get_header();
$info = get_userdata(intval($author));
?>

<main class="page profile">
  <div class="wrap">
    <div class="profile-picture" style="background-image: url('https://scontent-gru1-1.xx.fbcdn.net/hphotos-xaf1/v/t1.0-9/10906253_775306259215602_5837899258610604724_n.jpg?oh=198c4ed2ff891f0b03ee43d8984b46c1&oe=56A85D84');">
    </div>

    <div class="profile-info">
      <h2 class="profile-name">Felipe Aveiro</h2>
      <p class="profile-stats">15 ideias &bullet; 200 comentários</p>

      <h3 class="profile-data-title">Informações básicas</h3>
      <ul class="profile-data">
        <li><strong>Aniversário</strong> 8 de janeiro</li>
        <li><strong>Instituição de ensino</strong> UFF</li>
        <li><strong>Curso</strong> História</li>
      </dl>
    </div>
  </div>
</main>

<?php
include(__DIR__ . '/grid-ideias.php');
?>

<?php
get_footer();
?>
