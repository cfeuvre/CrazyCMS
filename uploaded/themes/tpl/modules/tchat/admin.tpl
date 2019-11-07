<!-- BEGIN index -->
	<noscript>
		<font color="red">
			<p style="text-align:center;">
				<b>
					{index.NO_JS}
				</b>
			</p>
		</font>
	</noscript>
	<br />
	<center>
		<table style="width:80%;">
			<tr>
				<td>
					<p style="text-align: center;">
						<a href="index.php?mods=tchat&amp;page=admin&amp;manage">
							<img src="./themes/tpl/img/tchat/manage.png" alt="{index.MANAGE_SALONS}" width="128" />
						</a>
					</p>
				</td>
				<td>
					<p style="text-align: center;">
						<a href="index.php?mods=tchat&amp;page=admin&amp;create">
							<img src="./themes/tpl/img/tchat/add.png" alt="{index.ADD_SALONS}" width="128" />
						</a>
					</p>
				</td>
				<td>
					<p style="text-align: center;">
						<a href="index.php?mods=tchat&amp;page=admin&amp;config">
							<img src="./themes/tpl/img/tchat/config.png" alt="{index.CONFIG_CHAT}" width="128" />
						</a>
					</p>
				</td>
			</tr>
			<tr>
				<td>
					<p style="text-align: center;">
						{index.MANAGE_SALONS}
					</p>
				</td>
				<td>
					<p style="text-align: center;">
						{index.ADD_SALONS}
					</p>
				</td>
				<td>
					<p style="text-align: center;">
						{index.CONFIG_CHAT}
					</p>
				</td>
			</tr>
		</table>
	</center>
	<br /><br />
	<a href="index.php?mods=admin">
		{index.BACK}
	</a>
<!-- END index -->

<!-- BEGIN config_form -->
	<form method="post" action="">
		{config_form.MESS_NBR_TO_PRINT} :
			<input type="text" name="mess_nbr" value="{config_form.MESS_NBR_TO_PRINT_VALUE}" />
		<br /><br />
		<center>
			<input type="submit" value="{config_form.VALID}" />
		</center>
	</form><br /><br />
	<a href="index.php?mods=tchat&amp;page=admin">
		{config_form.BACK}
	</a>
<!-- END config_form -->

<!-- BEGIN text -->
	<br /><br />
		{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
<!-- END text -->

<!-- BEGIN create_form -->
	<script type="text/javascript">
		<!--
			function upd_field(){
				document.getElementById('priv_pass').innerHTML = '<br />{create_form.PASSWORD} :<br />&nbsp;&nbsp;<input type="text" name="password"/>';
			}
		-->
	</script>
	<form method="post" action="">
		<center>
			<table style="width:60%;" border="0">
				<tr>
					<td style="width:50%;">
						<b>{create_form.SALON_NAME}</b>
					</td>
					<td style="width:50%;">
						<input type="text" name="salle" value="" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<br /><br />
						<p style="text-align : center;">
							<b>{create_form.SALON_TYPE}</b>
						</p>
					</td>
				</tr>
				<tr>
					<td>
						<p style="text-align : center;">
							<fieldset>
								<input type="radio" onclick="document.getElementById('priv_pass').innerHTML = '';" name="type" value="1" checked="true"/>{create_form.CHAT_PUBLIC}
							</fieldset>
						</p>
					</td>
					<td>
						<p style="text-align : center;">
							<fieldset>
								<input type="radio" onclick="upd_field();" name="type" value="0" />{create_form.CHAT_PRIVATE}
								<div id="priv_pass"></div>
							</fieldset>
						</p>
					</td>
				</tr>
				<tr>
					<td>
						<p style="text-align : center;">
							{create_form.WELCOME_MESS}
						</p>
					</td>
					<td>
						<p style="text-align : center;">
							<input type="text" name="welcome" value="{create_form.WELCOME_TO_THIS}" size="28"/>
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<p style="text-align : center;">
							<input type="submit" value="{create_form.CREATE_THIS_SALON}" size="40"/>
						</p>
					</td>
				</tr>
			</table>
		</center>
	</form>
	<br /><br />
	<a href="index.php?mods=tchat&amp;page=admin">
		{create_form.BACK}
	</a>
<!-- END create_form -->

<!-- BEGIN confirm_private -->
	{confirm_private.CONFIRM_SECURE_SALON} : {confirm_private.NAME}<br /><br />
	<form method="post" action="">
		<input type="radio" name="confirm" value="0" checked="true" />{confirm_private.NO}
		<br />					
		<input type="radio" name="confirm" value="1" />{confirm_private.YES}
		<br /><br />
		{confirm_private.PASSWORD} <input type="text" name="password" value="{confirm_private.PASSWORD}" />
		<br /><br /> 
		<input type="submit" value="{confirm_private.CONFIRM}" />
	</form>
<!-- END confirm_private -->

<!-- BEGIN confirm_public -->
	{confirm_public.CONFIRM_PUBLICED_SALON} : {confirm_public.NAME}<br /><br />
	<form method="post" action="">
		<input type="radio" name="confirm" value="0" checked="true" />{confirm_public.NO}
		<br />					
		<input type="radio" name="confirm" value="1" />{confirm_public.YES}
		<br /><br />
		<input type="submit" value="{confirm_public.CONFIRM}" />
	</form>
<!-- END confirm_public -->

<!-- BEGIN confirm_del -->
	{confirm_del.CONFIRM} : {confirm_del.NAME}<br /><br />
	<form method="post" action="">
		<input type="radio" name="confirm" value="0" checked="true" />{confirm_del.NO}
		<br />					
		<input type="radio" name="confirm" value="1" />{confirm_del.YES}
		<br /><br />
		<input type="submit" value="{confirm_del.CONFIRM}" />
	</form>
<!-- END confirm_del -->

<!-- BEGIN admin -->
	<script type="text/javascript">
		<!--
			function cde(salon){
				if ( document.getElementById ( salon ).style.visibility== "visible" ){
					document.getElementById ( salon ).style.visibility= "hidden";
					document.getElementById ( salon ).style.height= "0px";
				}
				else{
					document.getElementById ( salon ).style.visibility= "visible";
					document.getElementById ( salon ).style.height= "";
				}
			}
		-->
	</script>
	<table border="0" style="width:80%;text-align:center;">
		<tr>
			<td style="width:40%;">
				<b>{admin.PUBLIC_SALON}</b><br /><br />
			</td>
			<td style="width:40%;">
				<b>{admin.PRIVATE_SALON}</b><br /><br />
			</td>
		</tr>
		<tr>
			<td style="width:40%;">
				<fieldset style="background-color: white;" onclick="cde('default' );" onmouseover="this.style.background='#A9A9A9';" onmouseout="this.style.background='white';">
					<b><u>{admin.DEFAULT_SALON}</u></b>
					<div id="default" style="visibility: hidden;height:0px;">
						<table border="0" style="width:100%;text-align:center;">
							<tr>
								<td colspan="2">
									<br />
									<fieldset>
										<legend>
											{admin.WELCOME_MESS}
										</legend>
										<form method="post" action="">
											<input type="text" onclick="cde('default' );" size="40" name="pub_welcome" value="{admin.WELCOME_VALUE}" />
											<input type="hidden" name="salon" value="default" /><br /><br />
											<input type="submit" value="{admin.UPDATE}" width="35" />
										</form>
									</fieldset>
								</td>
							</tr>
						</table>
					</div>
				</fieldset><br />
				<!-- BEGIN admin.none_pub -->
					{admin.none_pub.TXT}<br />
				<!-- END admin.none_pub -->
				<!-- BEGIN admin.pub -->
					<fieldset style="background-color: white;" onclick="cde('pub{admin.pub.SALON}' );" onmouseover="this.style.background='#A9A9A9';" onmouseout="this.style.background='white';">
						<b>
							<u>
								{admin.pub.SALON_NAME}
							</u>
						</b>
						<div id="pub{admin.pub.SALON}" style="visibility: hidden;height:0px;">
							<table border="0" style="width:100%;text-align:center;">
								<tr>
									<td colspan="2">
										<br />
										<fieldset>
											<legend>
												{admin.pub.WELCOME_MESS}
											</legend>
											<form method="post" action="">
												<input type="text" onclick="cde('pub{admin.pub.SALON}' );" size="40" name="pub-welcome" value="{admin.pub.WELCOME_VALUE}" />
												<input type="hidden" name="salon" value="{admin.pub.SALON}" /><br /><br />
												<input type="submit" value="{admin.pub.UPDATE}" width="35" />
											</form>
										</fieldset>
									</td>
								</tr>
								<tr>
									<td>
										<fieldset>
											<legend>{admin.pub.DELETE}</legend>
											<a href="index.php?mods=tchat&amp;page=admin&amp;manage&amp;del_pub={admin.pub.SALON}">
												<img src="./themes/tpl/img/tchat/delete.png" alt="{admin.pub.DELETE}" width="30" border="0"/>
											</a>
										</fieldset>
									</td>
									<td>
										<fieldset>
											<legend>{admin.pub.BE_PRIVATE}</legend>
											<a href="index.php?mods=tchat&amp;page=admin&amp;manage&amp;move_pub={admin.pub.SALON}">
												<img src="./themes/tpl/img/tchat/private.png" border="0" alt="{admin.pub.BE_PRIVATE}" width="30"/>
											</a>
										</fieldset>
									</td>
								</tr>
							</table>
						</div>
					</fieldset><br />
				<!-- END admin.pub -->
			</td>
			<td style="width:40%;">	
				<!-- BEGIN admin.none_pri -->
					{admin.none_pri.TXT}<br />
				<!-- END admin.none_pri -->
				<!-- BEGIN admin.pri -->
						<fieldset style="background-color: white;" onclick="cde('pri{admin.pri.SALON}' );" onmouseover="this.style.background='#A9A9A9';" onmouseout="this.style.background='white';">
							<b>
								<u>
									{admin.pri.SALON_NAME}
								</u>
							</b>
							<div id="pri{admin.pri.SALON}" style="visibility: hidden;height:0px;">
								<table border="0" style="width:100%;text-align:center;">
									<tr>
										<td colspan="2">
											<br />
											<fieldset>
												<legend>
													{admin.pri.WELCOME_MESS}
												</legend>
												<form method="post" action="">
													<input type="text" onclick="cde('pri{admin.pri.SALON}' );" size="40" name="pri_welcome" value="{admin.pri.WELCOME_VALUE}" />
													<input type="hidden" name="salon" value="{admin.pri.SALON}" /><br /><br />
													<input type="submit" value="{admin.pri.UPDATE}" width="35" />
												</form>
											</fieldset>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<fieldset>
												<legend>
													{admin.pri.PASSWORD}
												</legend>
												<form method="post" action="">
													<input type="text" onclick="cde('pri{admin.pri.SALON}' );" size="40" name="pri_pass" value="" />
													<input type="hidden" name="salon" value="{admin.pri.SALON}" /><br /><br />
													<input type="submit" value="{admin.pri.UPDATE}" width="35" />
												</form>
											</fieldset>
										</td>
									</tr>
									<tr>
										<td>
											<fieldset>
												<legend>{admin.pri.DELETE}</legend>
												<a href="index.php?mods=tchat&amp;page=admin&amp;manage&amp;del_pri={admin.pri.SALON}">
													<img src="./themes/tpl/img/tchat/delete.png" alt="{admin.pri.DELETE}" width="30" border="0"/>
												</a>
											</fieldset>
										</td>
										<td>
											<fieldset>
												<legend>{admin.pri.BE_PUBLIC}</legend>
												<a href="index.php?mods=tchat&amp;page=admin&amp;manage&amp;move_pri={admin.pri.SALON}">
													<img src="./themes/tpl/img/tchat/private.png" border="0" alt="{admin.pri.BE_PUBLIC}" width="30"/>
												</a>
											</fieldset>
										</td>
									</tr>
								</table>
							</div>
						</fieldset><br />
				<!-- END admin.pri -->
			</td>
		</tr>
	</table>
	<br /><br />
	<a href="index.php?mods=tchat&amp;page=admin">
		{admin.BACK}
	</a>
<!-- END admin -->