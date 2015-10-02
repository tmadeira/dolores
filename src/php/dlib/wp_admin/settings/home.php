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

    // TODO: add validation
    register_setting('dolores', 'dolores_home_tema');
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
      http://seacidadefossenossa.com.br/temas/cidades-colaborativas/.
    </p>
    <?php
  }

  public static function get_tema() {
    return get_option('dolores_home_tema');
  }
};
