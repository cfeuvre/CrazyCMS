<!-- BEGIN forum_news -->
	{forum_news.JS}
	<center>
		<strong> - {forum_news.NOM} - </strong> 
		<br /><br />
		<img src="./themes/tpl/img/forum/puce.png" alt="Puce"/>&nbsp;
			<a href="index.php?mods=forum">
				{forum_news.ACCUEIL}
			</a>&nbsp;&nbsp;&nbsp;
		<img src="./themes/tpl/img/forum/puce.png" alt="Puce"/>&nbsp;
			<a href="index.php?mods=forum&amp;rules">
				{forum_news.FORUM_RULES}
			</a>&nbsp;&nbsp;&nbsp;
		<img src="./themes/tpl/img/forum/puce.png" alt="Puce"/>&nbsp;
			<a href="index.php?mods=forum&amp;page=search">
				{forum_news.SEARCH}
			</a>&nbsp;&nbsp;&nbsp;
		<br /><br />
		<fieldset>
			<legend>
				{forum_news.FAST_SEARCH}
			</legend>
			<br />
			<form method="post" action="index.php?mods=forum&amp;page=search">
				<table style="width: 90%;" border="0">
					<tr>
						<td>
							<input type="text" style="color: grey;" id="search" value="{forum_news.SEARCH}" name="search" onblur="reload();" onfocus="load();"/>
						</td>
						<td>
							<input type="checkbox" name="search_titre" value="1"/>
						</td>
						<td>
							{forum_news.ON_THE_TITLE}
						</td>
						<td>
							<input type="checkbox" name="search_contenu" value="1"/>
						</td>
						<td>
							{forum_news.ON_THE_CONTENT}
						</td>
						<td>
							<input type="submit" value="{forum_news.SEARCH}" />
						</td>
					</tr>
				</table>
			</form>
		</fieldset>
	</center>
	<br /><br />
			&raquo;
			<a href="index.php?mods=forum">
				<strong>
					{forum_news.CAT_NAME}
				</strong>
			</a>
			&raquo;
			<a href="{forum_news.URL}">
				<strong>
					{forum_news.NAME}
				</strong>
			</a>
			<br />
	<!-- BEGIN forum_news.page_haut -->
		<br /><center>
			{forum_news.page_haut.PAGE} : 
			<!-- BEGIN forum_news.page_haut.pg -->
				<a href="{forum_news.page_haut.pg.URL}">
					<font size="{forum_news.page_haut.pg.SIZE}px">
						{forum_news.page_haut.pg.NM}
					</font>
				</a> 
				<!-- BEGIN forum_news.page_haut.pg.etc -->
					...
				<!-- END forum_news.page_haut.pg.etc -->
			<!-- END forum_news.page_haut.pg -->
		</center>
	<!-- END forum_news.page_haut -->
	<br />
	<!-- BEGIN forum_news.news_header -->
		<table width="95%" border="0" align="center">
			<tr bgcolor="#CCCCCC">
				<td width="45%" align="center">
				<div class="open_forum">{forum_news.news_header.TOPICS}</div>
				</td>
				<td width="15%" align="center">
				<div class="open_forum">{forum_news.news_header.AUTHORS}</div>
				</td>
				<td align="center" width="5%">
				<div class="open_forum">{forum_news.news_header.REPLYS}</div>
				</td>
			</tr>
	<!-- END forum_news.news_header -->
	<!-- BEGIN forum_news.news -->
			<tr>
				<td width="45%">
					<a href="{forum_news.news.URL}">	
						&nbsp;&nbsp;{forum_news.news.NOM}
					</a>
				</td>
				<td  width="15%" bgcolor="#F3F3F3" align="center">
					<a href="{forum_news.news.PROFIL_URL}">
						{forum_news.news.PSEUDO}
					</a>
				</td>
				<td width="5%" align="center">
					{forum_news.news.MESSAGES}
				</td>
			</tr>
	<!-- END forum_news.news -->
	<!-- BEGIN forum_news.none -->
			<tr>
				<td width="45%" colspan="3">
					{forum_news.none.TXT}
				</td>
			</tr>
	<!-- END forum_news.none -->
	<!-- BEGIN forum_news.news_footer -->
		</table>
	<!-- END forum_news.news_footer -->
	<!-- BEGIN forum_news.page_bas -->
		<br /><center>
			{forum_news.page_bas.PAGE} : 
			<!-- BEGIN forum_news.page_bas.pg -->
				<a href="{forum_news.page_bas.pg.URL}"><font size="{forum_news.page_bas.pg.SIZE}px">{forum_news.page_bas.pg.NM}</font></a>
				<!-- BEGIN forum_news.page_bas.pg.etc -->
					...
				<!-- END forum_news.page_bas.pg.etc -->
			<!-- END forum_news.page_bas.pg -->
		</center>
	<!-- END forum_news.page_bas -->
<!-- END forum_news -->

<!-- BEGIN forum_for -->
	{forum_for.JS}
	<center>
		<strong> - {forum_for.NOM} - </strong> 
		<br /><br />
		<img src="./themes/tpl/img/forum/puce.png" alt="Puce"/>&nbsp;
			<a href="index.php?mods=forum">
				{forum_for.ACCUEIL}
			</a>&nbsp;&nbsp;&nbsp;
		<img src="./themes/tpl/img/forum/puce.png" alt="Puce"/>&nbsp;
			<a href="index.php?mods=forum&amp;rules">
				{forum_for.FORUM_RULES}
			</a>&nbsp;&nbsp;&nbsp;
		<img src="./themes/tpl/img/forum/puce.png" alt="Puce"/>&nbsp;
			<a href="index.php?mods=forum&amp;page=search">
				{forum_for.SEARCH}
			</a>&nbsp;&nbsp;&nbsp;
		<br /><br />
		<fieldset>
			<legend>
				{forum_for.FAST_SEARCH}
			</legend>
			<br />
			<form method="post" action="index.php?mods=forum&amp;page=search">
				<table style="width: 90%;" border="0">
					<tr>
						<td>
							<input type="text" style="color: grey;" id="search" value="{forum_for.SEARCH}" name="search" onblur="reload();" onfocus="load();"/>
						</td>
						<td>
							<input type="checkbox" name="search_titre" value="1"/>
						</td>
						<td>
							{forum_for.ON_THE_TITLE}
						</td>
						<td>
							<input type="checkbox" name="search_contenu" value="1"/>
						</td>
						<td>
							{forum_for.ON_THE_CONTENT}
						</td>
						<td>
							<input type="submit" value="{forum_for.SEARCH}" />
						</td>
					</tr>
				</table>
			</form>
		</fieldset>
	</center>
	<br />
	<a href="./index.php?mods=forum">
		[{forum_for.ACCUEIL}]
	</a>
	&raquo; 
	<a href="index.php?mods=forum">
		<strong>
			{forum_for.CAT_PARENT}
		</strong>
	</a>
	<!-- BEGIN forum_for.links -->
		&raquo; ...
	<!-- END forum_for.links -->
	<!-- BEGIN forum_for.links1 -->
		&raquo;
		<a href="{forum_for.links1.URL}">
			<strong>
				{forum_for.links1.NOM}
			</strong>
		</a>
	<!-- END forum_for.links1 -->
	<!-- BEGIN forum_for.links2 -->
		&raquo;
		<a href="{forum_for.links2.URL}">
			<strong>
				{forum_for.links2.NOM}
			</strong>
		</a>
	<!-- END forum_for.links2 -->
	<br /><br />
	<!-- BEGIN forum_for.sub_head -->
		<u>{forum_for.sub_head.TITRE} : </u><br /><br />
		<table width="95%" border="0" align="center">
			<tr bgcolor="#CCCCCC">
				<td width="30%" align="center">
					<div class="open_forum">{forum_for.sub_head.CATS}</div>
				</td>
				<td width="15%" align="center">
					<div class="open_forum">{forum_for.sub_head.TOPICS}</div>
				</td>
				<td width="15%" align="center">
					<div class="open_forum">{forum_for.sub_head.REPLYS}</div>
				</td>
				<td width="25%" align="center">
					<div class="open_forum">{forum_for.sub_head.LAST_MESS}</div>
				</td>
			</tr>
	<!-- END forum_for.sub_head -->
	<!-- BEGIN forum_for.sub_fors -->
					<tr>
						<td>
							<img src="./themes/tpl/img/forum/{forum_for.sub_fors.IMG}.png" align="left" alt="{forum_for.sub_fors.IMG}"/>
							<center>
								&nbsp;
								<strong>
									<u>
										<a href="{forum_for.sub_fors.URL}">
												{forum_for.sub_fors.NOM}
										</a>
									</u>
								</strong>
								<br />
								&nbsp;&nbsp;
								<i>
									{forum_for.sub_fors.DEF}
								</i>
							</center>
								<!-- BEGIN forum_for.sub_fors.moderators -->
									<br />
									<u>
										{forum_for.sub_fors.moderators.MODERATORS} ;
									</u>
									{forum_for.sub_fors.moderators.MODOS}
									<br /><br />
								<!-- END forum_for.sub_fors.moderators -->
							
						</td>
						<td align="center" bgcolor="#F3F3F3">
							{forum_for.sub_fors.SUJETS}
						</td>
						<td align="center">
							{forum_for.sub_fors.MESSAGES}
						</td>
						<td align="center" bgcolor="#F3F3F3">
							<!-- BEGIN forum_for.sub_fors.lm -->
								<a href="{forum_for.sub_fors.lm.LM_URL}">
									{forum_for.sub_fors.lm.LM_THE} {forum_for.sub_fors.lm.LM_DATE} {forum_for.sub_fors.lm.LM_INTO} {forum_for.sub_fors.lm.LM_SUJET} {forum_for.sub_fors.lm.LM_BY} {forum_for.sub_fors.lm.LM_PSEUDO}
								</a>
							<!-- END forum_for.sub_fors.lm -->
							<!-- BEGIN forum_for.sub_fors.nlm -->
								{forum_for.sub_fors.nlm.TXT}
							<!-- END forum_for.sub_fors.nlm -->
						</td>
					</tr>
	<!-- END forum_for.sub_fors -->
	<!-- BEGIN forum_for.sub_footer -->
		</table>
	<!-- END forum_for.sub_footer -->
	
	<!-- BEGIN forum_for.post_haut -->
		<br />
		<div align="right">
			<strong>
				<a href="{forum_for.post_haut.URL}">
					[&raquo; {forum_for.post_haut.TXT}]
				</a>
			</strong>
		</div><br />
	<!-- END forum_for.post_haut -->
	
	<!-- BEGIN forum_for.pages_haut -->
		<br />
			<center>
				{forum_for.pages_haut.PAGE} : 
				<!-- BEGIN forum_for.pages_haut.pg -->
					<a href="{forum_for.pages_haut.pg.URL}">
						<font size="{forum_for.pages_haut.pg.SIZE}px">
							{forum_for.pages_haut.pg.NM}
						</font>
					</a> 
					<!-- BEGIN forum_for.pages_haut.pg.etc -->
						...
					<!-- END forum_for.pages_haut.pg.etc -->
				<!-- END forum_for.pages_haut.pg -->
			</center>
	<!-- END forum_for.pages_haut -->
	
	<!-- BEGIN forum_for.topics -->
		<p>
			<u>
				{forum_for.topics.TOPICS} :
			</u>
		</p>
		<!-- BEGIN forum_for.topics.head -->
			<table width="95%" border="0" align="center">
				<tr bgcolor="#CCCCCC">
					<td width="45%" align="center">
						<div class="open_forum">
							{forum_for.topics.head.TOPICS}
						</div>
					</td>
					<td width="15%" align="center">
						<div class="open_forum">
							{forum_for.topics.head.AUTHORS}
						</div>
					</td>
					<td align="center" width="5%">
						<div class="open_forum">
							{forum_for.topics.head.REPLYS}
						</div>
					</td>
					<td align="center" width="5%">
						<div class="open_forum">
							{forum_for.topics.head.HITS}
						</div>
					</td>
					<td align="center" width="30%">
						<div class="open_forum">
							{forum_for.topics.head.LAST_MESS}
						</div>
					</td>
				</tr>
		<!-- END forum_for.topics.head -->
		<!-- BEGIN forum_for.topics.top -->
				<tr>
					<td width="45%">
						<img src="./themes/tpl/img/forum/{forum_for.topics.top.IMG}.png" alt="{forum_for.topics.top.IMG}"/>
						<!-- BEGIN forum_for.topics.top.locked -->
							<img src="./themes/TPL/img/forum/locked.png" alt="."/> 
						<!-- END forum_for.topics.top.locked -->
						<!-- BEGIN forum_for.topics.top.attached -->
							<img src="./themes/tpl/img/forum/attached.png" alt="."/> 
						<!-- END forum_for.topics.top.attached -->
						<a href="{forum_for.topics.top.URL}" onclick="redir('{forum_for.topics.top.URL}&js');return false;">	
							&nbsp;&nbsp;{forum_for.topics.top.NOM}
						</a>
					</td>
					<td  width="15%" bgcolor="#F3F3F3" align="center">
						<a href="{forum_for.topics.top.PROFIL_URL}">
							{forum_for.topics.top.PSEUDO}
						</a>
					</td>
					<td width="5%" align="center">
						{forum_for.topics.top.MESSAGES}
					</td>
					<td width="5%" bgcolor="#F3F3F3" align="center">
						{forum_for.topics.top.VU}
					</td>
					<td width="30%" align="center">
						<!-- BEGIN forum_for.topics.top.lm -->
							{forum_for.topics.top.lm.LM_THE} {forum_for.topics.top.lm.LM_DATE} <br />
								{forum_for.topics.top.lm.LM_BY} {forum_for.topics.top.lm.LM_PSEUDO}
						<!-- END forum_for.topics.top.lm -->
						<!-- BEGIN forum_for.topics.top.no_lm -->
							{forum_for.topics.top.no_lm.TXT}
						<!-- END forum_for.topics.top.no_lm -->
					</td>
				</tr>
		<!-- END forum_for.topics.top -->
		<!-- BEGIN forum_for.topics.ntop -->
				<tr>
					<td colspan="5">
						{forum_for.topics.ntop.TXT}
					</td>
				</tr>
		<!-- END forum_for.topics.ntop -->
		<!-- BEGIN forum_for.topics.footer -->
			</table>
		<!-- END forum_for.topics.footer -->
	<!-- END forum_for.topics -->
	
	<!-- BEGIN forum_for.pages_bas -->
		<br />
			<center>
				{forum_for.pages_bas.PAGE} : 
				<!-- BEGIN forum_for.pages_bas.pg -->
					<a href="{forum_for.pages_bas.pg.URL}">
						<font size="{forum_for.pages_bas.pg.SIZE}px">
							{forum_for.pages_bas.pg.NM}
						</font>
					</a> 
					<!-- BEGIN forum_for.pages_bas.pg.etc -->
						...
					<!-- END forum_for.pages_bas.pg.etc -->
				<!-- END forum_for.pages_bas.pg -->
			</center>
	<!-- END forum_for.pages_bas -->
	<br />
	<!-- BEGIN forum_for.post_bas -->
		<br />
		<div align="right">
			<strong>
				<a href="{forum_for.post_bas.URL}">
					[&raquo; {forum_for.post_bas.TXT}]
				</a>
			</strong>
		</div><br />
	<!-- END forum_for.post_bas -->
<!-- END forum_for -->