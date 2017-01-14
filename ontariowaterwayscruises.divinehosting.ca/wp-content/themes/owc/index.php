<?php get_header(); ?>
<h1>Heading One</h1>
<h2>News from the shop.</h2>
<div class="news-feed">
	<div class="news-item">
		<h3>Happy Canada Day!!</h3>
		<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, ased diam nonumy...  <a href="#" class="read-more">More ></a></p>
		<span clas="date-posted">Posted: July 01 2015, @ 11:33 am via <a href="#" class="">Facebook</a></span>
	</div>
</div>
<p>A unique service proposition that speaks about the
	way that Bromley alleviates the pain experienced by
	the identified target audience. This section will lead
	the user into the section below that further explains
	the services they provide and offer.</p>

<p><input type="submit" value="Submit"></p>
<p><a href="#" class="button grey">View our reviews on Google+</a></p>
<p><a href="#" class="button white">Button One ></a></p>
<p><a href="#" class="button blue">Button Two ></a></p>
<p><input type="text" placeholder="Email"></p>
<select>
	<option>Option 1</option>
	<option>Option 2</option>
	<option>Option 3</option>
	<option>Option 4</option>
</select>
<div class="dropdown">
	<label>Please select a service</label>
	<input type="checkbox" checked="checked" id=""><label>Service One</label>
	<label><input type="checkbox">Service Two</label>
	<label><input type="checkbox">Service Three</label>
	<label><input type="checkbox">Service Four</label>
	<label><input type="checkbox">...</label>
</div>
<a href="#">Plain old link</a>
<?php
$dropdown_items = array(
	'Service One',
	'Service Two',
	'Service Three',
	'Service Four',
	'...');
dd_generate_dropdown($dropdown_items,'Service One', 'Please Select A Service');?>
<?php
get_footer();
