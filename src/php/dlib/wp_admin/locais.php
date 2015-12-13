<?php
class DoloresAdminLocal {
  private $local_fields = array(
      'active' => array(
          'label' => 'Local ativo?',
          'description' => 'Marque se esse local está aberto a debates.<br />' .
              '<strong>Esta opção não afeta tags.</strong>'
      ),
      'image' => array(
          'label' => 'Imagem',
          'description' => 'Endereço da imagem que é usada como destaque deste ' .
              'local.'
      ),
      'video' => array(
          'label' => 'Vídeo',
          'description' => 'ID do vídeo (YouTube) que vai aparecer neste local.' .
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
    add_action('local_edit_form_fields', array($this, 'local_edit_form_fields'),
        10, 1);
    add_action('local_add_form_fields', array($this, 'local_add_form_fields'),
        10, 0);
    add_action('create_local', array($this, 'local_update_meta'), 10, 1);
    add_action('edit_local', array($this, 'local_update_meta'), 10, 1);
  }

  public function local_update_meta($term_id) {
    foreach ($this->local_fields as $name => $data) {
      update_term_meta($term_id, $name, $_POST[$name]);
    }
  }

  public function local_add_form_fields() {
    foreach ($this->local_fields as $name => $data) {
      ?>
      <div class="form-field term-<?php echo $name; ?>-wrap">
        <label for="tag-<?php echo $name; ?>">
          <?php echo $data['label'] ?>
        </label>
        <input
            name="<?php echo $name; ?>"
            id="tag-<?php echo $name; ?>"
            type="<?php echo ($name === 'active') ? 'checkbox' : 'text'; ?>"
            value="<?php echo ($name === 'active') ? '1' : ''; ?>"
            size="40"
        />
        <p><?php echo $data['description']; ?></p>
      </div>
      <?php
    }
  }

  public function local_edit_form_fields($term) {
    $values = array(
        'active' => get_term_meta($term->term_id, 'active', true),
        'image' => get_term_meta($term->term_id, 'image', true),
        'video' => get_term_meta($term->term_id, 'video', true),
        'more' => get_term_meta($term->term_id, 'more', true)
    );

    foreach ($this->local_fields as $name => $data) {
      if ($name === 'active') {
        $value = 'value="1"';
        if ($values[$name]) {
          $value .= ' checked="checked"';
        }
      } else {
        $value = 'value="' . esc_attr($values[$name]) . '"';
      }
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
              type="<?php echo ($name === 'active') ? 'checkbox' : 'text'; ?>"
              <?php echo $value; ?>
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
  new DoloresAdminLocal();
}
