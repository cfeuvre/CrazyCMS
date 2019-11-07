<!-- BEGIN text -->
	<br /><br />
	{text.TXT}
	<br /><br />
	<a href="index.php?mods=livre_dor">
		{text.BACK}
	</a>
<!-- END text -->

<!-- BEGIN form -->
	<form method="post" action="">
		<strong>
			{form.NOTE} {form.ON_TEN}
		</strong>
			&nbsp;&nbsp;
		<select name="note"> 
			<option value="0">0</option> 
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8" selected="selected">8</option>
			<option value="9">9</option>
			<option value="10">10</option>
		</select>
		<br /><br />
		{form.FORM}
	</form>
<!-- END form -->