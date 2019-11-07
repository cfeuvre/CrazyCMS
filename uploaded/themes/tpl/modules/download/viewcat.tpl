<!-- BEGIN download_viewcat_cats -->
	<fieldset>
		<legend>
			{download_viewcat_cats.CATS}
		</legend>
		<br />
		<table border="0" style="width: 99%;">
			<tr>
				<td style="width:55%;">
					{download_viewcat_cats.NOM_CAT}
				</td>
				<td style="width:15%;">
					{download_viewcat_cats.FILES}
				</td>
				<td style="width:15%;">
					{download_viewcat_cats.HITS}
				</td>
				<td style="width:15%;">
					{download_viewcat_cats.DOWNLOADS}
				</td>
			</tr>
			<!-- BEGIN download_viewcat_cats.cat -->
				<tr>
					<td style="width:55%;">
						<table border="0">
							<tr>
								<td>
									<!-- BEGIN download_viewcat_cats.cat.pass -->
										<img src="./themes/tpl/img/forum/locked.png" border="0" />
									<!-- END download_viewcat_cats.cat.pass -->
								</td>
								<td>
									<a href="./index.php?mods=download&amp;page=viewcat&amp;id={download_viewcat_cats.cat.ID}">
										&raquo; {download_viewcat_cats.cat.NOM}<br />
										<i>{download_viewcat_cats.cat.DEF}</i>
									</a>
								</td>
							</tr>
						</table>
					</td>
					<td style="width:15%;">
						{download_viewcat_cats.cat.FILES}
					</td>
					<td style="width:15%;">
						{download_viewcat_cats.cat.HITS}
					</td>
					<td style="width:15%;">
						{download_viewcat_cats.cat.DOWNLOADS}
					</td>
				</tr>
			<!-- END download_viewcat_cats.cat -->
		</table>
	</fieldset>
<!-- END download_viewcat_cats -->

<!-- BEGIN download_viewcat -->
	<br />
	<fieldset>
		<legend>
			{download_viewcat.FILES}
		</legend>
		<br />
		<table border="0" style="width: 99%;">
			<tr>
				<td style="width:70%;">
					{download_viewcat.FILENAME}
				</td>
				<td style="width:15%;">
					{download_viewcat.HITS}
				</td>
				<td style="width:15%;">
					{download_viewcat.DOWNLOADS}
				</td>
			</tr>
			<!-- BEGIN download_viewcat.none -->
				<tr>
					<td colspan="3">
						<br />{download_viewcat.none.TXT}
					</td>
				</tr>
			<!-- END download_viewcat.none -->
			<!-- BEGIN download_viewcat.file -->
				<tr>
					<td style="width:70%;">
						<table border="0">
							<tr>
								<td>
									<!-- BEGIN download_viewcat.file.pass -->
										<img src="./themes/tpl/img/forum/locked.png" border="0" />
									<!-- END download_viewcat.file.pass -->
								</td>
								<td>
									<a href="./index.php?mods=download&amp;page=viewfile&amp;id={download_viewcat.file.ID}">
										&raquo; {download_viewcat.file.NOM}
									</a>
								</td>
							</tr>
						</table>
					</td>
					<td style="width:15%;">
						{download_viewcat.file.HITS}
					</td>
					<td style="width:15%;">
						{download_viewcat.file.DOWNLOADS}
					</td>
				</tr>
			<!-- END download_viewcat.file -->
		</table>
	</fieldset>
	<!-- BEGIN download_viewcat.add -->
		<br /><br />
		<a href="index.php?mods=download&amp;page=admin&amp;add_subcat={download_viewcat.add.ID}">
			[ {download_viewcat.add.ADD} ]
		</a>
		<a href="index.php?mods=download&amp;page=admin&amp;add_file={download_viewcat.add.ID}">
			[ {download_viewcat.add.ADD_FILE} ]
		</a>
		<a href="index.php?mods=download&amp;page=admin&amp;edit_cat={download_viewcat.add.ID}">
			[ {download_viewcat.add.EDIT} ]
		</a>
		<a href="index.php?mods=download&amp;page=admin&amp;del_cat={download_viewcat.add.ID}">
			[ {download_viewcat.add.DELETE} ]
		</a>
	<!-- END download_viewcat.add -->
	<br /><br />
	<a href="{download_viewcat.BACK_URL}">
		{download_viewcat.BACK}
	</a>
<!-- END download_viewcat -->

<!-- BEGIN password_needed -->

	{password_needed.TXT}<br /><br />
	<form method="post" action="">
	
		<input type="password" name="cat_password" />
		<input type="hidden" name="cat_id" value="{password_needed.ID}" />
		
		<p style="text-align: center;">
			<input type="submit" value="{password_needed.VALUE}" />
		</p>
		<br />
		<a href="index.php?mods=download">
			{password_needed.BACK}
		</a>
	</form>

<!-- END password_needed -->
<!-- BEGIN password_valid -->

	{password_valid.TXT}<br /><br />
	<a href="{password_valid.URL}">
		{password_valid.GO}
	</a>

<!-- END password_valid -->