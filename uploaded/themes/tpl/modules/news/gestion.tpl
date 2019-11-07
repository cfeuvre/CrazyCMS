<!-- BEGIN text -->
	{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
<!-- END text -->

<!-- BEGIN gestion -->
	<form action="" method="post" >
		{gestion.NEWS_TO_PRINT} : 	
		<input type="text" name="new_nb_news" value="{gestion.NB_NEWS}" />
		<input type=submit value="{gestion.VALID}" />
	</form>
	<br />
	<!-- BEGIN gestion.forum -->
		<form action="" method="post" >
			<fieldset>
				<legend>
					{gestion.forum.LINK_FORUM_TO_NEWS} : 
				</legend>
				<br />
				<table style="width: 100%;">
					<tr>
						<td>
							<u>
								{gestion.forum.ENABLE_FUNCTION} :
							</u>
							<br /><br />
							<input type="radio" name="news_on_forum" value="1" {gestion.forum.CHECK} />{gestion.forum.YES}<br />
							<input type="radio" name="news_on_forum" value="0" {gestion.forum.CHECK1} />{gestion.forum.NO}
						</td>
						<td>
							<u>
								{gestion.forum.CAT_TO_LINK} :
							</u>
							<br /><br />
							<select name="forum_cat">
								<option value="0">
									{gestion.forum.CHOOSE_CAT}
								</option>
							<!-- BEGIN gestion.forum.cat -->
								<option value="{gestion.forum.cat.ID}" {gestion.forum.cat.SELECTED}>
									{gestion.forum.cat.NOM}
								</option>
							<!-- END gestion.forum.cat -->
							</select><br /><br />
							<input type="text" name="forum_name" value="{gestion.forum.CAT_NAME}"/>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;">
							<input type="submit" value="{gestion.forum.VALID}" />
						</td>
					</tr>
				</table>
			</fieldset>
		</form>
		<br />
	<!-- END gestion.forum -->
	<a href="index.php?mods=news&amp;page=admin">
		{gestion.BACK}
	</a>
<!-- END gestion -->