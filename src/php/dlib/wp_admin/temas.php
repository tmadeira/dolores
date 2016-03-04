<?php
class DoloresAdminTema {
  private $tema_fields = array(
    'active' => array(
        'label' => 'Tema ativo?',
        'description' => 'Marque se esse tema está aberto a debates.<br />' .
                         '<strong>Esta opção não afeta subtemas/tags.</strong>',
        'hide' => DOLORES_TEMPLATE === 'cam'
      ),
    'image' => array(
        'label' => 'Imagem',
        'description' => 'Endereço da imagem que é usada como destaque deste ' .
                         'tema (aparece na página de temas, por exemplo).'
      ),
    'credit' => array(
        'label' => 'Créditos da imagem',
        'description' => 'Exemplo: Guilherme Prado/Nexo',
        'hide' => DOLORES_TEMPLATE !== 'cam'
      ),
    'outline' => array(
        'label' => 'Ideias iniciais',
        'description' => 'Itens que aparecem acima do formulário na página ' .
                         'do tema.',
        'hide' => DOLORES_TEMPLATE !== 'cam'
      ),
    'video' => array(
        'label' => 'Vídeo',
        'description' => 'ID do vídeo (YouTube) que vai aparecer neste tema.' .
                         '<br />' .
                         '<small>' .
                         '  Por exemplo, se o endereço do vídeo no YouTube é' .
                         '  https://youtube.com/watch?v=mRCEBA777TU, ' .
                         '  então o valor que você deve usar é ' .
                         '  <strong>mRCEBA777TU</strong>.' .
                         '</small>',
        'hide' => DOLORES_TEMPLATE === 'cam'
      ),
    'more' => array(
        'label' => 'Link para diagnóstico',
        'description' => 'Endereço do link do diagnóstico completo (para o ' .
                         'qual o usuário é redirecionado quando clica em ' .
                         '<strong>Ver diagnóstico</strong>).',
        'hide' => DOLORES_TEMPLATE === 'cam'
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

  public function add_active_field($data) {
    if ($data['hide']) {
      ?>
      <input type="hidden" name="active" value="1" />
      <?php
      return;
    }
    ?>
    <div class="form-field term-active-wrap">
      <label for="tag-active">
        <?php echo $data['label'] ?>
      </label>
      <input
        name="active"
        id="tag-active"
        type="checkbox"
        value="1"
        size="40"
        />
      <p><?php echo $data['description']; ?></p>
    </div>
    <?php
  }

  public function add_outline_field($data) {
    if ($data['hide']) {
      return;
    }
    ?>
    <div class="form-field term-outline-wrap">
      <label for="tag-outline">
        <?php echo $data['label'] ?>
      </label>
      <input
        name="outline[]"
        id="tag-outline"
        type="text"
        value=""
        size="40"
        />
      <input
        name="outline[]"
        type="text"
        value=""
        size="40"
        />
      <input
        name="outline[]"
        type="text"
        value=""
        size="40"
        />
      <p><?php echo $data['description']; ?></p>
    </div>
    <?php
  }

  public function tema_add_form_fields() {
    foreach ($this->tema_fields as $name => $data) {
      if ($name === 'active') {
        $this->add_active_field($data);
        continue;
      }

      if ($name === 'outline') {
        $this->add_outline_field($data);
        continue;
      }

      if ($data['hide']) {
        continue;
      }
      ?>
      <div class="form-field term-<?php echo $name; ?>-wrap">
        <label for="tag-<?php echo $name; ?>">
          <?php echo $data['label'] ?>
        </label>
        <input
          name="<?php echo $name; ?>"
          id="tag-<?php echo $name; ?>"
          type="text"
          size="40"
          />
        <p><?php echo $data['description']; ?></p>
      </div>
      <?php
    }
  }

  public function edit_active_field($data, $value) {
    if ($data['hide']) {
      ?>
      <input type="hidden" name="active" value="1" />
      <?php
      return;
    }

    if ($value) {
      $value = ' checked="checked"';
    }
    ?>
    <tr class="form-field term-active-wrap">
      <th scope="row">
        <label for="tag-active">
          <?php echo $data['label']; ?>
        </label>
      </th>
      <td>
        <input
          name="active"
          id="tag-active"
          type="checkbox"
          value="1"
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

  public function edit_outline_field($data, $value) {
    if ($data['hide']) {
      return;
    }
    ?>
    <tr class="form-field term-outline-wrap">
      <th scope="row">
        <label for="tag-outline">
          <?php echo $data['label']; ?>
        </label>
      </th>
      <td>
        <input
          name="outline[]"
          id="tag-outline"
          type="text"
          value="<?php esc_attr_e($value[0]); ?>"
          size="40"
          />
        <input
          name="outline[]"
          type="text"
          value="<?php esc_attr_e($value[1]); ?>"
          size="40"
          />
        <input
          name="outline[]"
          type="text"
          value="<?php esc_attr_e($value[2]); ?>"
          size="40"
          />
        <p class="description">
          <?php echo $data['description']; ?>
        </p>
      </td>
    </tr>
    <?php
  }

  public function tema_edit_form_fields($term) {
    foreach ($this->tema_fields as $name => $data) {
      $value = get_term_meta($term->term_id, $name, true);
      if ($name === 'active') {
        $this->edit_active_field($data, $value);
        continue;
      }

      if ($name === 'outline') {
        $this->edit_outline_field($data, $value);
        continue;
      }

      if ($data['hide']) {
        continue;
      }

      $value = 'value="' . esc_attr($value) . '"';
      ?>
      <tr class="form-field term-<?php echo $name; ?>-wrap">
        <th scope="row">
          <label for="tag-<?php echo $name; ?>">
            <?php echo $data['label']; ?>
          </label>
        </th>
        <td>
          <input
            name="<?php echo $name; ?>"
            id="tag-<?php echo $name; ?>"
            type="text"
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
  new DoloresAdminTema();
}
