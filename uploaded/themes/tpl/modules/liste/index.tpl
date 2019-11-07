<!-- BEGIN index -->
	<br />
	<div align="right">
		<strong>
			&raquo; {index.LAST_MEMBER_IS} : 
			<a href="index.php?mods=espace_membre&amp;lien=profil&amp;id={index.LAST_MEMBER_ID}">
				{index.LAST_MEMBER_PSEUDO}
			</a>
		</strong>
	</div>
	<br /><br />
	<table border cellspacing="0">
		<tr align="center">
			<td width="120">
				<strong>
					<a href="index.php?mods=liste&amp;pseudo&amp;lien={index.PAGE_ACTUELLE}">
						{index.PSEUDO}
					</a>
				</strong>
			</td>
			<td width="150">
				<strong>
					<a href="index.php?mods=liste&amp;date&amp;lien={index.PAGE_ACTUELLE}">
						{index.DATE_INSCRIPTION}
					</a>
				</strong>
			</td>
			<td width="200">
				<strong>
					{index.LOCALISATION}
				</strong>
			</td>
			<td width="60">
				<strong>
					<a href="index.php?mods=liste&amp;post&amp;lien={index.PAGE_ACTUELLE}">
						{index.POSTS}
					</a>
				</strong>
			</td>
			<td width="120">
				<strong>
					{index.WEBSITE}
				</strong>
			</td>
		</tr>
		<!-- BEGIN index.mb -->
			<tr align="center">
				<td height="20%">
					<a href="index.php?mods=espace_membre&amp;page=profil&amp;id={index.mb.ID}">
						{index.mb.PSEUDO}
					</a>
				</td>
				<td height="20%">
					{index.mb.DATE}
				</td>
				<td height="20">
					{index.mb.LOCALISATION}
				</td>
				<td height="20">
					{index.mb.POSTS}
				</td>
				<td height="20">
					<a href="{index.mb.WEBSITE}">
						{index.mb.WEBSITE}
					</a>
				</td>
			</tr>
		<!-- END index.mb -->
		</table>
		<!-- BEGIN index.page -->
			<br />
			<center>
				{index.page.PAGE} :
				<!-- BEGIN index.page.pg -->
					<a href="{index.page.pg.URL}">
						<font size="{index.page.pg.SIZE}px">
							{index.page.pg.NM}
						</font>
					</a> 
					<!-- BEGIN index.page.pg.etc -->
						...
					<!-- END index.page.pg.etc -->
				<!-- END index.page.pg -->
			</center>
		<!-- END index.page -->
<!-- END index -->