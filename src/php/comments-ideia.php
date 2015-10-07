<?php
function dolores_ideia_comment($comment, $args, $depth) {
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
          <a class="ideia-comment-action ideia-upvote" href="#">
            <i class="fa fa-fw fa-lg fa-thumbs-up"></i>
            403
          </a>
          <a class="ideia-comment-action ideia-downvote" href="#">
            <i class="fa fa-fw fa-lg fa-thumbs-down"></i>
            2
          </a>
          <span class="ideia-comment-action">
            <?php
            $reply_text = '<i class="fa fa-fw fa-lg fa-comments"></i> 2';
            comment_reply_link(
              array_merge(
                $args,
                array(
                  'depth' => $depth,
                  'max_depth' => $args['max_depth'],
                  'reply_text' => $reply_text
                )
              )
            );
            ?>
          </span>
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
    <a class="ideia-action ideia-upvote" href="#">
      <i class="fa fa-fw fa-lg fa-thumbs-up"></i>
      403
    </a>
    <a class="ideia-action ideia-downvote" href="#">
      <i class="fa fa-fw fa-lg fa-thumbs-down"></i>
      2
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
    $style = ' style="background-image: url(\'' . $picture. '\');"';
    $comment_field = <<<HTML
    <div class="ideia-comment-form">
      <div class="ideia-comment-picture-container">
        <span class="user-logged-picture"${style}></span>
      </div>
      <textarea
        aria-required="true"
        id="comment"
        name="comment"
        placeholder="Escreva uma resposta"
        ></textarea>
    </div>
HTML;

    comment_form(array(
      'comment_field' => $comment_field
    ));
  } else {
    ?>
    <p style="padding: 20px;">
      TODO: Usuário não está loggado.
    </p>
    <?php
  }
  ?>
</div>
