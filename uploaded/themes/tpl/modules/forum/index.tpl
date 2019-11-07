<!-- BEGIN forum_index -->
{forum_index.JS}
	<center>
		<strong> - {forum_index.NOM} - </strong> 
		<br /><br />
		<img src="./themes/tpl/img/forum/puce.png" alt="Puce"/>&nbsp;
			<a href="index.php?mods=forum">
				{forum_index.ACCUEIL}
			</a>&nbsp;&nbsp;&nbsp;
		<img src="./themes/tpl/img/forum/puce.png" alt="Puce"/>&nbsp;
			<a href="index.php?mods=forum&amp;rules">
				{forum_index.FORUM_RULES}
			</a>&nbsp;&nbsp;&nbsp;
		<img src="./themes/tpl/img/forum/puce.png" alt="Puce"/>&nbsp;
			<a href="index.php?mods=forum&amp;page=search">
				{forum_index.SEARCH}
			</a>&nbsp;&nbsp;&nbsp;
		<br /><br />
		<fieldset>
			<legend onclick="vis('fsearch');">
				{forum_index.FAST_SEARCH}
			</legend>
			<div id="fsearch" style="visibility: hidden; height: 0px;">
				<br />
				<form method="post" action="index.php?mods=forum&amp;page=search">
					<table style="width: 90%;" border="0">
						<tr>
							<td>
								<input type="text" style="color: grey;" id="search" value="{forum_index.SEARCH}" name="search" onblur="reload();" onfocus="load();"/>
							</td>
							<td>
								<input type="checkbox" name="search_titre" value="1"/>
							</td>
							<td>
								{forum_index.ON_THE_TITLE}
							</td>
							<td>
								<input type="checkbox" name="search_contenu" value="1"/>
							</td>
							<td>
								{forum_index.ON_THE_CONTENT}
							</td>
							<td>
								<input type="submit" value="{forum_index.SEARCH}" />
							</td>
						</tr>
					</table>
				</form>
			</div>
			<noscript>
				<br />
				<form method="post" action="index.php?mods=forum&amp;page=search">
					<table style="width: 90%;" border="0">
						<tr>
							<td>
								<input type="text" style="color: grey;" id="search" value="{forum_index.SEARCH}" name="search" onblur="reload();" onfocus="load();"/>
							</td>
							<td>
								<input type="checkbox" name="search_titre" value="1"/>
							</td>
							<td>
								{forum_index.ON_THE_TITLE}
							</td>
							<td>
								<input type="checkbox" name="search_contenu" value="1"/>
							</td>
							<td>
								{forum_index.ON_THE_CONTENT}
							</td>
							<td>
								<input type="submit" value="{forum_index.SEARCH}" />
							</td>
						</tr>
					</table>
				</form>
			</noscript>
		</fieldset>
	</center>
	<!-- BEGIN forum_index.forum_index_none -->
		<br />
			<fieldset>
				<center>
					<b>
						{forum_index.forum_index_none.TXT}
					</b>
				</center>
			</fieldset>
	<!-- END forum_index.forum_index_none -->
	<!-- BEGIN forum_index.user_option -->
		<br /><fieldset>
			<legend onclick="vis('options');">
				{forum_index.user_option.OPTION}
			</legend>
			<div id="options" style="visibility: hidden; height: 0px;">
				<!-- BEGIN forum_index.user_option.forum_mark_reads -->
				<br />
				<a href="index.php?mods=forum&amp;reads">
					&raquo; {forum_index.user_option.forum_mark_reads.TXT}
				</a>
				<br />
				<!-- END forum_index.user_option.forum_mark_reads -->
				
				<!-- BEGIN forum_index.user_option.forum_del_abo -->
				<br />
				<a href="index.php?mods=forum&amp;del_abo">
					&raquo; {forum_index.user_option.forum_del_abo.TXT}
				</a>
				<br />
				<!-- END forum_index.user_option.forum_del_abo -->
				
				<!-- BEGIN forum_index.user_option.forum_gen_abo -->
				<br />
				<a href="index.php?mods=forum&amp;gen_abo">
					&raquo; {forum_index.user_option.forum_gen_abo.TXT}
				</a>
				<br />
				<!-- END forum_index.user_option.forum_gen_abo -->
				
				<!-- BEGIN forum_index.user_option.forum_abogen -->
				<br />
				<a href="{forum_index.user_option.forum_abogen.URL}">
					&raquo; {forum_index.user_option.forum_abogen.TXT}
				</a>
				<br />
				<!-- END forum_index.user_option.forum_abogen -->
			</div>
			<noscript>
				<!-- BEGIN forum_index.user_option.forum_mark_reads -->
				<br />
				<a href="index.php?mods=forum&amp;reads">
					&raquo; {forum_index.user_option.forum_mark_reads.TXT}
				</a>
				<br />
				<!-- END forum_index.user_option.forum_mark_reads -->
				
				<!-- BEGIN forum_index.user_option.forum_abogen -->
				<br />
				<a href="{forum_index.user_option.forum_abogen.URL}">
					&raquo; {forum_index.user_option.forum_abogen.TXT}
				</a>
				<br />
				<!-- END forum_index.user_option.forum_abogen -->
			</noscript>
		</fieldset>
	<!-- END forum_index.user_option -->
	
<br />
	<!-- BEGIN forum_index.forum_cats -->
			<table border="0" onclick="hide_cat('{forum_index.forum_cats.ID}');">
				<tr >
					<td style="text-align:center;">
						<img id="img:{forum_index.forum_cats.ID}" src="./themes/tpl/img/forum/{forum_index.forum_cats.VISIBLE}.png" alt="{forum_index.forum_cats.VISIBLE}"/>
					</td>
					<td>
						<span style="margin-left:25px;">
							<strong>
								{forum_index.forum_cats.NOM}:
							</strong>
							&nbsp;&nbsp;{forum_index.forum_cats.DEF}
						</span>
					</td>
				</tr>
			</table>
		<!-- BEGIN forum_index.forum_cats.forum_for_haut -->
			<div id="cat:{forum_index.forum_cats.forum_for_haut.ID}" style="visibility:{forum_index.forum_cats.forum_for_haut.VISIBLE};height:{forum_index.forum_cats.forum_for_haut.HEIGHT};">
				<center>
					<table border="0" width="95%">
						<tr bgcolor="#CCCCCC">
							<td width="45%" align="center">
								<div class="open_forum">
									{forum_index.forum_cats.forum_for_haut.CATS}
								</div>
							</td>
							<td align="center">
								<div class="open_forum">
									{forum_index.forum_cats.forum_for_haut.TOPICS}
								</div>
							</td>
							<td align="center">
								<div class="open_forum">
									{forum_index.forum_cats.forum_for_haut.REPLYS}
								</div>
							</td>
							<td align="center">
								<div class="open_forum">
									{forum_index.forum_cats.forum_for_haut.LAST_MESS}
								</div>
							</td>
						</tr>
		<!-- END forum_index.forum_cats.forum_for_haut -->
		<!-- BEGIN forum_index.forum_cats.forum_fors -->
						<tr>
							<td>
								<img src="./themes/tpl/img/forum/{forum_index.forum_cats.forum_fors.IMG}.png" align="left" alt="{forum_index.forum_cats.forum_fors.IMG}"/>
								<center>
									&nbsp;
									<strong>
										<u>
											<a href="{forum_index.forum_cats.forum_fors.URL}">
													{forum_index.forum_cats.forum_fors.NOM}
											</a>
										</u>
									</strong>
									<br />
									&nbsp;&nbsp;
									<i>
										{forum_index.forum_cats.forum_fors.DEF}
									</i>
								</center>
									<!-- BEGIN forum_index.forum_cats.forum_fors.moderators -->
										<br />
										<u>
											{forum_index.forum_cats.forum_fors.moderators.MODERATORS} : 
										</u>
										{forum_index.forum_cats.forum_fors.moderators.MODOS}
										<br /><br />
									<!-- END forum_index.forum_cats.forum_fors.moderators -->
								
							</td>
							<td align="center" bgcolor="#F3F3F3">
								{forum_index.forum_cats.forum_fors.SUJETS}
							</td>
							<td align="center">
								{forum_index.forum_cats.forum_fors.MESSAGES}
							</td>
							<td align="center" bgcolor="#F3F3F3">
								<!-- BEGIN forum_index.forum_cats.forum_fors.lm -->
									<a href="{forum_index.forum_cats.forum_fors.lm.LM_URL}">
										{forum_index.forum_cats.forum_fors.lm.LM_THE} {forum_index.forum_cats.forum_fors.lm.LM_DATE} {forum_index.forum_cats.forum_fors.lm.LM_INTO} {forum_index.forum_cats.forum_fors.lm.LM_SUJET} {forum_index.forum_cats.forum_fors.lm.LM_BY} {forum_index.forum_cats.forum_fors.lm.LM_PSEUDO}
									</a>
								<!-- END forum_index.forum_cats.forum_fors.lm -->
								<!-- BEGIN forum_index.forum_cats.forum_fors.nlm -->
									{forum_index.forum_cats.forum_fors.nlm.TXT}
								<!-- END forum_index.forum_cats.forum_fors.lm -->
							</td>
						</tr>
		<!-- END forum_index.forum_cats.forum_fors -->
		<!-- BEGIN forum_index.forum_cats.forum_for_bas -->
					</table>
				</center>
			</div>
		<!-- END forum_index.forum_cats.forum_for_bas -->
	<!-- END forum_index.forum_cats -->
	<br />
	<!-- BEGIN forum_index.forum_index_stats -->
	<br />
	<fieldset>
		<legend onclick="vis('stats');">
			{forum_index.forum_index_stats.STATISTICS}
		</legend>
		<div id="stats" style="visibility: hidden; height: 0px;">
			<br />
			{forum_index.forum_index_stats.NB_TOPIC} : {forum_index.forum_index_stats.NB_TOPICS} <br /><br />
			{forum_index.forum_index_stats.NB_REPLY} : {forum_index.forum_index_stats.NB_REPLYS}
			<br /><br />
		</div>
		<noscript>
			<br />
			{forum_index.forum_index_stats.NB_TOPIC} : {forum_index.forum_index_stats.NB_TOPICS} <br /><br />
			{forum_index.forum_index_stats.NB_REPLY} : {forum_index.forum_index_stats.NB_REPLYS}
			<br /><br />
		</noscript>
	</fieldset>
	<!-- END forum_index.forum_index_stats -->
	<br />
	<fieldset>
		<legend onclick="vis('help');">
			{forum_index.HELP}
		</legend>
		<div id="help" style="visibility: hidden; height: 0px;">
			<table width="95%">
				<tr>
					<td>
						<img src="./themes/tpl/img/forum/new.png" alt="." />
					</td>
					<td>
						{forum_index.NEW_MESS}
					</td>
				</tr>
				<tr>
					<td>
						<img src="./themes/tpl/img/forum/new_locked.png" alt="." />
					</td>
					<td>
						{forum_index.NEW_MESS_LOCKED}
					</td>
				</tr>
				<tr>
					<td>
						<img src="./themes/tpl/img/forum/none.png" alt="." />
					</td>
					<td>
						{forum_index.NONE_MESS}
					</td>
				</tr>
				<tr>
					<td>
						<img src="./themes/tpl/img/forum/none_locked.png" alt="." />
					</td>
					<td>
						{forum_index.NONE_MESS_LOCKED}
					</td>
				</tr>
			</table>
		</div>
		<noscript>
			<table width="95%">
				<tr>
					<td>
						<img src="./themes/tpl/img/forum/new.png" alt="." />
					</td>
					<td>
						{forum_index.NEW_MESS}
					</td>
				</tr>
				<tr>
					<td>
						<img src="./themes/tpl/img/forum/new_locked.png" alt="." />
					</td>
					<td>
						{forum_index.NEW_MESS_LOCKED}
					</td>
				</tr>
				<tr>
					<td>
						<img src="./themes/tpl/img/forum/none.png" alt="." />
					</td>
					<td>
						{forum_index.NONE_MESS}
					</td>
				</tr>
				<tr>
					<td>
						<img src="./themes/tpl/img/forum/none_locked.png" alt="." />
					</td>
					<td>
						{forum_index.NONE_MESS_LOCKED}
					</td>
				</tr>
			</table>
		</noscript>
	</fieldset>	
<!-- END forum_index -->

<!-- BEGIN forum_rules -->
	<br />
		<h2>
			{forum_rules.TITLE}
		</h2>
	<br />
	{forum_rules.TXT}
	<br /><br />
	<a href="index.php?mods=forum">
		{forum_rules.BACK}
	</a>
<!-- END forum_rules -->