<!-- BEGIN lang -->
	<fieldset>
		<legend>
			<font color="#c00000">
				<strong>
					{lang.LANG}
				</strong>
			</font>
		</legend>
		<form method="post" action="">
			<center>
				<strong>
					{lang.PLEASE_CHOOSE_LANGUAGE} :
				</strong>
				<select name="lang">
					<!-- BEGIN lang.lg -->
						<option value="{lang.lg.LANGUE}" {lang.lg.SELECTED}>
							{lang.lg.LANGUE}
						</option>
					<!-- END lang.lg -->
				</select>
			</center>
			<br /><br />
			<center>
				<input type="submit" value="{lang.VALID}" />
			</center>
		</form>
	</fieldset>
<!-- END lang -->