<?php
require_once(__DIR__ . '/dlib/interact.php');

function dolores_ideia_comment($comment, $args, $depth) {
  $interact = DoloresInteract::get_instance();
  list($up, $down) = $interact->get_comment_votes($comment->comment_ID);
  $data = "href=\"#\" data-vote=\"comment_id|{$comment->comment_ID}\"";
  ?>
  <li class="ideia-comment" id="comment-<?php echo $comment->comment_ID; ?>">
    <div class="ideia-comment-table">
      <?php
      $user = get_user_by('id', $comment->user_id);
      $id = get_the_author_meta('ID');
      require_once(__DIR__ . '/dlib/wp_util/user_meta.php');
      $picture = dolores_get_profile_picture($user);
      $style = ' style="background-image: url(\'' . $picture. '\');"';
      $url = get_author_posts_url(get_the_author_meta('ID'));
      ?>
      <a href="<?php echo $url; ?>" class="ideia-comment-picture">
        <span class="grid-ideia-author-picture" <?php echo $style; ?>>
        </span>
      </a>
      <div class="ideia-comment-block">
        <div class="ideia-comment-text">
          <span class="ideia-comment-author">
            <a href="<?php echo $url; ?>">
              <?php echo $user->display_name; ?>
            </a>
          </span>
          <span class="ideia-comment-content">
            <?php echo $comment->comment_content; ?>
          </span>
        </div>
        <div class="ideia-comment-meta">
          <a class="ideia-comment-action ideia-upvote" <?php echo $data; ?>>
            <i class="fa fa-fw fa-lg fa-thumbs-up"></i>
            <span class="number"><?php echo $up; ?></span>
          </a>
          <a class="ideia-comment-action ideia-downvote" <?php echo $data; ?>>
            <i class="fa fa-fw fa-lg fa-thumbs-down"></i>
            <span class="number"><?php echo $down; ?></span>
          </a>
          <a class="ideia-comment-action ideia-comment-reply" href="#">
            <i class="fa fa-fw fa-lg fa-comments"></i> Responder
          </a>
          <span class="ideia-comment-date">
            <?php echo get_comment_date(); ?>
            às
            <?php echo get_comment_time(); ?>
          </span>
        </div>
      </div>
    </div>
  <?php
}
?>

<div id="comments">
  <div class="ideia-comments-header">
    <?php
    $interact = DoloresInteract::get_instance();
    list($up, $down) = $interact->get_post_votes($post->ID);
    $data = "href=\"#\" data-vote=\"post_id|{$post->ID}\"";
    ?>
    <a class="ideia-action ideia-upvote" <?php echo $data; ?>>
      <i class="fa fa-fw fa-lg fa-thumbs-up"></i>
      <span class="number"><?php echo $up; ?></span>
    </a>
    <a class="ideia-action ideia-downvote" <?php echo $data; ?>>
      <i class="fa fa-fw fa-lg fa-thumbs-down"></i>
      <span class="number"><?php echo $down; ?></span>
    </a>
  </div>

  <ul class="ideia-comments-list">
    <?php
    wp_list_comments(array(
      'callback' => 'dolores_ideia_comment'
    ));
    ?>
  </ul>

  <?php
  if (is_user_logged_in()) {
    $user = wp_get_current_user();
    require_once(__DIR__ . '/dlib/wp_util/user_meta.php');
    $picture = dolores_get_profile_picture($user);
  } else {
    $hash = md5("nobody");
    $picture = "http://gravatar.com/avatar/$hash?d=mm&s=300";
  }
  $style = ' style="background-image: url(\'' . $picture. '\');"';
  ?>

  <div class="ideia-comment-form-container" id="respond">
    <div class="ideia-comment-form">
      <div class="ideia-comment-picture-container">
        <span class="user-logged-picture"<?php echo $style; ?>></span>
      </div>
      <textarea
        aria-required="true"
        id="comment"
        name="comment"
        placeholder="Escreva uma resposta"
        ></textarea>
    </div>
  </div>
</div>
