<!-- BEGIN text -->
	<br />
	{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
<!-- END text -->

<!-- BEGIN index -->
	{index.JS}
	<form method="post" action="">
		<fieldset>
			<legend>
				<b>
					{index.PERSONNAL_INFOS}
				</b>
			</legend>
			<table width="75%" align="center">
				<tr>
					<td>
						<strong>
							{index.PSEUDO} :
						</strong>
					</td>
					<td>
						<input type="text" name="pseudo" value="{index.PSEUDO_VALUE}" size="20" />
					</td>
				</tr>
				<tr>
					<td>
						<strong>
							{index.PASSWORD} : 
						</strong>
					</td>
					<td>
						<input type="password" id="pass" name="pass"  size="20"  />
					</td>
				</tr>
				<tr>
					<td>
						<strong>
							{index.CONFIRM_PASSWORD} : 
						</strong>
					</td>
					<td>
						<input type="password" id="pass1" name="pass1" size="20" onkeyup="verif_pass();" />
						<div id="different"></div>
					</td>
				</tr>
				<tr>
					<td>
						<strong>
							{index.EMAIL} :
						</strong>
					</td>
					<td>
						<input type="text" id="email" name="email" value="{index.EMAIL_VALUE}"  onkeyup="verif_email();" size="20" />
						<div id="different_email"></div>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset>
			<legend>
				<b>
					{index.AVATAR}
				</b>
			</legend>
			<br />
			<table width=95%">
				<tr>
					<td>
						<input type="radio" checked="checked" onclick="update_img('rien' );" name="modif_avatar" value="0" />{index.NE_PAS_MODIFIER}<br /><br />
						<input type="hidden" value="{index.IMG}" name="last_avatar" />
						<input id="radun" type="radio" onclick="update_img('select_local' );" name="modif_avatar" value="1" />
						<u>
							{index.CHOOSE_LOCAL_AVATAR} :
						</u>
						<br/><br />&nbsp;&nbsp;
						<select onfocus="lch_rad('radun');" name="local_avatar" id="select_local" onchange="update_img('select_local' );" onkeyup="update_img('select_local');">
							<option value="">
								{index.CHOOSE}
							</option>
							<!-- BEGIN index.option -->
								<option value="{index.option.VALUE}">
									{index.option.NAME}
								</option>
							<!-- END index.option -->
						</select>
						<br /><br />
						<input id="raddeu" type="radio" onclick="update_img('input_extern' );" name="modif_avatar" value="2"/>
							<u>
								{index.CHOOSE_EXTERNE_AVATAR} :
							</u>
							<br/><br />&nbsp;&nbsp;
						<input type="text" id="input_extern" onkeyup="update_img('input_extern' );" name="externe_avatar" value="http://" onfocus="lch_rad('raddeu' );"/>
					</td>
					<td width="130">
						<fieldset>
							<legend>
								<u>
									{index.YOUR_ACTUAL_AVATAR} :
								</u>
							</legend>

							<br /><img src="{index.IMG}" alt="Not found" width="125" height="125"/>
						</fieldset>
					</td>
					<td width="130">
						<fieldset>
							<legend>
								<u>
									{index.YOUR_NEW_AVATAR} :
								</u>
							</legend><br />
							<img src="{index.IMG}" id="img" alt="Not found" width="125" height="125"/>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<center>
							<br /><hr />
							<u>
								{index.UPLOAD_FROM_COMPUTER} :
							</u>
							<br /><br />
							<iframe	src="./mods/upload/upload.php?avatarz" frameBorder="no" width="350" height="120"></iframe>
						</center>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset>
			<legend>
				<b>
					{index.USER_INFO}
				</b>
			</legend>
			<table width="75%" align="center">
				<tr>
					<td>
						<strong>
							{index.NAME} {index.FIRST_NAME} :
						</strong>
					</td>
					<td>
						<input type="text" name="nom" value="{index.NAME_VALUE}" size="20" />
					</td>
				</tr>
				<tr>
					<td>
						<strong>
							{index.LOCALIZATION} :
						</strong>
					</td>
					<td>
						<input type="text" name="localisation" value="{index.LOCA_VALUE}" size="20" />
					</td>
				</tr>
				<tr>
					<td>
						<strong>
							{index.SEX} :
						</strong>
					</td>
					<td>
						<input type="radio" name="sexe" value="1" {index.SEX_CHECK0} />{index.MAN}&nbsp;&nbsp;&nbsp;
						<input type="radio" name="sexe" value="2" {index.SEX_CHECK1} />{index.WOMAN}
					</td>
				</tr>
				<tr>
					<td>
						<strong>
							{index.DATE_OF_BIRTH} (jj/mm/aaaa) :
						</strong>
					</td>
					<td>
						<input type="text" name="date" value="{index.ANNIF}" size="20" />
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset>
			<legend>
				<b>
					{index.MY_MESS}
				</b>
			</legend>
			<table width="75%" align="center">
				<tr>
					<td>
						<strong>
							{index.ADRESS_ICQ}  :
						</strong>
					</td>
					<td>
						<input type="text" name="icq" value="{index.ICQ_VALUE}" size="20" />
					</td>
				</tr>
				<tr>
					<td>
						<strong>
							{index.ADRESS_MSN} :
						</strong>
					</td>
					<td>
						<input type="text" id="msn" name="msn" value="{index.MSN_VALUE}" size="20" />
					</td>
				</tr>
				<tr>
					<td>
						<strong>
							{index.ADRESS_AIM} :
						</strong>
					</td>
					<td>
						<input type="text" name="aim" value="{index.AIM_VALUE}" size="20" />
					</td>
				</tr>
				<tr>
					<td>
						<strong>
							{index.ADRESS_YAHOOM} :
						</strong>
					</td>
					<td>
						<input type="text" name="yahoom" value="{index.YAHOOM_VALUE}" size="20" />
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset>
			<legend>
				<b>
					{index.OTHER}
				</b>
			</legend>
			<table width="75%" align="center">
				<tr>
					<td>
						<strong>
							{index.WEB_SITE} :
						</strong>
					</td>
					<td>
						<input type="text" name="site" value="{index.SITE_VALUE}" size="20" />
					</td>
				</tr>
				<tr>
					<td>
						<strong>
							{index.SIGNATURE}
						</strong>
					</td>
					<td>
						{index.FORM}
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" value="{index.VALID}" onclick="getEditorContent();"/>
					</td>
				</tr>
			</table>
		</fieldset>
	</form>
<!-- END index -->