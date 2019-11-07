<!-- BEGIN index -->
	<br />
	<a href="index.php?mods=newsletter&amp;page=admin&amp;send_news">
		&raquo; {index.SEND}
	</a><br /><br />
	<a href="index.php?mods=newsletter&amp;page=admin&amp;truncate">
		&raquo; {index.TRUNCATE}
	</a>
<!-- END index -->

<!-- BEGIN truncated -->
	{truncated.TXT}
	<br /><br />
	<a href="index.php?mods=newsletter&amp;page=admin">
		{truncated.BACK}
	</a>
<!-- END truncated -->

<!-- BEGIN send_form -->
	<form method="post" action="">
		{send_form.DESTIN} :<br /><br />
		<table border="0" style="width: 98%;">
			<tr>
				<td>
					<input type="radio" checked="checked" name="destin" value="0" />
				</td>
				<td>
					{send_form.REGISTED}
				</td>
			</tr>
			<tr>
				<td>
					<input type="radio" name="destin" value="1" />
				</td>
				<td>
					{send_form.ALL}
				</td>
			</tr>
		</table>
		<br /><br />
		{send_form.FORM}
	</form>
<!-- END send_form -->

<!-- BEGIN send_form_valid -->
	{send_form_valid.TXT}
	<br /><br />
	<a href="index.php?mods=newsletter&amp;page=admin">
		{send_form_valid.BACK}
	</a>
<!-- END send_form_valid -->