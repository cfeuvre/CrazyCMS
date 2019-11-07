<!-- BEGIN text -->
	<br /><br />
	{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
<!-- END text -->

<!-- BEGIN index -->
	<center>
		<a href="index.php?mods=page&amp;page=post">
			| {index.CREATE_PAGE} |
		</a>
	</center>
	<br /><br />
	<table width="95%" border cellspacing="0">
		<tr align="center">
			<td>
				<strong>
					{index.PAGE}
				</strong>
			</td>
			<td>
				<strong>
					{index.MODIFY}
				</strong>
			</td>
			<td>
				<strong>
					{index.DEL}
				</strong>
			</td>
		</tr>
		<!-- BEGIN index.pg -->
			<tr align="center">
				<td>
					<a href="index.php?mods=page&amp;page=index&amp;id={index.pg.ID}">
						{index.pg.NOM}
					</a>
				</td>
				<td>
					<a href="index.php?mods=page&amp;page=modif&amp;id={index.pg.ID}">
						<img src="./themes/tpl/img/admin/edit.gif" border="0">
					</a>
				</td>
				<td>
					<a href="index.php?mods=page&amp;page=admin&amp;del={index.pg.ID}">
						<img src="./themes/tpl/img/admin/del.gif" border="0">
					</a>
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
	<br />
	<center>
		<a href="index.php?mods=admin">
			| {index.BACK} |
		</a>
	</center>
<!-- END index -->