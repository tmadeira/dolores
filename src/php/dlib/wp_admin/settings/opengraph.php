<?php
class DoloresOGSettings {
  public static function admin_init() {
    add_settings_section(
      'dolores_og',
      'Compartilhamento no Facebook',
      array('DoloresOGSettings', 'section_info'),
      'dolores'
    );

    add_settings_field(
      'dolores_og_author_name',
      'Nome do autor',
      array('DoloresOGSettings', 'render_og_author_name'),
      'dolores',
      'dolores_og'
    );
    add_settings_field(
      'dolores_og_author_url',
      'URL do autor',
      array('DoloresOGSettings', 'render_og_author_url'),
      'dolores',
      'dolores_og'
    );

    register_setting('dolores', 'dolores_og_author_name');
    register_setting('dolores', 'dolores_og_author_url');
  }

  public static function section_info() {
    ?>
    Use esta seção para configurar como links do site devem aparecer quando
    compartilhados em Facebook e outros sites que usam o protocolo OpenGraph.
    <?php
  }

  public static function render_og_author_name() {
    $value = get_option('dolores_og_author_name');
    ?>
    <input
      type="text"
      class="regular-text"
      id="dolores_og_author_name"
      name="dolores_og_author_name"
      placeholder="exemplo: Se a cidade fosse nossa"
      value="<?php echo $value; ?>"
      />
    <?php
  }

  public static function render_og_author_url() {
    $value = get_option('dolores_og_author_url');
    ?>
    <input
      type="text"
      class="regular-text"
      id="dolores_og_author_url"
      name="dolores_og_author_url"
      placeholder="exemplo: http://facebook.com/seacidadefossenossa"
      value="<?php echo $value; ?>"
      />
    <?php
  }

  public static function get_author_name() {
    return get_option('dolores_og_author_name');
  }

  public static function get_author_url() {
    return get_option('dolores_og_author_url');
  }
};
