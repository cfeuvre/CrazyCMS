<!-- BEGIN del -->
	<br /><br />
	&raquo; {del.TXT}
	<br /><br />
	<a href="index.php?mods=copyright&amp;page=admin">
		{del.BACK}
	</a>
<!-- END del -->

<!-- BEGIN copyright -->
	<br />
	<fieldset>
		<legend>
			{copyright.WHATS_COP_PAGE}
		</legend>
		<br />
		{copyright.WHATS_COP_PAGE_TXT}
		<br /><br />
	</fieldset>
	<br /><br />
	<center>
		<a href="index.php?mods=copyright&amp;page=post">
			| {copyright.ADD_PAGE} |
		</a>
	</center>
	<br /><br />
	<!-- BEGIN copyright.cops -->
		<table width="95%" border cellspacing="0">
			<tr align="center">
				<td>
					<strong>
						{copyright.cops.TITLE}
					<strong>
				</td>
				<td>
					<strong>
						{copyright.cops.MODIF}
					</strong>
				</td>
				<td>
					<strong>
						{copyright.cops.DEL}
					</strong>
				</td>
			</tr>
			<!-- BEGIN copyright.cops.cop -->
				<tr align="center">
					<td>
						<strong>
							{copyright.cops.cop.TITLE}
						<strong>
					</td>
					<td>
						<strong>
							<a href="index.php?mods=copyright&amp;page=modif&amp;id={copyright.cops.cop.ID}">
									<img src="./themes/tpl/img/admin/edit.gif" border="0">
							</a>
						</strong>
					</td>
					<td>
						<strong>
							<a href="index.php?mods=copyright&amp;page=admin&amp;del={copyright.cops.cop.ID}">
									<img src="./themes/tpl/img/admin/del.gif" border="0">
							</a>
						</strong>
					</td>
				</tr>
			<!-- END copyright.cops.cop -->
		</table>
	<!-- END copyright.cops -->
	<!-- BEGIN copyright.none_cops -->
		<center>
			<strong>
				{copyright.none_cops.TXT}
			</strong>
		</center>
	<!-- END copyright.none_cops -->
	<br /><br />
	<a href="index.php?mods=admin">
		{copyright.BACK}
	</a>
<!-- END copyright -->