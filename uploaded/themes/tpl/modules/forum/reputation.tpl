<!-- BEGIN reputation_error -->
	<br />
	{reputation_error.TXT}
	<br /><br />
	<a href="{reputation_error.URL}" />
		{reputation_error.BACK}
	</a>
<!-- END reputation_error -->
<!-- BEGIN reputation_valid -->
	<br />
	{reputation_valid.TXT}
	<br /><br />
	<a href="{reputation_valid.URL}" />
		{reputation_valid.BACK}
	</a>
<!-- END reputation_valid -->
<!-- BEGIN reputation_form -->
	<u>
		{reputation_form.TITLE} :
	</u>
	<br />
	<form method="post" action="">
		<br />
		{reputation_form.U_CAN_CHOOSE_DECREASE}
		<br /><br />
		{reputation_form.ADD}
			<select name="points">
				<!-- BEGIN reputation_form.reputation_form_choix -->
					<option value="{reputation_form.reputation_form_choix.VALEUR}">{reputation_form.reputation_form_choix.VALEUR}</option>
				<!-- END reputation_form.reputation_form_choix -->
			</select>
		{reputation_form.PTS_TO_USER} : {reputation_form.PSEUDO}
		<br />
		<center>
			<input type="submit" value="{reputation_form.VALID}" />
		</center>
	</form>
<!-- END reputation_form -->