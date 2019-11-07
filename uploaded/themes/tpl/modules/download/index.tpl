<!-- BEGIN download_index -->
	<fieldset>
		<legend>
			{download_index.CATS}
		</legend>
		<br />
		<table border="0" style="width: 99%;">
			<tr>
				<td style="width:55%;">
					{download_index.NOM_CAT}
				</td>
				<td style="width:15%;">
					{download_index.FILES}
				</td>
				<td style="width:15%;">
					{download_index.HITS}
				</td>
				<td style="width:15%;">
					{download_index.DOWNLOADS}
				</td>
			</tr>
			<!-- BEGIN download_index.none -->
				<tr>
					<td colspan="4">
						<br />{download_index.none.TXT}
					</td>
				</tr>
			<!-- END download_index.none -->
			<!-- BEGIN download_index.cat -->
				<tr>
					<td style="width:55%;">
						<table border="0">
							<tr>
								<td>
									<!-- BEGIN download_index.cat.pass -->
										<img src="./themes/tpl/img/forum/locked.png" border="0" />
									<!-- END download_index.cat.pass -->
								</td>
								<td>
									<a href="./index.php?mods=download&amp;page=viewcat&amp;id={download_index.cat.ID}">
										&raquo; {download_index.cat.NOM}<br />
										<i>{download_index.cat.DEF}</i>
									</a>
								</td>
							</tr>
						</table>
					</td>
					<td style="width:15%;">
						{download_index.cat.FILES}
					</td>
					<td style="width:15%;">
						{download_index.cat.HITS}
					</td>
					<td style="width:15%;">
						{download_index.cat.DOWNLOADS}
					</td>
				</tr>
			<!-- END download_index.cat -->
		</table>
	</fieldset>
	<br />
	<!-- BEGIN download_index.stats -->
		<fieldset>
			<legend>
				{download_index.stats.STATS}
			</legend>
			<br />
			{download_index.stats.NB_FILE} : {download_index.stats.FILES}<br />
			{download_index.stats.NB_HITS} : {download_index.stats.HITS}<br />
			{download_index.stats.NB_DOWNLOADS} : {download_index.stats.DOWNLOADS}<br />
		</fieldset>
	<!-- END download_index.stats -->
<!-- END download_index -->