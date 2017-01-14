<table class="form-table" class="items">
<tbody>
    <tr valign="top">
        <th><?php print __('Slogan title', $domain); ?></th>
        <td><?php print afl_render_theme_option("{$type}-title", array('type' => 'text', 'default_value' => $data["{$type}_title"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_title"))); ?></td>
    </tr>
    <tr valign="top">
        <th><?php print __('Slogan text', $domain); ?></th>
        <td><?php print afl_render_theme_option("{$type}-text", array('type' => 'textarea', 'default_value' => $data["{$type}_text"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_text"))); ?></td>
    </tr>
    <tr valign="top">
        <th><?php print __('Slogan button text', $domain); ?></th>
        <td><?php print afl_render_theme_option("{$type}-button-text", array('type' => 'text', 'default_value' => $data["{$type}_button_text"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_button_text"))); ?></td>
    </tr>

    <tr valign="top">
        <th><?php print __('Slogan button link', $domain); ?></th>
        <td><?php print afl_render_theme_option("{$type}-button-link", array('type' => 'text', 'default_value' => $data["{$type}_button_link"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_button_link"))); ?></td>
    </tr>
</tbody>
</table>
