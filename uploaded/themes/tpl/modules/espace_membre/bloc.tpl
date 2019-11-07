<!-- DEFAULT HEAD ~BLOC_ESPACE_MEMBRE_TITLE~ -->
	<!-- BEGIN espace_membre_bloc_connect -->
		<form action = "./session.php" method="post">
			<div align="center">
				<table width="75%">
					<tr>
						<td align="left">
							<strong>
								&raquo; {espace_membre_bloc_connect.PSEUDO} : 
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
								&raquo; {espace_membre_bloc_connect.PASSWORD} : 
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
							{espace_membre_bloc_connect.TO_REMEMBER} <input type="checkbox" name="auto" value="on" />
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<br />
							<center>	
								<input type="hidden" name="theme" value="{espace_membre_bloc_connect.THEME}" />
								<input type="hidden" name="lang" value="{espace_membre_bloc_connect.LANG}" />
								<input type="hidden" name="u" value="{espace_membre_bloc_connect.URL}" />
								<input type="submit" value="{espace_membre_bloc_connect.VALID}" />
							</center>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<br />
							<center>	
								<a href="index.php?mods=espace_membre&page=mdp">
									{espace_membre_bloc_connect.FORGETTED_PASSWORD}
								</a>
							</center>
						</td>
					</tr>
				</table>
			</div>
		</form>
	<!-- END espace_membre_bloc_connect -->
	<!-- BEGIN espace_membre_bloc_connected -->
		<br />
		<p style="text-align:center">
			{espace_membre_bloc_connected.WELCOME} 
			<strong>
				{espace_membre_bloc_connected.PSEUDO}
			</strong>
			<br /><br /><br />
			<a href="index.php?mods=espace_membre&amp;page=infos">
				<img border="0" src="{espace_membre_bloc_connected.AVATAR}" alt="Avatar" width="{espace_membre_bloc_connected.WIDTH}" height="{espace_membre_bloc_connected.HEIGHT}"/>
			</a>
			<br /><br />
			<a href="./session.php?unlog={espace_membre_bloc_connected.UID}&pass=d8b{espace_membre_bloc_connected.PWD}" title="{espace_membre_bloc_connected.UNLOG}">
				{espace_membre_bloc_connected.UNLOG}
			</a><br />
			<a href="./index.php?mods=espace_membre" title="{espace_membre_bloc_connected.SPACEMEMBER}">
				{espace_membre_bloc_connected.SPACEMEMBER}
			</a>
		</p>
		<br /> <br />
		<!-- BEGIN espace_membre_bloc_connected.mps -->
			-<a href="index.php?mods=espace_membre&amp;page=look" title="{espace_membre_bloc_connected.mps.TITLE}"><strong><font color="#c00000">{espace_membre_bloc_connected.mps.NB}</font></strong> {espace_membre_bloc_connected.mps.NEW} </a><br />
		<!-- END espace_membre_bloc_connected.mps -->
			- <a href="index.php?mods=espace_membre&amp;page=look">{espace_membre_bloc_connected.ARCH} {espace_membre_bloc_connected.READED}</a><br />
			- <a href="index.php?mods=espace_membre&amp;page=mess">{espace_membre_bloc_connected.SEND}</a><br />
			- <a href="index.php?mods=espace_membre&amp;page=note">{espace_membre_bloc_connected.BLOCNOTE}</a><br />
			- <a href="index.php?mods=espace_membre&amp;page=param">{espace_membre_bloc_connected.CONFIG}</a><br />
	<!-- END espace_membre_bloc_connected -->
<!-- DEFAULT FOOT -->