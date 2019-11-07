<!-- BEGIN index -->
	<a href="index.php?mods=admin&amp;page=log&amp;see">
		&raquo; {index.SEE_LOGS}<br /><br />
	</a>
	<a href="index.php?mods=admin&amp;page=log&amp;truncate">
		&raquo; {index.TRUNCATE_LOGS}<br /><br />
	</a>
	<a href="index.php?mods=admin">
		{index.BACK}
	</a>
<!-- END index -->

<!-- BEGIN truncate_index -->
	{truncate_index.TO_DEL} : <br /><br />
	<!-- BEGIN truncate_index.jn -->
		<a href="index.php?mods=admin&amp;page=log&amp;truncate&amp;log={truncate_index.jn.ID}">
			&raquo; {truncate_index.jn.NOM}<br />
		</a>
	<!-- END truncate_index.jn -->
	<br /><br />
	<a href="index.php?mods=admin&amp;page=log">
		{truncate_index.BACK}
	</a>
<!-- END truncate_index -->

<!-- BEGIN see_index -->
	{see_index.PRESENT} : <br /><br />
	<!-- BEGIN see_index.jn -->
		<a href="index.php?mods=admin&amp;page=log&amp;see&amp;log={see_index.jn.ID}">
			&raquo; {see_index.jn.NOM}<br />
		</a>
	<!-- END see_index.jn -->
	<br /><br />
	<a href="index.php?mods=admin&amp;page=log">
		{see_index.BACK}
	</a>
<!-- END see_index -->

<!-- BEGIN see_log -->
	{see_log.PRINTING_LOGS_FROM} : {see_log.GR}
	<br /><br />
	<table border="0" style="width: 98%;">
		<tr>
			<td>
				{see_log.MODULE}
			</td>
			<td>
				{see_log.USER}
			</td>
			<td>
				{see_log.ACTION}
			</td>
			<td>
				{see_log.DATE}
			</td>
			<td>
				{see_log.DEL}
			</td>
		</tr>
		<!-- BEGIN see_log.empty -->
			<tr>
				<td colspan="5">
					{see_log.empty.TXT}
				</td>
			</tr>
		<!-- END see_log.empty -->
		<!-- BEGIN see_log.lg -->
			<tr>
				<td>
					{see_log.lg.MODULE}
				</td>
				<td>
					{see_log.lg.USER}
				</td>
				<td>
					{see_log.lg.ACTION}
				</td>
				<td>
					{see_log.lg.DATE}
				</td>
				<td>
					<a href="index.php?mods=admin&amp;page=log&amp;del={see_log.lg.ID}&amp;gd={see_log.lg.GRADE}">
						{see_log.lg.DEL}
					</a>
				</td>
			</tr>
		<!-- END see_log.lg -->
	</table>
	<br /><br />
	<a href="index.php?mods=admin&amp;page=log&amp;see">
		{see_log.BACK}
	</a>
<!-- END see_log -->

<!-- BEGIN logs_txt -->
	&raquo; {logs_txt.TXT}
	<br /><br />
	<a href="index.php?mods=admin&amp;page=log">
		{logs_txt.BACK}
	</a>
<!-- END logs_txt -->