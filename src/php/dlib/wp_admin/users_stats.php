<?php
class DoloresUsersStats {
  public function __construct() {
    add_action('admin_menu', array($this, 'add_page'));
  }

  public function add_page() {
    add_users_page(
      'Estatísticas',
      'Estatísticas',
      'edit_themes',
      'dolores_users_stats',
      array($this, 'create_admin_page')
    );
  }

  public function create_admin_page() {
    global $wpdb;

    $sql = <<<SQL
SELECT meta_value AS location, COUNT(user_id) AS count
  FROM {$wpdb->usermeta}
  WHERE meta_key = 'location'
  GROUP BY meta_value
  ORDER BY count DESC
SQL;

    $rows = $wpdb->get_results($sql);
    ?>
    <div class="wrap">
      <h2>Estatísticas dos usuários</h2>

      <h3>Número de usuários por localidade</h3>
      <table class="wp-list-table widefat striped">
        <thead>
          <tr>
            <th class="left">Localidade</th>
            <th>#</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($rows as $row) {
            echo "<tr>";
            echo "<td>{$row->location}</td>";
            echo "<td>{$row->count}</td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
    <?php
  }
};

if (is_admin()) {
  new DoloresUsersStats();
}
