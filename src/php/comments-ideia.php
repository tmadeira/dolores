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

    <span class="social-media">
      <span class="ideia-share">Compartilhe:</span>
      <div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
      <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-lang="pt"></a>
    </span>
  </div>

  <ul class="ideia-comments-list">
    <?php
    wp_list_comments(array(
      'callback' => 'dolores_ideia_comment'
    ));
    ?>
    <li class="ideia-comment ideia-comment-form-container" id="respond">
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
      <form class="ideia-comment-form">
        <div class="ideia-comment-picture-container">
          <span class="user-logged-picture"<?php echo $style; ?>></span>
        </div>
        <input type="hidden" name="post_id" value="<?php echo $post->ID; ?>" />
        <input type="hidden" name="parent" value="0" />
        <textarea
          aria-required="true"
          class="comment-textarea"
          name="text"
          placeholder="Escreva uma resposta"
          rows="1"
          ></textarea>
      </form>
    </li>
  </ul>
</div>
