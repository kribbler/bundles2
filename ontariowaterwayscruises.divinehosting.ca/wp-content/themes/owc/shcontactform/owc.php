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
	cfinput('text','Name','required name');
}
cfinput('text','Email','required email','data-match="email"');
if ($phone) {
	cfinput('text','Phone Number','phone','','Phone');
}

if ($subject || !empty($_REQUEST['subject'])) {
	cfinput('text','Nature of Enquiry','subject','value="'.req('subject').'"');
}

	cfinput('textarea','Message','required message');
?>
</div>
<div class="submit">
<input type="submit" value="Submit &gt;" class="btn"/>
</div>

<?php
if (!empty($posthtml))
	echo '<div class="posthtml">',$posthtml,'</div>';
