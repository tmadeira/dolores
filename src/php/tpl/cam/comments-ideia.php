<?php
require_once(DOLORES_PATH . '/dlib/interact.php');
require_once(DOLORES_PATH . '/dlib/posts.php');
require_once(DOLORES_PATH . '/dlib/wp_util/user_meta.php');

function dolores_ideia_comment($comment, $args, $depth) {
  echo DoloresPosts::get_comment_html($comment);
}
?>

<div id="comments">
  <div class="ideia-comments-header">
    <?php
    $interact = DoloresInteract::get_instance();
    list($up, $down, $voted) = $interact->get_post_votes($post->ID);
    $data = "href=\"#vote\" data-vote=\"post_id|{$post->ID}\"";
    $upvoted = $downvoted = "";
    if ($voted === "up") {
      $upvoted = " voted";
    } else if ($voted === "down") {
      $downvoted = " voted";
    }
    ?>
    <a
        class="ideia-action ideia-upvote<?php echo $upvoted; ?>"
        <?php echo $data; ?>
        >
      <i class="fa fa-fw fa-lg fa-thumbs-up"></i>
      <span class="number"><?php echo $up; ?></span>
    </a>
    <a
        class="ideia-action ideia-downvote<?php echo $downvoted; ?>"
        <?php echo $data; ?>
        >
      <i class="fa fa-fw fa-lg fa-thumbs-down"></i>
      <span class="number"><?php echo $down; ?></span>
    </a>

    <?php dolores_print_share_buttons(); ?>
  </div>

  <ul class="ideia-comments-list">
    <li class="ideia-comment ideia-comment-form-container" id="respond">
      <?php
      if (is_user_logged_in()) {
        $user = wp_get_current_user();
        $picture = dolores_get_profile_picture($user);
      } else {
        $hash = md5("nobody");
        $picture = "//gravatar.com/avatar/$hash?d=mm&s=300";
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
      'callback' => 'dolores_ideia_comment',
      'reverse_children' => true,
      'reverse_top_level' => true
    ));
    ?>
  </ul>
</div>
