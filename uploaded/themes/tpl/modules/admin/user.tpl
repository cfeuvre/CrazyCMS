<!-- BEGIN list -->
	<center>
		<br />
		<h2>
			<u>
				{list.MEMBERLIST}
			</u>
		</h2>
		<br /><br />
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=[0-9]">
			0-9
		</a> | 
		<a href="index.php?mods=admin&amp;page=user&amp;order=a">
			A
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=b">
			B
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=c">
			C
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=d">
			D
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=e">
			E
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=f">
			F
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=g">
			G
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=h">
			H
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=i">
			I
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=j">
			J
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=k">
			K
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=l">
			L
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=m">
			M
		</a>
		|
		<br />
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=n">
			N
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=o">
			O
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=p">
			P
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=q">
			Q
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=r">
			R
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=s">
			S
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=t">
			T
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=u">
			U
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=v">
			V
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=w">
			W
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=x">
			X
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=y">
			Y
		</a>
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=z">
		Z
		</a>
		|
		<br />
		| 
		<a href="index.php?mods=admin&amp;page=user&amp;order=all">
			{list.ALL}
		</a>
		|
		<br />
	</center>
	<br /><br />
	<a href="index.php?mods=admin&amp;page=user">
		{list.BACK}
	</a>
<!-- END list -->

<!-- BEGIN print_list -->
	<br />
	<center>
		<table width="95%" border cellspacing="0">
			<tr align="center">
				<td>
					<strong>
						{print_list.PSEUDO}
					</strong>
				</td>
				<td>
					<strong>
						{print_list.GRADE}
					</strong>
				</td>
				<td colspan="2">
					<strong>
						{print_list.ACTION}
					</strong>
				</td>
			</tr>
			<!-- BEGIN print_list.none -->
				<tr align="center">
					<td colspan="3">
						{print_list.none.NOMANY_MBR_TT}
					</td>
				</tr>
			<!-- END print_list.none -->
			<!-- BEGIN print_list.user -->
				<tr align="center">
					<td>
						{print_list.user.PSEUDO}
					</td>
					<td>
						{print_list.user.GRADE}
					</td>
					<td>
						<a href="index.php?mods=admin&amp;page=user&amp;del={print_list.user.ID}">
							<img alt="del" border="0" src="./themes/tpl/img/admin/del.gif">
						</a>
					</td>
					<td>
						<a href="index.php?mods=admin&amp;page=user&amp;user={print_list.user.ID}">
							<img alt="edit" border="0" src="./themes/tpl/img/admin/edit.gif">
						</a>
					</td>
				</tr>
			<!-- END print_list.user -->
		</table>
	</center>
	<br />
	<a href="index.php?mods=admin&amp;page=user&amp;list">
		{print_list.BACK}
	</a>
<!-- END print_list -->

<!-- BEGIN god_user -->
	<b>
		{god_user.TITLE} !</b><br />
	<br />
	<fieldset>
		<legend>{god_user.HOWTO} ?</legend>
		{god_user.TXT}
	</fieldset>
	<br />
	<a href="index.php?mods=admin">
		{god_user.BACK}
	</a>
<!-- END god_user -->

<!-- BEGIN text -->
	<br /><br />
		{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
<!-- END text -->

<!-- BEGIN ban -->
	<table>
		<tr>
			<td>
				{ban.PSEUDO}
			</td>
			<td>
				{ban.ACTIV}
			</td>
		</tr>
		<!-- BEGIN ban.user -->
			<tr>
				<td>
					{ban.user.PSEUDO}
				</td>
				<td>
					<a href="{ban.user.BAN_URL}{ban.user.ID}">
						{ban.user.ACTIV}
					</a>
				</td>
			</tr>
		<!-- END ban.user -->
	</table>
	<br />
	<a href="index.php?mods=admin">
		{ban.BACK}
	</a>
<!-- END ban -->

<!-- BEGIN ban_index -->
	<br />
		<ul>
			<li>
				<a href="index.php?mods=admin&page=user&amp;ban&amp;ban_user">
					{ban_index.BAN_A_USER}
				</a>
			</li>
		</ul>
		<br />
		<ul>
			<li>
				<a href="index.php?mods=admin&page=user&amp;ban&amp;unban_user">
					{ban_index.UNBAN_A_USER}
				</a>
			</li>
		</ul>
		<br /><br />
		<a href="index.php?mods=admin&amp;page=user">
			{ban_index.BACK}
		</a>
<!-- END ban_index -->

<!-- BEGIN index -->
	<br />
	<ul>
		<li>
			<a href="index.php?mods=admin&amp;page=user&amp;list">
				{index.MEMBER_LIST}
			</a>
		</li>
	</ul>
	<br />
	<ul>
		<li>
			<a href="index.php?mods=admin&amp;page=user&amp;ban">
				{index.BAN_MANAGE}
			</a>
		</li>
	</ul>
	<!-- BEGIN index.users_valid -->
		<br />
		<ul>
			<li>
				<a href="index.php?mods=admin&amp;page=user&amp;activ">
					USERS_NOT_VALIDATED
				</a>
			</li>
		</ul>
	<!-- END index.users_valid -->
	<br />
	<a href="index.php?mods=admin">
		{index.BACK}
	</a>
<!-- END index -->

<!-- BEGIN user_fiche -->
	{user_fiche.JS}
	<br />
	<form method = "post" action = "">
		<table align="center">
			<tr>
				<td>
					<strong>{user_fiche.PSEUDO}</strong> :
				</td>
				<td>
					<input type = "text" size="25" value = "{user_fiche.PSEUDO_VALUE}" name="ispseudo" id="ispseudo" onkeyup="verif_pseudo();"/><div id="pseudo_div"></div>
				</td>
			</tr>
			<tr>
				<td>
					<strong>{user_fiche.REGISTER_MAIL} :</strong> 
				</td>
				<td>
					<input type = "text" size="25" value = "{user_fiche.MAIL_VALUE}" name="isemail" id="isemail" onkeyup="verif_email();"/><div id="email_div"></div>	
				</td>
			</tr>
			<tr>
				<td>
					<strong>
						{user_fiche.NAME}
					</strong> : 
				</td>
				<td>
					<input type = "text" size="25" value = "{user_fiche.NAME_VALUE}" name="isname"/>
				</td>
			</tr>
			<tr>
				<td>
					<strong>{user_fiche.ICQ}:</strong>
				</td>
				<td>
					 <input type = "text" size="25" value = "{user_fiche.ICQ_VALUE}" name="isicq"/>
				</td>
			</tr>
			<tr>
				<td>
					<strong>{user_fiche.MSN} :</strong>
				</td>
				<td>
					
				<input type = "text" size="25" value = "{user_fiche.MSN_VALUE}" name="ismsn"/>
				
				</td>
			</tr>
			<tr>
				<td>
					<strong>{user_fiche.YAHOOM} :</strong> 
				</td>
				<td>
					
					<input type = "text" size="25" value = "{user_fiche.YAHOOM_VALUE}" name="isyahoom"/>
					
				</td>
			</tr>
			<tr>
				<td>
					<strong>{user_fiche.AIM} : </strong> 
				</td>
				<td>
					
					 <input type = "text" size="25" value = "{user_fiche.AIM_VALUE}" name="isaim"/>	
				</td>
			</tr>
			<tr>
				<td>
					<strong>{user_fiche.SITE} : </strong>
				</td>
				<td>
					<input type = "text" size="25" value = "{user_fiche.SITE_VALUE}" name="issite"/>
				</td>
			</tr>
			<tr>
				<td>
					<strong>{user_fiche.SIGN} :</strong> 
				</td>
				<td>
					{user_fiche.SIGN_VALUE}
				</td>
			</tr>
			<tr>
				<td>
					<strong>{user_fiche.PERSO_TITLE} :</strong> 
				</td>
				<td>
					<input type = "text" size="25" value = "{user_fiche.PERSO_TITLE_VALUE}" name="rank"/>
				</td>
			</tr>
			<tr>
				<td>
					<strong>{user_fiche.GRADE} : </strong>
				</td>
				<td>
					<select name="isgrade">
						<option value="not" selected="selected">
							{user_fiche.UPDATE_GRADE}
						</option>
						<!-- BEGIN user_fiche.grade -->
							<option value="{user_fiche.grade.ID}" {user_fiche.grade.SELECTED}>
								{user_fiche.grade.NAME}
							</option>
						<!-- END user_fiche.grade -->
						<option value="5">
							{user_fiche.BAN}
						</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<i>
						{user_fiche.HERITED_PERMISSION} !
						{user_fiche.TO_SEE_GO_TO} 
							<a href="./index.php?mods=admin&amp;page=grade">
								 {user_fiche.GRADES_ADMINIS}
							</a>
					</i>
				</td>
			</tr>
			<tr>
				<td>
					<strong>{user_fiche.THEME} : </strong>
				</td>
				<td>
					<select name="istheme">
						<!-- BEGIN user_fiche.theme -->
							<option value="{user_fiche.theme.NAME}" {user_fiche.theme.SELECTED}>
								{user_fiche.theme.NAME}
							</option>
						<!-- END user_fiche.theme -->
					</select>
				</td>
			</tr>
		</table>
		<br /><br />
		<center>
			<input type="submit" value="{user_fiche.VALID}" />
			<input type="hidden" name="valider1"  value="valider1">
		</center>
	</form>
	<br /><hr /><br />
	<form method="post" action="">
		<input type="hidden" name="permission" value="permission" />
		<table style="width:100%;">
			<tr>
				<td colspan="2">
					<b>
						<u>
							{user_fiche.THE_PERMISSIONS} : 
						</u>
					</b>
					<br /><br />
				</td>
			</tr>
			<!-- BEGIN user_fiche.perm -->
				<tr>
					<td>
						{user_fiche.perm.DESC}
					</td>
					<td>
						<input type="checkbox" {user_fiche.perm.CHECKED} name="{user_fiche.perm.NAME}" value="1" />
					</td>
				</tr>
				<!-- BEGIN user_fiche.perm.element -->
					<tr>
						<td colspan="2">
							<br /><hr /><br />
						</td>
					</tr>
				<!-- END user_fiche.perm.element -->
			<!-- END user_fiche.perm -->
			<tr>
				<td colspan="2">
					<center>
						<input type="submit" value="{user_fiche.VALID}" />
					</center>
				</td>
			</tr>
		</table>
	</form>
	<br />
	<a href="index.php?mods=admin">{user_fiche.BACK}</a>
<!-- END user_fiche -->