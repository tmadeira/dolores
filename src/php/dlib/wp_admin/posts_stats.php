<?php
require_once(DOLORES_PATH . '/dlib/interact.php');
require_once(DOLORES_PATH . '/dlib/posts.php');

class DoloresPostsStats {
  public function __construct() {
    add_action('admin_menu', array($this, 'add_page'));
  }

  public function add_page() {
    add_submenu_page(
      'edit.php?post_type=ideia',
      'Relatório',
      'Relatório',
      'edit_posts',
      'dolores_posts_stats',
      array($this, 'create_admin_page')
    );
  }

  private function get_posts_info($query, $days) {
    // TODO: Move constant elsewhere.
    $seconds_per_day = 86400;

    $posts = array();
    while ($query->have_posts()) {
      $query->the_post();

      list($cat) = DoloresPosts::get_post_terms(get_the_ID());

      $interact = DoloresInteract::get_instance();
      list($up, $down) = $interact->get_post_votes(get_the_ID(), $days);

      $comments = get_comments(array(
        'date_query' => array(
          'after' => date('Y-m-d', time() - $days * $seconds_per_day),
          'inclusive' => true
        ),
        'post_id' => get_the_ID()
      ));

      $posts[] = array(
        'link' => get_permalink(),
        'title' => get_the_title(),
        'author_link' => get_author_posts_url(get_the_author_meta('ID')),
        'author' => get_the_author(),
        'datetime' => get_the_time('U'),
        'taxonomy_link' => $cat ? get_term_link($cat, $cat->taxonomy) : '',
        'taxonomy' => $cat->name,
        'up_votes' => $up,
        'down_votes' => $down,
        'comments' => count($comments)
      );
    }
    return $posts;
  }

  private function get_table_posts($days, $include, $orderby) {
    // TODO: Move constants elsewhere.
    $infinity = 4096;
    $seconds_per_day = 86400;

    $recent_query = new WP_Query(array(
      'date_query' => array(
        'after' => date('Y-m-d', time() - $days * $seconds_per_day),
        'inclusive' => true
      ),
      'posts_per_page' => $infinity,
      'post__not_in' => $include,
      'post_type' => 'ideia'
    ));

    $include_query = new WP_Query(array(
      'post__in' => $include,
      'posts_per_page' => $infinity,
      'post_type' => 'ideia'
    ));

    $posts = array_merge(
      $this->get_posts_info($recent_query, $days),
      $this->get_posts_info($include_query, $days)
    );

    $cmp = function($a, $b) {
      global $_GET;
      $orderby = 'datetime';
      if (array_key_exists('orderby', $_GET)) {
        $orderby = $_GET['orderby'];
      }

      if ($orderby == 'title' || $orderby == 'author' || $orderby == 'taxonomy') {
        return strnatcasecmp($a[$orderby], $b[$orderby]);
      }

      if ($a[$orderby] < $b[$orderby]) {
        return 1;
      } else if ($a[$orderby] > $b[$orderby]) {
        return -1;
      }
      return 0;
    };

    usort($posts, $cmp);
    return $posts;
  }

  public function print_table($days, $orderby = 'date') {
    $print_label = function($name, $field) {
      $current = 'datetime';
      if (preg_match('/orderby=([^&]*)/', $_SERVER['REQUEST_URI'], $match)) {
        $current = $match[1];
      }

      $uri = preg_replace('/orderby=[^&]*/', '', $_SERVER['REQUEST_URI']);
      $link = $uri . '&orderby=' . $field;

      $current_icon = '';
      if ($current == $field) {
        $symbol = 'down';
        if ($current == 'title' || $current == 'author' || $current== 'taxonomy') {
          $symbol = 'up';
        }
        $current_icon = ' <i class="fa fa-chevron-' . $symbol . '"></i>';
      }

      if ($current_icon == '') {
        ?>
        <a href="<?php echo $link; ?>">
        <?php
      }
      echo $name . $current_icon;
      if ($current_icon == '') {
        ?>
        </a>
        <?php
      }
    };
    ?>
    <table class="wp-list-table widefat striped">
      <thead>
        <tr>
          <th class="left">
            <?php $print_label('Título', 'title'); ?>
          </th>
          <th class="left">
            <?php $print_label('Autor', 'author'); ?>
          </th>
          <th class="left">
            <?php $print_label('Data/Horário', 'datetime'); ?>
          </th>
          <th class="left">
            <?php $print_label('Tema/Bairro', 'taxonomy'); ?>
          </th>
          <th>
            <?php $print_label('<i class="fa fa-thumbs-up"></i>', 'up_votes'); ?>
          </th>
          <th>
            <?php $print_label('<i class="fa fa-thumbs-down"></i>', 'down_votes'); ?>
          </th>
          <th>
            <?php $print_label('<i class="fa fa-comments"></i>', 'comments'); ?>
          </th>
        </tr>
      </thead>
      <tbody>
        <?php
        $interact = DoloresInteract::get_instance();
        $interacted = $interact->get_recent_interacted_posts($days);

        $comments = get_comments(array(
          'date_query' => array(
            'after' => date('Y-m-d', time() - $days * $seconds_per_day),
            'inclusive' => true
          )
        ));
        $commented = array();
        foreach ($comments as $comment) {
          $commented[] = $comment->comment_post_ID;
        }

        $include = array_unique(array_merge($interacted, $commented));
        $posts = $this->get_table_posts($days, $include, $orderby);
        foreach ($posts as $post) {
          ?>
          <tr>
            <td>
              <a href="<?php echo $post['link']; ?>">
                <strong><?php echo $post['title']; ?></strong>
              </a>
            </td>
            <td>
              <a href="<?php echo $post['author_link']; ?>">
                <?php echo $post['author']; ?>
              </a>
            </td>
            <td>
              <?php echo date('d/m/Y H:i', $post['datetime']); ?>
            </td>
            <td>
              <a href="<?php echo $post['taxonomy_link']; ?>">
                <?php echo $post['taxonomy']; ?>
              </a>
            </td>
            <td>
              <?php echo $post['up_votes']; ?>
            </td>
            <td>
              <?php echo $post['down_votes']; ?>
            </td>
            <td>
              <?php echo $post['comments']; ?>
            </td>
          </tr>
          <?php
        }
        ?>
      </tbody>
    </table>
    <?php
  }

  public function create_admin_page() {
    global $_GET;
    ?>
    <div class="wrap">
      <h2>Relatório da interação</h2>

      <ul class="subsubsub">
        <?php
        $days = array_key_exists('days', $_GET) ? $_GET['days'] : 7;

        $options = array(7, 15, 30, 60, 365);
        foreach ($options as $option) {
          $uri = preg_replace('/days=[^&]*/', '', $_SERVER['REQUEST_URI']);
          $link = $uri . '&days=' . $option;
          $current = '';
          if ($option == $days) {
            $current = ' class="current"';
          }
          ?>
          <li>
            <a href="<?php echo $link; ?>"<?php echo $current; ?>>
              Últimos <?php echo $option; ?> dias
            </a>
            <?php if ($option != $options[count($options)-1]) { echo '|'; } ?>
          </li>
          <?php
        }
        ?>
      </ul>

      <?php
      $this->print_table($days);
      ?>
    </div>
    <?php
  }
};

if (is_admin()) {
  new DoloresPostsStats();
}
