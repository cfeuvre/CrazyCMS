<!-- BEGIN index -->
	<input name="" id="pseudo_tmp" style="visibility:hidden;height:0px;"  />
	<input name="" id="pass_tmp" style="visibility:hidden;height:0px;"  />
	<input name="" id="email_tmp" style="visibility:hidden;height:0px;" />
	<input name="" id="secu_tmp" style="visibility:hidden;height:0px;" />
	
	{index.JS}
	
	<form action = "./index.php?mods=register&amp;page=valid" method="post">
		<fieldset style="width:96%;">
			<legend>
				{index.REGISTER_DEF}
			</legend>
			<br />
			<table style="width:96%;">
				<tr>
					<td>
						{index.REGISTER_PSEUDO} : 
					</td>
					<td>
						<input id="pseudo" type="text" name="register_pseudo" value="{index.REGISTER_PSEUDO}" onblur="verif_pseudo();" onfocus="effacer_champ('{index.REGISTER_PSEUDO}','pseudo' );"/>
						<div id="pseudo_div"></div>
					</td>
				</tr>
				<tr>
					<td>
						{index.REGISTER_PASS} : 
					</td>
					<td>
						<input id="pass1" type="password" name="register_pass" value="{index.REGISTER_PASS}" onkeyup="verif_pass();"  onfocus="effacer_champ('{index.REGISTER_PASS}','pass1' );"/>
					</td>
				</tr>
				<tr>
					<td>
						{index.REGISTER_PASS2} : 
					</td>
					<td>
						<input id="pass2" type="password" name="register_pass2" value="{index.REGISTER_PASS2}" onkeyup="verif_pass();"  onfocus="effacer_champ('{index.REGISTER_PASS2}','pass2' );" />
						<div id="different"></div>
					</td>
				</tr>
				<tr>
					<td>
						{index.REGISTER_MAIL} : 
					</td>
					<td>
						<input id="email" type="text" name="register_email" value="{index.REGISTER_MAIL}" onkeyup="verif_email();" onfocus="effacer_champ('{index.REGISTER_MAIL}','email' );" />
						<div id="email_div"></div>
					</td>
				</tr>
				<!-- BEGIN index.secu -->
					<tr>
						<td>
							{index.secu.REGISTER_CODE_DEF} : 
							<img src="./mods/register/image.php" alt="Erreur"/>
						</td>
						<td>
							<input id="scode" type="text" name="register_code" value="{index.secu.REGISTER_CODE}" onkeyup="verif_code();" onfocus="effacer_champ('{index.secu.REGISTER_CODE}','code' );"/>
							<div id="code_div"></div>
						</td>
					</tr>
				<!-- END index.secu -->
				<tr>
					<td colspan="2">
						<center>
							<input id="submit" type="submit" value="{index.VALID}"/>
						</center>
					</td>
				</tr>
			</table>
			<!-- BEGIN index.nsecu -->
				{index.nsecu.JS}
			<!-- END index.nsecu -->
		</fieldset>	
	</form>
	<textarea id="email" style="visibility:hidden;height:0px;width:50px;"></textarea>
<!-- END index -->