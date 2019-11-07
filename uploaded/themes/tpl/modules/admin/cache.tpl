<!-- BEGIN text -->
	<br /><br />
	{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
<!-- END text -->

<!-- BEGIN index -->
	<p>
		<u>
			{index.CACHE_CONTENT} :
		</u>
	</p>
	<table border="0" style="width: 100%;">
		<tr>
			<td>
				{index.NAME}<br /><br />
			</td>
			<td>
				{index.SIZE}<br /><br />
			</td>
			<td>
				{index.EMPT}<br /><br />
			</td>
		</tr>
		
		<!-- BEGIN index.mod -->
			<tr>
				<td>
					{index.mod.FILE}
				</td>
				<td>
					{index.mod.SIZE}
				</td>
				<td>
					<a href="{index.mod.HREF}">{index.mod.EMPT}</a>
				</td>
			</tr>
		<!-- END index.mod -->
		
	</table>
	<br /><br />
	<a href="index.php?mods=admin&amp;page=cache&amp;empty_all">
		{index.EMPTY_ALL}
	</a><br /><br />
	<a href="index.php?mods=admin">
		{index.BACK}
	</a>
<!-- END index -->