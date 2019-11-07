<!-- BEGIN index -->
	<p align="left" style="text-decoration: underline;">{index.PAGEDISPOS}</p>
	<br />
	<table style="width: 100%;" border="0">
		<tr>
			<td colspan="3">
				{index.PAGENAME} : <br /><br />
			</td>
		</tr>
		<!-- BEGIN index.pg -->
			<tr>
				<td style="width: 50%;">
					 <li><a href="index.php?mods=free_page&amp;page={index.pg.FILE}">{index.pg.FILE}</a>
				</td>
				<td style="width: 25%;">
					<a href="index.php?mods=free_page&amp;page=admin&amp;edit_page={index.pg.FILE64}">{index.pg.MODIFY}</a>
				</td>
				<td style="width: 25%;">
					<a href="index.php?mods=free_page&amp;page=admin&amp;del_page={index.pg.FILE64}">{index.pg.DEL}</a>
				</td>
			</tr>
		<!-- END index.pg -->
		<!-- BEGIN index.none -->
			<tr>
				<td colspan="3">
					{index.none.TXT}
				</td>
			</tr>
		<!-- END index.none -->
	</table>
	<br /><br />
	<a href="?mods=free_page&amp;page=admin&amp;add_page">
		{index.ADD_PAGE}
	</a>
	<br /><br />
	<fieldset>
		<legend>
			{index.HELP}
		</legend>
		<br />
			{index.HELPTXT}
		<br /><br />
	</fieldset>
<!-- END index -->

<!-- BEGIN text -->
	<br /><br />
	{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
<!-- END text -->

<!-- BEGIN form -->
 <form method="post" action="">
	<table border="0" style="width: 100%;">
		<tr>
			<td>
				{form.PAGENAME}
			</td>
			<td>
				<input type="text" name="name" value="{form.PAGENAME_VALUE}"/>
			</td>
		</tr>
		<tr>
			<td>
				{form.PAGECODE}
			</td>
			<td>
				<textarea name="contenu" cols="50" rows="20">
					{form.PAGECODE_VALUE}
				</textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: center;">
				<input type="submit" value="{form.VALID}" />
			</td>
		</tr>
	</table>
	<br /><br />
	<a href="index.php?mods=free_page&amp;page=admin">
		{form.BACK}
	</a>
<!-- END form -->