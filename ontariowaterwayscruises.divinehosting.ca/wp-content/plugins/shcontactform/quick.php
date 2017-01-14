<div class="quick"><div>
<div class="text">
<?php
if (!empty($title))
	echo '<h2>',$title,'</h2>';
if (!empty($prehtml))
	echo '<div class="prehtml">',$prehtml,'</div>';
?>
</div>
<div class="formobjects">
<div class="error"></div>
<?php
cfinput('text','Full Name','required name');
cfinput('text','Email','required email','data-match="email"');
echo '<br/>';
cfinput('text','Message','required message','Query');
?>
</div>
<div class="submit">
<input type="submit" value="GO!"/>
</div>

<?php
if (!empty($posthtml))
	echo '<div class="posthtml">',$posthtml,'</div>';
?>
</div></div>
