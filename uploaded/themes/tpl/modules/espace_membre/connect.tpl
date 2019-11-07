<!-- BEGIN index -->
	<!-- BEGIN index.be_log -->
		<fieldset>
			<legend>
				<b>
					{index.be_log.CONNECTION_INDISPENSABLE}
				</b>
			</legend>
			<br />
			{index.be_log.YOU_MUST_BE_CONNECTED}
			<br />
			{index.be_log.IF_NOT_CLICK}
			<a href="index.php?mods=register">
				{index.be_log.HERE}
			</a>
			 {index.be_log.TO_REGISTER}
			<br /><br />
		</fieldset><br />
	<!-- END index.be_log -->
	<form action = "./session.php" method="post">
		<fieldset width="75%">
			<legend>
				<strong>
					{index.IDENTIFICATION}
				</strong>
			</legend>
			<div align="center">
				<table width="75%">
					<tr>
						<td align="left">
							<strong>
								&raquo; {index.PLEASE_ENTER_LOGIN} : 
							</strong><br />
						</td>
					</tr>
					<tr>
						<td>
							<input type="text" name="pseudo" /><br /><br />
						</td>
					</tr>
					<tr>
						<td align="left">
							<strong>
								&raquo; {index.PLEASE_ENTER_PASSWORD} : 
							</strong><br />
						</td>
					</tr>
					<tr>
						<td>
							<input type="password" name="password" /> <br /><br />
						</td>
					</tr>
					<tr>
						<td>
							{index.TO_REMEMBER} <input type="checkbox" name="auto" value="on" />
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<br />
							<center>	
								<input type="hidden" name="theme" value="{index.U_THEME}" />
								<input type="hidden" name="lang" value="{index.U_LANG}" />
								<input type="submit" value="{index.VALID}" />
							</center>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<br />
							<center>	
								<a href="index.php?mods=espace_membre&page=mdp">
									{index.FORGETTED_PASSWORD}
								</a>
							</center>
						</td>
					</tr>
				</table>
			</div>
		</fieldset>
	</form>
<!-- END index -->