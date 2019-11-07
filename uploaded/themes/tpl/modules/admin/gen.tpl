<!-- BEGIN text -->
	<br />
	{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
<!-- END text -->

<!-- BEGIN index -->
	<form method="post" action="">
		<fieldset>
			<legend>
				<u>
					<strong>
						{index.MAIN_OPTIONS}
					</strong>
				</u>
			</legend>
			<ul>
				<li>
					{index.NOM_SITE}
				</li>
			</ul>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" name="nom_site" value="{index.SITENAME}" size="35" />
			<ul>
				<li>
					{index.DESC}
				</li>
			</ul>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" name="descriptif" value="{index.DESCRIPTIF}" size="35" />
			<ul>
				<li>
					{index.MC}
				</li>
			</ul>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" name="mot_clef" value="{index.KEYWORDS}" size="35" />
			<ul>
				<li>
					{index.DEFAULT_LANGUAGE}
				</li>
			</ul>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<select name="default_langue">
						<!-- BEGIN index.lang -->
							<option value="{index.lang.FILE}" {index.lang.SELECTED}>
								{index.lang.FFILE}
							</option>
						<!-- END index.lang -->
					</select>
			<ul>
				<li>
					{index.DEFAULT_THEME}
				</li>
			</ul>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<select name="default_theme">
						<!-- BEGIN index.theme -->
							<option value="{index.theme.FILE}" {index.theme.SELECTED}>
								{index.theme.FFILE}
							</option>
						<!-- END index.theme -->
					</select>	
			<ul>
				<li>
					{index.USE_DEFAULT_THEME}
				</li>
			</ul>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" value="0" name="default_theme_locked" {index.LOCK_THEME_0} /> {index.DISABLED}
					<input type="radio" value="1" name="default_theme_locked" {index.LOCK_THEME_1} /> {index.ENABLED}
			<ul>
				<li>
					{index.USER_VALIDATION}
				</li>
			</ul>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" value="0" name="users_valid" {index.USERS_VALID_0} /> {index.NONE}
					<input type="radio" value="1" name="users_valid" {index.USERS_VALID_1} /> {index.ADMIN_VALID}
					<input type="radio" value="2" name="users_valid" {index.USERS_VALID_2} /> {index.EMAIL_VALID}
			<ul>
				<li>
					{index.SECU_CODE}
				</li>
			</ul>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" value="0" name="security_code" {index.SEC_0} /> {index.DISABLED}
					<input type="radio" value="1" name="security_code" {index.SEC_1} /> {index.ENABLED}
					<p align="center">
						{index.ONLY_ACTIVATE_IF_PICTURE} : 
						<br /><br />
						<img src="./mods/register/image.php?test" alt="Erreur"/>
					</p>
			<ul>
				<li>
					{index.FORMTYPE}
				</li>
			</ul>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" value="0" name="use_wysi" {index.WISY_0} /> {index.BBFORM}
					<input type="radio" value="1" name="use_wysi" {index.WISY_1} /> {index.WISYFORM}
			<ul>
				<li>
					{index.FORCE_LOGIN}
				</li>
			</ul>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="be_log" value="0" {index.BE_LOG_0} /> {index.NO}
					<input type="radio" name="be_log" value="1" {index.BE_LOG_1} /> {index.YES}
			<ul>
				<li>
					{index.CLOSE_REGISTRATION}
				</li>
			</ul>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" name="lock_registration" value="0" {index.LOCK_REG_0} /> {index.NO}
					<input type="radio" name="lock_registration" value="1" {index.LOCK_REG_1} /> {index.YES}
			<ul>
				<li>
					{index.ENABLE_MAINT}
				</li>
			</ul>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" onclick="document.getElementById('mtn_note').style.visibility = 'hidden';document.getElementById('mtn_note').style.height = '0px';" name="maintenance_mod" value="0" {index.MAINT_NO} /> {index.NO}
				<input type="radio" onclick="document.getElementById('mtn_note').style.visibility = 'visible';document.getElementById('mtn_note').style.height = '';" name="maintenance_mod" value="1" {index.MAINT_YES} /> {index.YES}
				<div id="mtn_note" style="margin-left:50px;{index.MAINT_MOD}">
					<br />
					<fieldset>
						<legend>
							{index.MAINTENANCE_NOTES}
						</legend>
						<textarea name="maintenance_mess">{index.MAINTENANCE_MESS}</textarea>
					</fieldset>
				</div>
			<br /><br />
		</fieldset>
		<br />
		<p style="text-align:center;">
			<input type="submit" onclick="getContent('');" value="{index.VALID}" />
			<input type="button" onclick="history.go(0);" value="{index.RESET}" />
		</p>
		<br />
		<fieldset>
			<legend>
				<u>
					<strong>
						{index.SECONDARY_OPTIONS}
					</strong>
				</u>
			</legend>
			<ul>
				<li>
					{index.LOGO}
				</li>
			</ul>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="text" name="logo" value="{index.LOGO_VALUE}" size="35" />
			<ul>
				<li>
					{index.RECUP_PASS_MAIL}
				</li>
			</ul>
				<textarea name="message_regen" cols="40" rows="5">{index.MAIL}</textarea>
			<ul>
				<li>
					{index.RECUP_PASS_MAIL_2}
				</li>
			</ul>
				<textarea name="message_new_mdp" cols="40" rows="5">{index.MAIL2}</textarea>
			<ul>
				<li>
					{index.COPYRIGHTS}
				</li>
			</ul>
				<textarea name="copyright" cols="40" rows="5">{index.COPY}</textarea>
			<ul>
				<li>
					{index.EDITO}
				</li>
			</ul>
			<fieldset>
				<br />{index.TITLE} :<br /><br />
					<input type="text" name="titre_edito" value="{index.EDITO_TITLE}" size="35" />
					<br /><br />{index.CONTENU} :<br /><br />
					{index.FORM_EDITO}
			</fieldset>
		</fieldset>
		
		<p style="text-align:center;">
			<input type="submit" onclick="getContent('');" value="{index.VALID}" />
			<input type="button" onclick="history.go(0);" value="{index.RESET}" />
		</p>
	</form>
	<br />
	<a href="index.php?mods=admin">
		{index.BACK}
	</a>	
<!-- END index -->