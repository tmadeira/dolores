<?php
require_once(__DIR__ . '/dlib/interact.php');
require_once(__DIR__ . '/dlib/posts.php');

function dolores_ideia_comment($comment, $args, $depth) {
  echo DoloresPosts::get_comment_html($comment);
}
?>

<div id="comments">
  <div class="ideia-comments-header">
    <?php
    $interact = DoloresInteract::get_instance();
    list($up, $down) = $interact->get_post_votes($post->ID);
    $data = "href=\"#vote\" data-vote=\"post_id|{$post->ID}\"";
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
        <i class="post-comment-spinner fa fa-fw fa-lg fa-refresh fa-spin"></i>
        <textarea
          aria-required="true"
          class="comment-textarea"
          maxlength="600"
          name="text"
          placeholder="Escreva uma resposta"
          rows="1"
          ></textarea>
      </form>
    </li>
    <?php
    wp_list_comments(array(
      'callback' => 'dolores_ideia_comment'
    ));
    ?>
  </ul>
</div>
