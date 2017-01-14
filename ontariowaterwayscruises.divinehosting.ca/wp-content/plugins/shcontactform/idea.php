<?php
plugin('steps');
if (!empty($title))
	echo '<h2>',$title,'</h2>';
if (!empty($prehtml))
	echo '<div class="prehtml">',$prehtml,'</div>';
?>
<div class="error"></div>

<div id="steps">
<div class="step" data-step="1">
<h1>Step 1</h1>
<h2>Upload your completed Non-Disclosure Form</h2>
<div class="formobjects">
<?php cfinput('upload','NDA','required'); ?>
</div>
</div>

<div class="step" data-step="2">
<h1>Step 2</h1>
<h2>Tell us a little bit about your concept.</h2>
<div class="formobjects">
<?php cfinput('textarea','Type Text Here...','required','','About'); ?>
</div>
</div>

<div class="step" data-step="3">
<h1>Step 3</h1>
<h2>Just a little bit more info.</h2>
<div class="formobjects">
<?php
cfinput('text','Full Name','required name');
cfinput('text','Email','required name');
cfinput('text','Phone','required name');
cfinput('text','Location','required name');
?>
</div>
</div>

<div class="step" data-step="4">
<h1>Step 4</h1>
<h2>Please upload any additional documents</h2>
<div class="formobjects">
<?php
cfinput('upload','Documents','required multi');
?>
</div>
<div class="submit">
<input type="submit" value="Submit"/>
</div>
</div>

</div>
<?php
if (!empty($posthtml))
	echo '<div class="posthtml">',$posthtml,'</div>';
