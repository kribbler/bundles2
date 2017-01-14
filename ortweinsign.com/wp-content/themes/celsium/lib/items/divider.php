<table class="form-table items" border="0">
<tbody>
    <tr valign="top">
       <th><?php print __('Divider title', $domain); ?></th>
       <td><?php print afl_render_theme_option("{$type}-title", array('type' => 'text', 'default_value' => $data["{$type}_title"], 'attributes' => array('class' => 'regular-text', 'name' => "{$type}_title"))); ?></td>
    </tr>
</tbody>
</table>
