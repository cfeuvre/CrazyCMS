<!-- BEGIN move_form -->
	{move_form.MOVE_TOPIC}
	<i>
		{move_form.TOPIC_NAME}
	</i> 
	{move_form.TO} : 
		<form method="post" action="">
			<select name="dest">
				<option value="" selected="selected">{move_form.CHOOSE_DESTINATION}</option>
				<!-- BEGIN move_form.move_form_choix_cat -->
					<optgroup label="{move_form.move_form_choix_cat.NAME}">
					<!-- BEGIN move_form.move_form_choix_cat.move_form_choix -->
						<option value="{move_form.move_form_choix_cat.move_form_choix.ID}"> - {move_form.move_form_choix_cat.move_form_choix.NOM}</option>
					<!-- END move_form.move_form_choix_cat.move_form_choix -->
					</optgroup>
				<!-- END move_form.move_form_choix_cat -->
			</select>
			<br /><br />
			<input type="submit" value="{move_form.VALID}" />
		</form>
<!-- END move_form -->
<!-- BEGIN move_valid_error -->
	<img src="./themes/tpl/img/error.png" align="left">
		{move_valid_error.TXT}
		<br /><br />
		<a href="{move_valid_error.URL}">
			{move_valid_error.BACK}
		</a>
<!-- END move_valid_error -->
<!-- BEGIN move_valid -->
		{move_valid.TXT}
		<br /><br />
		<a href="{move_valid.URL}">
			{move_valid.BACK}
		</a>
<!-- END move_valid -->