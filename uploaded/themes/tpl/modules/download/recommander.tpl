<!-- BEGIN reco -->
	<br />
	{reco.TXT}
	<br />
	<br />
	<form method="post" action="">
		{reco.USER_SELECT} : 
		<select name="user">
			<!-- BEGIN reco.user_option -->
				<option value="{reco.user_option.VALUE}">
					{reco.user_option.NOM}
				</option>
			<!-- END reco.user_option -->
		</select>
		
		<br /><br />
		
		{reco.FORM}
		<em>
			{reco.LIEN_REPLACE}
		</em>
	</form>
	<br /><br />
	<a href="index.php?mods=download&amp;page=viewfile&amp;id={reco.ID}">
		{reco.BACK}
	</a>
<!-- END reco -->

<!-- BEGIN success -->
	<br />
	{success.TXT}
	<br /><br />
	<a href="index.php?mods=download&amp;page=viewfile&amp;id={success.ID}">
		{success.BACK}
	</a>
<!-- END success -->