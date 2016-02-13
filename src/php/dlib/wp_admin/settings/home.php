<?php
class DoloresHome {
  public static function admin_init() {
    add_settings_section(
      'dolores_home',
      'Página inicial',
      array('DoloresHome', 'section_info'),
      'dolores'
    );

    add_settings_field(
      'dolores_home_tema',
      'Tema em destaque',
      array('DoloresHome', 'render_tema'),
      'dolores',
      'dolores_home'
    );

    add_settings_field(
      'dolores_home_ideias',
      'Ideias em destaque',
      array('DoloresHome', 'render_ideias'),
      'dolores',
      'dolores_home'
    );

    // TODO: add validation
    register_setting('dolores', 'dolores_home_tema');

    register_setting(
      'dolores',
      'dolores_home_ideias',
      array('DoloresHome', 'sanitize_ideias')
    );
  }

  public static function section_info() {
    ?>
    Use esta seção para configurar o conteúdo que aparece na página inicial do
    site.
    <?php
  }

  public static function render_tema() {
    $value = get_option('dolores_home_tema');
    ?>
    <input
      type="text"
      class="regular-text"
      id="dolores_home_tema"
      name="dolores_home_tema"
      placeholder="exemplo: cultura"
      value="<?php echo $value; ?>"
      />
    <p class="description">
      Use o nome do tema conforme aparece no seu link permanente. Por exemplo,
      escreva <strong>cidades-colaborativas</strong> se a página do tema for
      seacidadefossenossa.com.br/temas/cidades-colaborativas/.
    </p>
    <?php
  }

  public static function render_ideias() {
    $value = get_option('dolores_home_ideias');
    for ($i = 0; $i < count($value); $i++) {
      if ($value[$i]) {
        $value[$i] = get_post($value[$i])->post_name;
      }
    }

    for ($i = 0; $i < 3; $i++) {
      if ($i != 0) {
        echo "<br />";
      }
      ?>
      <input
        type="text"
        class="regular-text"
        id="dolores_home_ideia"
        name="dolores_home_ideias[]"
        placeholder="exemplo: criar-curso-publico-de-programacao"
        value="<?php echo $value[$i]; ?>"
        />
      <?php
    }
    ?>
    <p class="description">
      Use o nome da ideia conforme aparece no seu link permanente. Por exemplo,
      escreva <strong>criar-curso-publico-de-programacao</strong> se a página
      da ideia for
      seacidadefossenossa.com.br/ideia/criar-curso-publico-de-programacao/.
    </p>
    <?php
  }

  public static function sanitize_ideias($ideias) {
    global $wpdb;
    // XXX: This will be deprecated by WP 4.4 (post__name_in filter)
    for ($i = 0; $i < count($ideias); $i++) {
      $ideias[$i] = trim($ideias[$i]);
      if ($ideias[$i]) {
        $slug = mysql_real_escape_string($ideias[$i]);
        $sql = "SELECT ID FROM {$wpdb->posts} WHERE post_name = '$slug'";
        $ideias[$i] = $wpdb->get_var($sql);
      }
    }
    return $ideias;
  }

  public static function get_tema() {
    return get_option('dolores_home_tema');
  }

  public static function get_ideias() {
    return get_option('dolores_home_ideias');
  }
};
