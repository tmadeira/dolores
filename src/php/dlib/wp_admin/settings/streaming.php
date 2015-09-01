<?php
class DoloresStreaming {
  public static function admin_init() {
    add_settings_section(
      'dolores_streaming',
      'Transmissão ao vivo',
      array('DoloresStreaming', 'section_info'),
      'dolores'
    );

    add_settings_field(
      'dolores_streaming_active',
      'Transmissão ativa',
      array('DoloresStreaming', 'render_active'),
      'dolores',
      'dolores_streaming'
    );

    add_settings_field(
      'dolores_streaming_title',
      'Título',
      array('DoloresStreaming', 'render_title'),
      'dolores',
      'dolores_streaming'
    );

    add_settings_field(
      'dolores_streaming_youtube_id',
      'ID do YouTube',
      array('DoloresStreaming', 'render_youtube_id'),
      'dolores',
      'dolores_streaming'
    );

    // TODO: add validation
    register_setting('dolores', 'dolores_streaming_active');
    register_setting('dolores', 'dolores_streaming_title');
    register_setting('dolores', 'dolores_streaming_youtube_id');
  }

  public static function section_info() {
    ?>
    Use esta seção para configurar a transmissão ao vivo de eventos na página
    inicial do site.
    <?php
  }

  public static function render_active() {
    $value = get_option('dolores_streaming_active');
    ?>
    <label>
      <input
        type="checkbox"
        id="dolores_streaming_active"
        name="dolores_streaming_active"
        value="1"
        <?php echo checked(1, $value, false) ?>
        />
      Marque para ativar a transmissão ao vivo na página inicial
    </label>
    <?php
  }

  public static function render_title() {
    $value = get_option('dolores_streaming_title');
    ?>
    <input
      type="text"
      class="regular-text"
      id="dolores_streaming_title"
      name="dolores_streaming_title"
      placeholder="exemplo: Ao vivo: Se Santa Teresa fosse nossa"
      value="<?php echo $value; ?>"
      />
    <p class="description">
      O título aparece em cima do vídeo na página inicial para que um visitante
      desavisado saiba do que se trata.
    </p>
    <?php
  }

  public static function render_youtube_id() {
    $value = get_option('dolores_streaming_youtube_id');
    ?>
    <input
      type="text"
      class="regular-text"
      id="dolores_streaming_youtube_id"
      name="dolores_streaming_youtube_id"
      placeholder="exemplo: mRCEBA777TU"
      value="<?php echo $value; ?>"
      />
    <p class="description">
      A plataforma suporta <strong>hangouts do Google</strong>. Para configurar
      uma transmissão ao vivo, você deve usar o ID dela no YouTube.
    </p>

    <p class="description"><small>
      Por exemplo, se o endereço de uma transmissão no YouTube é
      http://www.youtube.com/?watch=<strong>mRCEBA777TU</strong>, então o valor
      que você deve usar é <strong>mRCEBA777TU</strong>.
    </small></p>
    <?php
  }

  public static function get_active() {
    return get_option('dolores_streaming_active');
  }

  public static function get_title() {
    return get_option('dolores_streaming_title');
  }

  public static function get_youtube_id() {
    return get_option('dolores_streaming_youtube_id');
  }
};
