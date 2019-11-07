<!-- BEGIN form -->

	<form method="post" action="">
		<br />
		{form.NOTE} : <select name="note">
			<!-- BEGIN form.options -->
				<option value="{form.options.VALUE}">{form.options.VALUE}</option>
			<!-- END form.options -->
		</select>
		<br /><br />
		{form.COMMENT} : <br /><br />
		{form.FORM}
	</form>

<!-- END form -->

<!-- BEGIN valid -->

	<br />
	{valid.TXT}
	<br /><br />
	<a href="index.php?mods=download&amp;page=viewfile&amp;id={valid.ID}">
		{valid.BACK}
	</a>

<!-- END valid -->