<!-- BEGIN index -->
	<div onmousemove="movemouse(event);">
	<script type="text/javascript" src="./mods/tchat/tchat.js"></script>
	<!-- Textarea contenant infos temporaires du tchat -->
	<textarea rows="0" cols="0" id="last_date" style="height:0px;visibility:hidden;width:0px;"></textarea>
	<textarea rows="0" cols="0" id="users_liste" style="height:0px;visibility:hidden;width:0px;"></textarea>
	<textarea rows="0" cols="0" id="arrivee" style="height:0px;visibility:hidden;width:0px;"></textarea>
	<textarea rows="0" cols="0" id="departs" style="height:0px;visibility:hidden;width:0px;"></textarea>
	<br />
	<noscript>
		{index.NO_JS}
	</noscript>
	<br />
	<table width="100%">
		<tr>
			<td width="80%">
				<div style="overflow:auto;height:300px;" id="contenu_tchat"></div>
			</td>
			<td width="20%">
				<div id="currents_user" style="overflow:auto;" ></div>
				<br />
				<fieldset>
					<u>
						{index.PUBLIC_SALON} : 
					</u>
					<br /><br />
					<a href="index.php?mods=tchat">
						{index.DEFAULT_SALON}
					</a><br />
					
					<!-- BEGIN index.pubs -->
						<a href="{index.pubs.URL}">
							{index.pubs.TXT}
						</a>
						<br />
					<!-- END index.pubs -->
					<!-- BEGIN index.npubs -->
						{index.npubs.TXT}
						<br />
					<!-- END index.npubs -->
				</fieldset>
				<br />
				<fieldset>
					<u>
						{index.PRIVATE_SALON} : 
					</u>
					<br /><br />
					<!-- BEGIN index.privs -->
						<a href="{index.privs.URL}">
							{index.privs.TXT}
						</a>
						<br />
					<!-- END index.privs -->
					<!-- BEGIN index.nprivs -->
						{index.nprivs.TXT}
						<br />
					<!-- END index.nprivs -->
				</fieldset>
			</td>
		</tr>
	</table>
	<div onmousedown="move(document.getElementById('smilies'), event);" style="visibility:hidden;position:absolute;top:360px;left:50px;z-index:2" id="smilies"></div>
	<hr style="width: 95%;"/>
	<table style="width:30%;">
		<tr>
			<td>
				<a href="javascript:view_smilies('{index.SMILIES}' );">
					<img width="25" src="./smileys/d.gif" alt="{index.SMILIES}" border="0" />
				</a> 
			</td>
			<td>
				<a href="javascript:load_son();">
					<img src="./themes/tpl/img/tchat/son.png" border="0" id="son_pic" alt="" width="30"/>
				</a>
			</td>
			<td>
				<div id="loading"></div>
			</td>
		</tr>
	</table>
	<br />
	<hr style="width: 95%;"/>
	<!-- BEGIN index.cant_add -->
		<br />
		<p align="center">
			{index.cant_add.POST_FORBIDDEN}
		</p>
	<!-- END index.cant_add -->
	<!-- BEGIN index.add -->
		<form method="post" action="">
			{index.add.ADD_MESSAGE}	:
			<textarea style="width: 95%;" rows="0" cols="0" onkeypress="if (event.keyCode==13 && event.shiftKey==false) add('{index.add.UID}','{index.add.PSEUDO}', '{index.add.U_PWD}', '{index.add.SALLE}', '{index.add.PASS}' );" name="message" id="message"></textarea>
			<input type="hidden" name="time" value="{index.add.TIME}" />
			<input type="button" onclick="add('{index.add.UID}','{index.add.PSEUDO}', '{index.add.U_PWD}', '{index.add.SALLE}', '{index.add.PASS}' );" value="{index.add.VALID}" id="submitb" />
		</form>
	<!-- END index.add -->
		<script type="text/javascript">
			load();
			//On lance la fonction verif afin de commencer a charger les messages et pour lancer la boucle infinie ;)
			verif('{index.UID}','{index.PSEUDO}','{index.SALLE}','{index.U_PWD}', '{index.PASS}', '{index.CONNECTS}', '{index.IS_COME}','{index.ARE_COME}','{index.IS_LEFT}','{index.ARE_LEFT}', '{index.FUSEAUX}', '{index.LANGUE}', '{index.TRUE}', '{index.DATE_FORMAT}' , '{index.THEME}' );
		</script>
		</div>
		<div id="sound" style="height:0px;overflow:auto;visibility:hidden;"></div>
<!-- END index -->