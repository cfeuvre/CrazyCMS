<!-- BEGIN admin_index -->
	<br />
	<a href="index.php?mods=forum&amp;page=admin&amp;manage">
			{admin_index.MANAGE_CATS}
		</a>
		<br /><br />
		<a href="index.php?mods=forum&amp;page=admin&amp;manage_rank">
			{admin_index.MANAGE_RANKS}
		</a>
		<br /><br />
		<a href="index.php?mods=forum&amp;page=admin&amp;rules">
			{admin_index.MANAGE_RULES}
		</a>
		<br /><br />
		<a href="index.php?mods=forum&amp;page=admin&amp;mails">
			{admin_index.MANAGE_MAILS}
		</a>
		<br /><br /><br />
		<fieldset>
			<legend>
				{admin_index.FORUM_OPTION}
			</legend>
			<!-- BEGIN admin_index.anti_flood_time -->
					<font color="green">
						{admin_index.anti_flood_time.TXT}
					</font>
				<br />
			<!-- END admin_index.anti_flood_time -->
			<!-- BEGIN admin_index.forum_nb_reponses_page -->
					<font color="green">
						{admin_index.forum_nb_reponses_page.TXT}
					</font>
				<br />
			<!-- END admin_index.forum_nb_reponses_page -->
			<!-- BEGIN admin_index.forum_nb_topic_page -->
					<font color="green">
						{admin_index.forum_nb_topic_page.TXT}
					</font>
				<br />
			<!-- END admin_index.forum_nb_topic_page -->
			<!-- BEGIN admin_index.reputation -->
				<br />
					<font color="green">
						{admin_index.reputation.TXT}
					</font>
				<br />
			<!-- END admin_index.reputation -->
			<!-- BEGIN admin_index.ranks -->
				<br />
					<font color="green">
						{admin_index.ranks.TXT}
					</font>
				<br />
			<!-- END admin_index.ranks -->

			<form method="post" action="">
				{admin_index.MINIMAL_FLOOD_TIME}
				<input type="text" name="flood" value="{admin_index.MINIMAL_FLOOD_TIME_VALUE}" /><br />
				{admin_index.NB_REP}
				<input type="text" name="forum_nb_reponses_page" value="{admin_index.NB_REP_VALUE}" /><br />
				{admin_index.NB_TOPIC}
				<input type="text" name="forum_nb_topic_page" value="{admin_index.NB_TOPIC_VALUE}" /><br />
				<p style="text-align:center;"><input type="submit" value="{admin_index.VALID}" /></p>
			</form><br />
			<form method="post" action="">
				{admin_index.ENABLE_REPUTATION}
				<input type="radio" name="reputation" value="1" {admin_index.ENABLE_REPUTATION_TRUE}/>OUI
				<input type="radio" name="reputation" value="0" {admin_index.ENABLE_REPUTATION_FALSE}/>NON
				<input type="submit" value="Valider" />
			</form><br />
			<form method="post" action="">
				{admin_index.ENABLE_RANKS}
				<input type="radio" name="ranks" value="1" {admin_index.ENABLE_RANKS_TRUE}/>OUI
				<input type="radio" name="ranks" value="0" {admin_index.ENABLE_RANKS_FALSE}/>NON
				<input type="submit" value="Valider" />
			</form><br />
			<a href="index.php?mods=forum&amp;page=admin&amp;actu_post">
				<font color="{admin_index.ACTU_POST_LINK_COLOR}">
					{admin_index.ACTU_POST_LINK}
				</font>
			</a>
			<br /></fieldset>
			<br />
			<a href="index.php?mods=admin">
				{admin_index.BACK}
			</a>
<!-- END admin_index -->

<!-- BEGIN admin_param -->
	<br /><br />
	<form method="post" action="">
		{admin_param.CONTENU}
	</form>
	<br /><br />
	<a href="index.php?mods=forum&amp;page=admin">
		{admin_param.BACK}
	</a>
<!-- END admin_param -->

<!-- BEGIN admin_mails -->
	<br /><br />
		<a href="index.php?mods=forum&amp;page=admin&amp;mails&amp;topic">
			 - {admin_mails.EDIT_MAIL_TOPIC}
		</a>
		<br /><br />
		<a href="index.php?mods=forum&amp;page=admin&amp;mails&amp;topic">
			 - {admin_mails.EDIT_MAIL_REPLY}
		</a>
	<br /><br />
	<a href="index.php?mods=forum&amp;page=admin">
		{admin_mails.BACK}
	</a>
<!-- END admin_mails -->

<!-- BEGIN admin_ranks_index -->
	<table border="0" style="width: 98%;">
		<tr>
			<td>
				{admin_ranks_index.AVAILABLE_RANKS}<br /><br />
			</td>
			<td colspan="3">
				{admin_ranks_index.POST_NEEDED}
			</td>
		</tr>
		<!-- BEGIN admin_ranks_index.none -->
			<tr>
				<td colspan="4">
					{admin_ranks_index.none.TXT}<br /><br />
				</td>
			</tr>
		<!-- END admin_ranks_index.none -->
		<!-- BEGIN admin_ranks_index.rank -->
			<tr>
				<td>
					{admin_ranks_index.rank.NAME}
				</td>
				<td>
					{admin_ranks_index.rank.NB_POSTS}
				</td>
				<td>
					<a href="{admin_ranks_index.rank.EDIT_URL}">
						{admin_ranks_index.rank.EDIT}
					</a>
				</td>
				<td>
					<a href="{admin_ranks_index.rank.DELETE_URL}">
						{admin_ranks_index.rank.DELETE}
					</a>
				</td>
			</tr>
		<!-- END admin_ranks_index.rank -->
	</table>
	<br /><br />
	<a href="./index.php?mods=forum&amp;page=admin&amp;manage_rank&amp;add_rank">
		{admin_ranks_index.ADD_RANK}
	</a>
	<br /><br />
	<a href="./index.php?mods=forum&amp;page=admin">
		{admin_ranks_index.BACK}
	</a>
<!-- END admin_ranks_index -->
<!-- BEGIN admin_ranks_mess -->
	{admin_ranks_mess.TXT}<br /><br />
	<a href="index.php?mods=forum&amp;page=admin&amp;manage_rank">
		{admin_ranks_mess.BACK}
	</a>
<!-- END admin_ranks_mess -->
<!-- BEGIN admin_ranks_form -->
	<br />
	<form method="post" action="">
		{admin_ranks_form.RANK_NAME} : <input type="text" name="name" value="{admin_ranks_form.RANK_NAME_VALUE}" /><br /><br />
		{admin_ranks_form.POST_NEEDED} : <input type="text" name="nb_posts" value="{admin_ranks_form.POST_NEEDED_VALUE}" />
		<br /><br />
		<center>
			<input type="submit" value="{admin_ranks_form.VALID}" />
		</center>
	</form>
<!-- END admin_ranks_form -->

<!-- BEGIN admin_manage -->
	<noscript>
		<font color="red">
			{admin_manage.NO_JS}
		</font>
		<br />
	</noscript>
	{admin_manage.JS}
	<br />
	<a href="index.php?mods=forum&amp;page=admin&amp;add&amp;cat">
		{admin_manage.ADD_A_CAT}
	</a><br /><br />
	<table width="99%" border cellpadding="0" cellspacing="0">
		<tr bgcolor="#808080">
			<td width="25%">
				<div style="font-size:12px; font-weight:bold; color:#FFFFFF;">
					{admin_manage.TITLE}
				</div>
			</td>
			<td width="25%">
				<div style="font-size:12px; font-weight:bold; color:#FFFFFF;">
					{admin_manage.ACTION_TO_DO}
				</div>
			</td>
			<td width="40%">
				<div style="font-size:12px; font-weight:bold; color:#FFFFFF;">
					{admin_manage.STATUS_AND_TOPIC}
				</div>
			</td>
			<td width="10%">
				<div style="font-size:12px; font-weight:bold; color:#FFFFFF;">
					{admin_manage.POSITION}
				</div>
			</td>
		</tr>
	</table>
	
	<!-- BEGIN admin_manage.none -->
		<br />
		<b>
			{admin_manage.none.NONE_CATS}
		</b>
	<!-- END admin_manage.none -->
	
	<!-- BEGIN admin_manage.cats -->
		<table width="99%" border cellpadding="0" cellspacing="0">
			<tr style="background-color:#B8B8B8;">
				<td width="25%">
					<br />
					<u>
						{admin_manage.cats.CATS} : 
					</u>
					<br />
					&nbsp; 
					<b>
						{admin_manage.cats.NAME}
					</b>
					<br /><br />
				</td>
				<td width="25%">
					<select id="cat:{admin_manage.cats.ID}" onchange="redir_cat('{admin_manage.cats.ID}' );">
						<option value="" selected="selected">{admin_manage.cats.CHOOSE_ACTION}</option>
						<option value="add_for">{admin_manage.cats.ADD_FOR}</option>
						<option value="mod">{admin_manage.cats.MODIF}</option>
						<option value="delete">{admin_manage.cats.DELETE}</option>
					</select>
				</td>
				<td width="40%">
					<u>{admin_manage.cats.TOPIC}:</u>
					&nbsp; 
					<i>
						{admin_manage.cats.DEF}
					</i>
				</td>
				<td width="10%">
					<a href="javascript:mod('{admin_manage.cats.ID}','plus','{admin_manage.cats.POSITION}', 'movecat', '' , '' );">
						<img src="./themes/tpl/img/admin/up.gif" border="0" />
					</a>
					<a href="javascript:mod('{admin_manage.cats.ID}','moins','{admin_manage.cats.POSITION}', 'movecat', '' , '' );">
						<img src="./themes/tpl/img/admin/down.gif" border="0" />
					</a>
				</td>
			</tr>
		</table>
		
		<!-- BEGIN admin_manage.cats.for -->
		
			<table width="99%" border cellpadding="0" cellspacing="0">
				<tr style="background-color:#AEC6E2;">
					<td width="25%" onclick="load_sub('{admin_manage.cats.for.ID}','0', '{admin_manage.cats.for.LANGUE}','tpl' );">
						<br />&nbsp; <b>{admin_manage.cats.for.NAME}</b><br /><br />
					</td>
					<td width="30%">
						<select id="for:{admin_manage.cats.for.ID}" onchange="redir_forum('{admin_manage.cats.for.ID}' , '{admin_manage.cats.for.IDCAT}');">
							<option value="" selected="selected">{admin_manage.cats.for.CHOOSE_ACTION}</option>
							<option value="lock">{admin_manage.cats.for.LOCK} / {admin_manage.cats.for.UNLOCK}</option>
							<option value="add_sub">{admin_manage.cats.for.ADD_SUB}</option>
							<option value="mod">{admin_manage.cats.for.MODIF}</option>
							<option value="delete">{admin_manage.cats.for.DELETE}</option>
							<option value="modos">{admin_manage.cats.for.MANAGE_MODERATORS}</option>
						</select>
					</td>
					<td width="15%">
						{admin_manage.cats.for.VERROU}
					</td>
					<td width="20%">
						<u>{admin_manage.cats.for.TOPIC}:</u>
						&nbsp; <i>{admin_manage.cats.for.DEF}</i>
					</td>
					<td width="10%">
						<a href="javascript:mod('{admin_manage.cats.for.ID}','plus','{admin_manage.cats.for.POSITION}', 'movefor', '{admin_manage.cats.for.IDCAT}' , '{admin_manage.cats.for.ISSUB}');">
							<img src="./themes/tpl/img/admin/up.gif" border="0" />
						</a>
						<a href="javascript:mod('{admin_manage.cats.for.ID}','moins','{admin_manage.cats.for.POSITION}', 'movefor', '{admin_manage.cats.for.IDCAT}' , '{admin_manage.cats.for.ISSUB}');">
							<img src="./themes/tpl/img/admin/down.gif" border="0" />
						</a>
					</td>
				</tr>
			</table>
			<div id="for{admin_manage.cats.for.ID}" style="visibility:hidden;height:0px;"></div>
		
		<!-- END admin_manage.cats.for -->
		
	<!-- END admin_manage.cats -->
	
	<br /><br />
		<a href="index.php?mods=forum&amp;page=admin">
			{admin_manage.BACK}
		</a>
<!-- END admin_manage -->

<!-- BEGIN admin_manage_ajax -->
	<table width="99%" border="1">
		<tr style="background-color:{admin_manage_ajax.COLOR};">
			<td width="25%" onclick="load_sub('{admin_manage_ajax.ID}','{admin_manage_ajax.COUNT_SUB}', '{admin_manage_ajax.LANG}', 'tpl' );">
				<!-- BEGIN admin_manage_ajax.space -->
				-
				<!-- END admin_manage_ajax.space -->
				> {admin_manage_ajax.NAME}
			</td>
			<td width="35%">
				<select id="for:{admin_manage_ajax.ID}" onchange="redir_forum({admin_manage_ajax.ID});">
					<option value="" selected="selected">{admin_manage_ajax.CHOOSE_ACTION}</option>
					<option value="add_sub">{admin_manage_ajax.ADD_SUB}</option>
					<option value="lock">{admin_manage_ajax.LOCK} / {admin_manage_ajax.UNLOCK}</option>
					<option value="mod">{admin_manage_ajax.MODIF}</option>
					<option value="delete">{admin_manage_ajax.DELETE}</option>
					<option value="modos">{admin_manage_ajax.MANAGE_MODERATORS}</option>
				</select>
			</td>
			<td width="10%">
				{admin_manage_ajax.VERROU}
			</td>
			<td width="20%">
				{admin_manage_ajax.DEF}
			</td>
			<td width="10%">
				<a href="javascript:mod('{admin_manage_ajax.ID}','plus','{admin_manage_ajax.POSITION}', 'movefor', {admin_manage_ajax.CAT_ID} );">
					<img src="./themes/tpl/img/admin/up.gif" border="0" />
				</a>
				<a href="javascript:mod('{admin_manage_ajax.ID}','moins','{admin_manage_ajax.POSITION}', 'movefor', {admin_manage_ajax.CAT_ID} );">
					<img src="./themes/tpl/img/admin/down.gif" border="0" />
				</a>	
			</td>
		</tr>
	</table>
	<div id="for{admin_manage_ajax.ID}"></div>
<!-- END admin_manage_ajax -->

<!-- BEGIN admin_modos -->
			<table border="0" style="width: 98%;">
				<tr>
					<td colspan="2">
						<u>
							{admin_modos.MODERATOR_NAME}
						</u>
						<br /><br />
					</td>
				</tr>
				
			<!-- BEGIN admin_modos.none -->
				<tr>
					<td colspan="2">
						{admin_modos.none.NONE_MODERATORS}
					</td>
				</tr>
			<!-- END admin_modos.none -->
			
			<!-- BEGIN admin_modos.mod -->
				<tr>
					<td>
						{admin_modos.mod.PSEUDO}
					</td>
					<td>
						<a href="{admin_modos.mod.URL}">
							{admin_modos.mod.REMOVE_MODERATOR}
						</a>
					</td>
				</tr>
			<!-- END admin_modos.mod -->
			
			</table><br /><br />
			<fieldset>
				<br />
				{admin_modos.MODERATOR_USAGE}
				<br /><br />
			</fieldset>
			<br /><br />
			<a href="{admin_modos.URL}">
				{admin_modos.ADD_MODERATOR}
			</a>
			<br /><br />
			<a href="./index.php?mods=forum&amp;page=admin&amp;manage">
				{admin_modos.BACK}
			</a>
<!-- END admin_modos -->

<!-- BEGIN admin_modos_add -->
	<form method="post" action="">
		{admin_modos_add.MODERATOR_PSEUDO} : 
		<select name="user_id">
			<!-- BEGIN admin_modos_add.pseudo -->
				<option value="{admin_modos_add.pseudo.VALUE}">{admin_modos_add.pseudo.PSEUDO}</option>
			<!-- END admin_modos_add.pseudo -->
		</select>
		<br /><br />
		<center>
			<input type="submit" value="{admin_modos_add.VALID}" />
		</center>
	</form><br /><br />
	<a href="{admin_modos_add.URL}">
		{admin_modos_add.BACK}
	</a>
<!-- END admin_modos_add -->
<!-- BEGIN admin_modos_mess -->
	{admin_modos_mess.TXT}<br /><br />
	<a href="{admin_modos_mess.URL}">
		{admin_modos_mess.BACK}
	</a>
<!-- END admin_modos_mess -->

<!-- BEGIN admin_lock -->
	{admin_lock.TXT}<br /><br />
	<a href="index.php?mods=forum&amp;page=admin&amp;manage">
		{admin_lock.BACK}
	</a>
<!-- END admin_lock -->

<!-- BEGIN admin_mod_cat -->
	{admin_mod_cat.JS}
	<form action="" method="post">
		<br />
		<table style="width:99%;">
			<tr>
				<td>
					{admin_mod_cat.TITLE}
				</td>
				<td colspan="2">
					<input type="text" name="titre" value="{admin_mod_cat.TITLE_VALUE}"/>
				</td>
			</tr>
			<tr>
				<td>
					{admin_mod_cat.DEFINITION}
				</td>
				<td colspan="2">
					<input type="text" name="def" value="{admin_mod_cat.DEFINITION_VALUE}"/>
				</td>
			</tr>
			
			<tr>
				<td colspan="2">
					<br />
					<center>
						<input type="submit" value="{admin_mod_cat.VALID}" />
					</center>
				</td>
			</tr>
			<!-- BEGIN admin_mod_cat.groupes -->
				<tr>
					<td>
						<br />
						<u>
							<b>
								{admin_mod_cat.groupes.GROUPS_ALLOWED} :
							</b>
						</u>
						<br /><br />
					</td>
					<td>
						{admin_mod_cat.groupes.READING}
					</td>
					<td>
						{admin_mod_cat.groupes.WRITTING}
					</td>
				</tr>
				<tr>
					<td>
						{admin_mod_cat.groupes.EVERYBODY}
					</td>
					<td>
						<input type="checkbox" name="{admin_mod_cat.groupes.NM_IN}" id="{admin_mod_cat.groupes.ID_IN}" value="1" {admin_mod_cat.groupes.CHK_IN} {admin_mod_cat.groupes.DSB_IN}/>
					</td>
					<td>
						<input type="checkbox" name="{admin_mod_cat.groupes.NM_IN2}" id="{admin_mod_cat.groupes.ID_IN2}" value="1" onclick="{admin_mod_cat.groupes.OC_IN2}" {admin_mod_cat.groupes.CHK_IN2}/>
					</td>
				</tr>
				<!-- BEGIN admin_mod_cat.groupes.gr -->
					<tr>
						<td>
							{admin_mod_cat.groupes.gr.NAME}
						</td>
						<td>
							<input type="checkbox" name="{admin_mod_cat.groupes.gr.NM_IN}" id="{admin_mod_cat.groupes.gr.ID_IN}" value="1" {admin_mod_cat.groupes.gr.CHK_IN} {admin_mod_cat.groupes.gr.DSB_IN}/>
						</td>
						<td>
							<input type="checkbox" name="{admin_mod_cat.groupes.gr.NM_IN2}" id="{admin_mod_cat.groupes.gr.ID_IN2}" value="1" onclick="{admin_mod_cat.groupes.gr.OC_IN2}" {admin_mod_cat.groupes.gr.CHK_IN2}/>
						</td>
					</tr>
				<!-- END admin_mod_cat.groupes.gr -->
			<!-- END admin_mod_cat.groupes -->
		</table>
	</form>
	<br /><br />
	<a href="index.php?mods=forum&amp;page=admin&amp;manage">
		{admin_mod_cat.BACK}
	</a>
<!-- END admin_mod_cat -->
<!-- BEGIN admin_mod_cat_mess -->
	{admin_mod_cat_mess.TXT}
	<br /><br />
	<a href="{admin_mod_cat_mess.URL}">
		{admin_mod_cat_mess.BACK}
	</a>
<!-- END admin_mod_cat_mess -->

<!-- BEGIN admin_mod_for -->
	{admin_mod_for.JS}
	<form action="" method="post">
		<br />
		<table style="width:99%;">
			<tr>
				<td>
					{admin_mod_for.TITLE}
				</td>
				<td colspan="2">
					<input type="text" name="titre" value="{admin_mod_for.TITLE_VALUE}"/>
				</td>
			</tr>
			<tr>
				<td>
					{admin_mod_for.DEFINITION}
				</td>
				<td colspan="2">
					<input type="text" name="def" value="{admin_mod_for.DEFINITION_VALUE}"/>
				</td>
			</tr>
			
			<tr>
				<td colspan="2">
					<br />
					<center>
						<input type="submit" value="{admin_mod_for.VALID}" />
					</center>
				</td>
			</tr>
			<!-- BEGIN admin_mod_for.groupes -->
				<tr>
					<td>
						<br />
						<u>
							<b>
								{admin_mod_for.groupes.GROUPS_ALLOWED} :
							</b>
						</u>
						<br /><br />
					</td>
					<td>
						{admin_mod_for.groupes.READING}
					</td>
					<td>
						{admin_mod_for.groupes.WRITTING}
					</td>
				</tr>
				<tr>
					<td>
						{admin_mod_for.groupes.EVERYBODY}
					</td>
					<td>
						<input type="checkbox" name="{admin_mod_for.groupes.NM_IN}" id="{admin_mod_for.groupes.ID_IN}" value="1" {admin_mod_for.groupes.CHK_IN} {admin_mod_for.groupes.DSB_IN}/>
					</td>
					<td>
						<input type="checkbox" name="{admin_mod_for.groupes.NM_IN2}" id="{admin_mod_for.groupes.ID_IN2}" value="1" onclick="{admin_mod_for.groupes.OC_IN2}" {admin_mod_for.groupes.CHK_IN2}/>
					</td>
				</tr>
				<!-- BEGIN admin_mod_for.groupes.gr -->
					<tr>
						<td>
							{admin_mod_for.groupes.gr.NAME}
						</td>
						<td>
							<input type="checkbox" name="{admin_mod_for.groupes.gr.NM_IN}" id="{admin_mod_for.groupes.gr.ID_IN}" value="1" {admin_mod_for.groupes.gr.CHK_IN} {admin_mod_for.groupes.gr.DSB_IN}/>
						</td>
						<td>
							<input type="checkbox" name="{admin_mod_for.groupes.gr.NM_IN2}" id="{admin_mod_for.groupes.gr.ID_IN2}" value="1" onclick="{admin_mod_for.groupes.gr.OC_IN2}" {admin_mod_for.groupes.gr.CHK_IN2}/>
						</td>
					</tr>
				<!-- END admin_mod_for.groupes.gr -->
			<!-- END admin_mod_for.groupes -->
		</table>
	</form>
	<br /><br />
	<a href="index.php?mods=forum&amp;page=admin&amp;manage">
		{admin_mod_for.BACK}
	</a>
<!-- END admin_mod_for -->

<!-- BEGIN admin_mod_for_mess -->
	{admin_mod_for_mess.TXT}
	<br /><br />
	<a href="{admin_mod_for_mess.URL}">
		{admin_mod_for_mess.BACK}
	</a>
<!-- END admin_mod_for_mess -->

<!-- BEGIN admin_manage_del -->
	{admin_manage_del.TXT}
	<br /><br />
	<a href="index.php?mods=forum&amp;page=admin&amp;manage">
		{admin_manage_del.BACK}
	</a>
<!-- END admin_manage_del -->

<!-- BEGIN admin_add_form -->
	<form action="" method="post">
	<br />
	
	<table>
		<tr>
			<td>
				{admin_add_form.TITLE}
			</td>
			<td>
				<input type="text" name="titre" value=""/>
			</td>
		</tr>
		<tr>
			<td>
				{admin_add_form.DEFINITION}
			</td>
			<td>
				<input type="text" name="def" value=""/>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<center>
					<input type="submit" value="{admin_add_form.VALID}" />
				</center>
			</td>
		</tr>
	</table>
	</form>
	<a href="index.php?mods=forum&amp;page=admin&amp;manage">
		{admin_add_form.BACK}
	</a>
<!-- END admin_add_form -->

<!-- BEGIN admin_add_mess -->
	{admin_add_mess.TXT}
	<br /><br />
	<a href="index.php?mods=forum&amp;page=admin&amp;manage">
		{admin_add_mess.BACK}
	</a>
<!-- END admin_mod_for_mess -->