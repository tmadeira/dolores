<?php
class DoloresAdminTaxonomy {
  private $tema_fields = array(
    'image' => array(
        'label' => 'Imagem',
        'description' => 'Endereço da imagem que é usada como destaque deste ' .
                         'tema (aparece na página de temas, por exemplo).'
      ),
    'video' => array(
        'label' => 'Vídeo',
        'description' => 'ID do vídeo (YouTube) que vai aparecer neste tema.' .
                         '<br />' .
                         '<small>' .
                         '  Por exemplo, se o endereço do vídeo no YouTube é' .
                         '  http://www.youtube.com/watch?v=mRCEBA777TU, ' .
                         '  então o valor que você deve usar é ' .
                         '  <strong>mRCEBA777TU</strong>.' .
                         '</small>'
      ),
    'more' => array(
        'label' => 'Link para diagnóstico',
        'description' => 'Endereço do link do diagnóstico completo (para o ' .
                         'qual o usuário é redirecionado quando clica em ' .
                         '<strong>Ver diagnóstico</strong>).'
      )
  );

  public function __construct() {
    add_action('tema_edit_form_fields', array($this, 'tema_edit_form_fields'),
      10, 1);
    add_action('tema_add_form_fields', array($this, 'tema_add_form_fields'),
      10, 0);
    add_action('create_tema', array($this, 'tema_update_meta'), 10, 1);
    add_action('edit_tema', array($this, 'tema_update_meta'), 10, 1);
  }

  public function tema_update_meta($term_id) {
    foreach ($this->tema_fields as $name => $data) {
      update_term_meta($term_id, $name, $_POST[$name]);
    }
  }

  public function tema_add_form_fields() {
    foreach ($this->tema_fields as $name => $data) {
      ?>
      <div class="form-field term-<?php echo $name; ?>-wrap">
        <label for="tag-<?php echo $name; ?>">
          <?php echo $data['label'] ?>
        </label>
        <input
          name="<?php echo $name; ?>"
          id="tag-<?php echo $name; ?>"
          type="text"
          value=""
          size="40"
          />
        <p><?php echo $data['description']; ?></p>
      </div>
      <?php
    }
  }

  public function tema_edit_form_fields($term) {
    $values = array(
      'image' => get_term_meta($term->term_id, 'image', true),
      'video' => get_term_meta($term->term_id, 'video', true),
      'more' => get_term_meta($term->term_id, 'more', true)
    );

    foreach ($this->tema_fields as $name => $data) {
      ?>
      <tr class="form-field term-<?php echo $name; ?>-wrap">
        <th scope="row">
          <label for="<?php echo $name; ?>">
            <?php echo $data['label']; ?>
          </label>
        </th>
        <td>
          <input
            name="<?php echo $name; ?>"
            id="tag-<?php echo $name; ?>"
            type="text"
            value="<?php echo esc_attr($values[$name]); ?>"
            size="40"
            />
          <p class="description">
            <?php echo $data['description']; ?>
          </p>
        </td>
      </tr>
      <?php
    }
  }
}

if (is_admin()) {
  new DoloresAdminTaxonomy();
}
