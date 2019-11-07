<!-- BEGIN index -->
	<center>
		{index.JS}
		<br />
		<div align="right">
			<a href="index.php?mods=espace_membre&amp;page=aide">
				<img src="./themes/tpl/img/profil/aide.gif" alt="{index.SPACEMEMBER_HELP}" border="0"/>
			</a>
		</div>
		<table width="75%">
			<tr>
				<td>
					<fieldset>
						<legend>
							<strong>
								<font color="#c00000">
									{index.PERSONNAL_INFOS}
								</font>
							</strong>
						</legend>
						<div align="right">
							<h3>
								<u>
									{index.YOUR_FICHE}
								</u>
							</h3>
						</div>
						<table width="75%" >
							<tr>
								<td align="left">
									<strong>
										{index.PSEUDO} :
									</strong>
								</td>
								<td align="left"> 
									{index.PSEUDO_VALUE}
								</td>
							</tr>
							<tr>
								<td align="left">
									<strong>
										{index.NAME} :
									</strong>
								</td>
								<td align="left">
									{index.NAME_VALUE}
								</td>
							</tr>
							<tr>
								<td align="left">
									<strong>
										{index.MY_MAIL_ADRESS} :
									</strong>
								</td>
								<td align="left">
									{index.MY_MAIL_ADRESS_VALUE} 
								</td>
							</tr>
							<tr>
								<td align="left">
									<strong>
										{index.INSCRIPTION_DATE} :
									</strong>
								</td>
								<td align="left">
									{index.INSCRIPTION_DATE_VALUE}
								</td>
							</tr>
						</table>
						<br />
						<center>
							<a href="index.php?mods=espace_membre&amp;page=profil&amp;id={index.UID}">
								{index.MY_COMPLETE_FICHE}
							</a>
						</center>
						<br />
						<p style="text-align:center;">
							<input type="button" value="{index.PURPOSE_A_NEWS}" onclick="redir('index.php?mods=news&page=propos' );" />
							<input type="button" value="{index.SEE_UR_PROFILE}" onclick="redir('index.php?mods=espace_membre&page=profil&id={index.UID}');" />
						</p>			
					</fieldset>
				</td>
			</tr>
		</table>
		<br />
		<table width="75%">
			<tr>
				<td>
					<fieldset>
						<legend>
							<strong>
								<font color="#c00000">
									{index.MESSAGERIE}
								</font>
							</strong>
						</legend>
						<div align="right">
							<h3>
								<u>
									{index.YOUR_MESSAGERIE}
								</u>
							</h3>
						</div>
						<h5>
							- {index.YOU_HAVE}
							<a href="index.php?mods=espace_membre&amp;page=look">
								<strong>
									<font color="#c00000">
										{index.NON_LU}
									</font>
								</strong> 
								{index.NEW_MP}
							</a>
							<br />
							- {index.YOU_HAVE} 
							<strong>
								<font color="#202040">
									{index.LU}
								</font>
							</strong>
							 {index.ARCHIVED_MP}
						</h5>
						<p style="text-align:center;"> 
							<input type="button" value="{index.SEE_MY_MP}"  onclick="redir('index.php?mods=espace_membre&page=look' );" />
							<input type="button" value="{index.SEND_A_MP}" onclick="redir('index.php?mods=espace_membre&amp;page=mess' );" />
						</p>
					</fieldset>
				</td>
			</tr>
		</table>
		<br />
		<!-- BEGIN index.admin -->
			<table width="75%">
				<tr>
					<td>
						<fieldset>
							<legend>
								<strong>
									<font color="#c00000">
										{index.admin.ADMINISTRATION}
									</font>
								</strong>
							</legend>
							<!-- BEGIN index.admin.cat -->
								<a href="index.php?mods={index.admin.cat.FILE}&amp;page=admin" title="{index.admin.cat.FILE}">
									<img border="0" width="60" src="./mods/{index.admin.cat.FILE}/images/admin.png" alt="{index.admin.cat.FILE}" />
								</a>
							<!-- END index.admin.cat -->
						</fieldset>
					</td>
				</tr>
			</table>
		<!-- END index.admin -->
	</center>
<!-- END index -->