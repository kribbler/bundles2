<?php $col_id = 0; $values = &$data; ?>
<div id="afl-edit-item-tabs-content<?php print $col_id; ?>" class="full-width">
    <div class="slide-item">
        <label for="<?php print "{$type}-title{$col_id}" ?>"><?php print __('Title', $domain); ?></label>
        <input id="<?php print "{$type}-title{$col_id}" ?>" type="text" name="<?php print "{$type}_title" ?>" value="<?php print $values["{$type}_title"] ?>" />

    </div>
    <div class="slide-item">
        <label for="<?php print "{$type}-number{$col_id}" ?>"><?php print __('How Many?', $domain); ?></label>
        <input id="<?php print "{$type}-number{$col_id}" ?>" type="text" name="<?php print "{$type}_number" ?>" value="<?php print $values["{$type}_number"] ?>" />

    </div>
</div>