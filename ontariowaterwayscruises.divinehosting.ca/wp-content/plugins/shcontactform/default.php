<?php
if (!empty($title))
	echo '<h2>',$title,'</h2>';
if (!empty($prehtml))
	echo '<div class="prehtml">',$prehtml,'</div>';
?>
<div class="error"></div>
<div class="formobjects">
<?php
if ($sepname) { 
	cfinput('text','First','required firstname');
	cfinput('text','Last','required lastname');
} else {
	cfinput('text','Full Name','required name');
}
if ($phone) {
	cfinput('text','Phone (Optional)','phone','','Phone');
}
cfinput('text','Email','required email','data-match="email"');

if ($subject || !empty($_REQUEST['subject'])) {
	cfinput('text','Subject','subject','value="'.req('subject').'"');
}

	cfinput('textarea','Message','required message');
?>
</div>
<div class="submit">
<input type="submit" value="Send Message"/>
</div>

<?php
if (!empty($posthtml))
	echo '<div class="posthtml">',$posthtml,'</div>';
