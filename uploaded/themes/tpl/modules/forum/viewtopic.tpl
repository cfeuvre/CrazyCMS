<!-- BEGIN forum_news_head -->
	{forum_news_head.JS}
	<center>
		<strong> - {forum_news_head.NOM} - </strong> 
		<br /><br />
		<img src="./themes/tpl/img/forum/puce.png" alt="Puce"/>&nbsp;
			<a href="index.php?mods=forum">
				{forum_news_head.ACCUEIL}
			</a>&nbsp;&nbsp;&nbsp;
		<img src="./themes/tpl/img/forum/puce.png" alt="Puce"/>&nbsp;
			<a href="index.php?mods=forum&amp;rules">
				{forum_news_head.FORUM_RULES}
			</a>&nbsp;&nbsp;&nbsp;
		<img src="./themes/tpl/img/forum/puce.png" alt="Puce"/>&nbsp;
			<a href="index.php?mods=forum&amp;page=search">
				{forum_news_head.SEARCH}
			</a>&nbsp;&nbsp;&nbsp;
		<br /><br />
		<fieldset>
			<legend>
				{forum_news_head.FAST_SEARCH}
			</legend>
			<br />
			<form method="post" action="index.php?mods=forum&amp;page=search">
				<table style="width: 90%;" border="0">
					<tr>
						<td>
							<input type="text" style="color: grey;" id="search" value="{forum_news_head.SEARCH}" name="search" onblur="reload();" onfocus="load();"/>
						</td>
						<td>
							<input type="checkbox" name="search_titre" value="1"/>
						</td>
						<td>
							{forum_news_head.ON_THE_TITLE}
						</td>
						<td>
							<input type="checkbox" name="search_contenu" value="1"/>
						</td>
						<td>
							{forum_news_head.ON_THE_CONTENT}
						</td>
						<td>
							<input type="submit" value="{forum_news_head.SEARCH}" />
						</td>
					</tr>
				</table>
			</form>
		</fieldset>
	</center>
	<br /><br />
	<a href="./index.php?mods=forum">
		[{forum_news_head.ACCUEIL}]
	</a> 
	&raquo;
	<a href="index.php?mods=forum">
		<strong>
			{forum_news_head.CAT_PARENT}
		</strong>
	</a>
	<!-- BEGIN forum_news_head.links1 -->
		&raquo;
		<a href="{forum_news_head.links1.URL}">
			<strong>
				{forum_news_head.links1.NOM}
			</strong>
		</a>
	<!-- END forum_news_head.links1 -->
	<!-- BEGIN forum_news_head.links2 -->
		&raquo;
		<a href="{forum_news_head.links2.URL}">
			<strong>
				{forum_news_head.links2.NOM}
			</strong>
		</a>
	<!-- END forum_news_head.links2 -->
	<br /><br /><br />
	<!-- BEGIN forum_news_head.head_news_post -->
		<a href="{forum_news_head.head_news_post.HREF}">
			[{forum_news_head.head_news_post.TXT}]
		</a><br /><br />
	<!-- END forum_news_head.head_news_post -->
	
	<br />
	<script type="text/javascript" src="./mods/ajax/real_time_edit.js"></script>
	<table border="0" align="center" width="95%">
		<tr>
			<td bgcolor="#F3F3F3">
				<table cellspacing="0" align="center" width="100%">
					<tr bgcolor="#CCCCCC">
						<td>
							<div class="topic_head">
								<a href="{forum_news_head.PROFIL_URL}">
									<strong>
										{forum_news_head.PSEUDO}
									</strong>
								</a>
							</div>
						</td>
						<td>
							<div class="topic_head">
								<!-- BEGIN forum_news_head.edit -->
									<a onclick="{forum_news_head.edit.ON_CLICK_EDIT}" href="{forum_news_head.edit.HREF_EDIT}">
										&raquo; {forum_news_head.edit.TXT_EDIT}
									</a>
								<!-- END forum_news_head.edit -->
							</div>
						</td>
						<td align="right">
						{forum_news_head.THE} {forum_news_head.DATE}
						</td>
					</tr>
					<tr>
						<td width="25%" bgcolor="#DDDDDD" align="center">
							<!-- BEGIN forum_news_head.profil -->
								<!-- BEGIN forum_news_head.profil.none -->
									{forum_news_head.profil.none.TXT}
								<!-- END forum_news_head.profil.none -->
								<!-- BEGIN forum_news_head.profil.user -->
									<!-- BEGIN forum_news_head.profil.user.avatar -->
										<img src="{forum_news_head.profil.user.avatar.SRC}" alt="{forum_news_head.profil.user.avatar.SRC}" width="{forum_news_head.profil.user.avatar.WIDTH}" height="{forum_news_head.profil.user.avatar.HEIGHT}" /><br />
									<!-- END forum_news_head.profil.user.avatar -->
									<!-- BEGIN forum_news_head.profil.user.avatar_default -->
										<img src="./avatars/default.png" alt="./avatars/default.png" width="125" height="125" /><br />
									<!-- END forum_news_head.profil.user.avatar_default -->
									<br />{forum_news_head.profil.user.POST} : {forum_news_head.profil.user.NB_POSTS} <br /><br />
									<!-- BEGIN forum_news_head.profil.user.ranks -->
										{forum_news_head.profil.user.ranks.RANK}<br /><br />
									<!-- END forum_news_head.profil.user.ranks -->
									<!-- BEGIN forum_news_head.profil.user.reputation -->
										{forum_news_head.profil.user.reputation.REP} : {forum_news_head.profil.user.reputation.REPUTATION}<br />
										<a href="{forum_news_head.profil.user.reputation.URL_PLUS}">
											<img border="0"/ src="./themes/tpl/img/formulaires/plus.png" width="20" alt="+" style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;"/>
										</a>
										<a href="{forum_news_head.profil.user.reputation.URL_MOINS}">
											<img border="0"/ src="./themes/tpl/img/formulaires/moins.png" width="20" alt="-" style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;"/>
										</a>
										<br />
									<!-- END forum_news_head.profil.user.reputation -->
										<br />
										<!-- BEGIN forum_news_head.profil.user.mp -->
											<a href="{forum_news_head.profil.user.mp.MP_URL}">
												{forum_news_head.profil.user.mp.MP}
											</a>
										<!-- END forum_news_head.profil.user.mp -->
										<!-- BEGIN forum_news_head.profil.user.email -->
											 - <a href="mailto:{forum_news_head.profil.user.email.URL}">
												{forum_news_head.profil.user.email.TITRE}
											</a>
										<!-- END forum_news_head.profil.user.email -->
										<!-- BEGIN forum_news_head.profil.user.msn -->
											- <a href="mailto:{forum_news_head.profil.user.msn.URL}">
												{forum_news_head.profil.user.msn.TITRE}
											</a>
										<!-- END forum_news_head.profil.user.msn -->
										<!-- BEGIN forum_news_head.profil.user.yahoom -->
											- <a href="mailto:{forum_news_head.profil.user.yahoom.URL}">
												{forum_news_head.profil.user.yahoom.TITRE}
											</a>
										<!-- END forum_news_head.profil.user.yahoom -->
										<!-- BEGIN forum_news_head.profil.user.icq -->
											- <a href="mailto:{forum_news_head.profil.user.icq.URL}">
												{forum_news_head.profil.user.icq.TITRE}
											</a>
										<!-- END forum_news_head.profil.user.icq -->
										<!-- BEGIN forum_news_head.profil.user.aim -->
											- <a href="mailto:{forum_news_head.profil.user.aim.URL}">
												{forum_news_head.profil.user.aim.TITRE}
											</a>
										<!-- END forum_news_head.profil.user.aim -->
								<!-- END forum_news_head.profil.user -->
							<!-- END forum_news_head.profil -->
						</td>
						<td colspan="2" bgcolor="#F3F3F3">
							<div id="{forum_news_head.DIV_ID}">
								{forum_news_head.CONTENU}
							</div>
						</td>
					</tr>
						<tr>
							<td bgcolor="#F3F3F3">
						</td>
						<td bgcolor="#F3F3F3">
							<!-- BEGIN forum_news_head.signature -->
								<br />
									<fieldset>
										{forum_news_head.signature.SIGNATURE}
									</fieldset>
							<!-- END forum_news_head.signature -->
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br />
	<!-- BEGIN forum_news_head.page_haut -->
		<br />
		<center>
			{forum_news_head.page_haut.PAGE} :
			<!-- BEGIN forum_news_head.page_haut.pg -->
				<a href="{forum_news_head.page_haut.pg.URL}">
					<font size="{forum_news_head.page_haut.pg.SIZE}px">
						{forum_news_head.page_haut.pg.NM}
					</font>
				</a> 
				<!-- BEGIN forum_news_head.page_haut.pg.etc -->
					...
				<!-- END forum_news_head.page_haut.pg.etc -->
			<!-- END forum_news_head.page_haut.pg -->
		</center>
	<!-- END forum_news_head.page_haut -->
	<!-- BEGIN forum_news_head.comments -->
		<hr />
			<b>
				{forum_news_head.comments.COMMENTS} : 
			</b>
		<br />
		<table border="0" align="center" width="95%">
			<!-- BEGIN forum_news_head.comments.comm -->
				<tr>
					<td bgcolor="#F3F3F3">
						<table cellspacing="0" align="center" width="100%">
							<tr bgcolor="#CCCCCC">
								<td>
									<div class="topic_head">
										<a href="{forum_news_head.comments.comm.PROFIL_URL}">
											<strong>
												{forum_news_head.comments.comm.PSEUDO}
											</strong>
										</a>
									</div>
								</td>
								<td>
									<div class="topic_head">
										<!-- BEGIN forum_news_head.comments.comm.edit -->
											<a onclick="{forum_news_head.comments.comm.edit.ON_CLICK_EDIT}" href="{forum_news_head.comments.comm.edit.HREF_EDIT}">
												&raquo; {forum_news_head.comments.comm.edit.TXT_EDIT}
											</a>
										<!-- END forum_news_head.comments.comm.edit -->
										<!-- BEGIN forum_news_head.comments.comm.del -->
											<a href="{forum_news_head.comments.comm.del.HREF}">
												&raquo; {forum_news_head.comments.comm.del.TXT}
											</a>
										<!-- END forum_news_head.comments.comm.del -->
									</div>
								</td>
								<td align="right">
								{forum_news_head.comments.comm.THE} {forum_news_head.comments.comm.DATE}
								</td>
							</tr>
							<tr>
								<td width="25%" bgcolor="#DDDDDD" align="center">
									<!-- BEGIN forum_news_head.comments.comm.profil -->
										<!-- BEGIN forum_news_head.comments.comm.profil.none -->
											{forum_news_head.comments.comm.profil.none.TXT}
										<!-- END forum_news_head.comments.comm.profil.none -->
										<!-- BEGIN forum_news_head.comments.comm.profil.user -->
											<!-- BEGIN forum_news_head.comments.comm.profil.user.avatar -->
												<img src="{forum_news_head.comments.comm.profil.user.avatar.SRC}" alt="{forum_news_head.comments.comm.profil.user.avatar.SRC}" width="{forum_news_head.comments.comm.profil.user.avatar.WIDTH}" height="{forum_news_head.comments.comm.profil.user.avatar.HEIGHT}" /><br />
											<!-- END forum_news_head.comments.comm.profil.user.avatar -->
											<!-- BEGIN forum_news_head.comments.comm.profil.user.avatar_default -->
												<img src="./avatars/default.png" alt="./avatars/default.png" width="125" height="125" /><br />
											<!-- END forum_news_head.comments.comm.profil.user.avatar_default -->
											<br />{forum_news_head.comments.comm.profil.user.POST} : {forum_news_head.comments.comm.profil.user.NB_POSTS} <br /><br />
											<!-- BEGIN forum_news_head.comments.comm.profil.user.ranks -->
												{forum_news_head.comments.comm.profil.user.ranks.RANK}<br /><br />
											<!-- END forum_news_head.comments.comm.profil.user.ranks -->
											<!-- BEGIN forum_news_head.comments.comm.profil.user.reputation -->
												{forum_news_head.comments.comm.profil.user.reputation.REP} : {forum_news_head.comments.comm.profil.user.reputation.REPUTATION}<br />
												<a href="{forum_news_head.comments.comm.profil.user.reputation.URL_PLUS}">
													<img border="0"/ src="./themes/tpl/img/formulaires/plus.png" width="20" alt="+" style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;"/>
												</a>
												<a href="{forum_news_head.comments.comm.profil.user.reputation.URL_MOINS}">
													<img border="0"/ src="./themes/tpl/img/formulaires/moins.png" width="20" alt="-" style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;"/>
												</a>
												<br />
											<!-- END forum_news_head.comments.comm.profil.user.reputation -->
												<br />
												<!-- BEGIN forum_news_head.comments.comm.profil.user.mp -->
													<a href="{forum_news_head.comments.comm.profil.user.mp.MP_URL}">
														{forum_news_head.comments.comm.profil.user.mp.MP}
													</a>
												<!-- END forum_news_head.comments.comm.profil.user.mp -->
												<!-- BEGIN forum_news_head.comments.comm.profil.user.email -->
													 - <a href="mailto:{forum_news_head.comments.comm.profil.user.email.URL}">{forum_news_head.comments.comm.profil.user.email.TITRE}</a>
												<!-- END forum_news_head.comments.comm.profil.user.email -->
												<!-- BEGIN forum_news_head.comments.comm.profil.user.msn -->
													- <a href="mailto:{forum_news_head.comments.comm.profil.user.msn.URL}">{forum_news_head.comments.comm.profil.user.msn.TITRE}</a>
												<!-- END forum_news_head.comments.comm.profil.user.msn -->
												<!-- BEGIN forum_news_head.comments.comm.profil.user.yahoom -->
													- <a href="mailto:{forum_news_head.comments.comm.profil.user.yahoom.URL}">{forum_news_head.comments.comm.profil.user.yahoom.TITRE}</a>
												<!-- END forum_news_head.comments.comm.profil.user.yahoom -->
												<!-- BEGIN forum_news_head.comments.comm.profil.user.icq -->
													- <a href="mailto:{forum_news_head.comments.comm.profil.user.icq.URL}">{forum_news_head.comments.comm.profil.user.icq.TITRE}</a>
												<!-- END forum_news_head.comments.comm.profil.user.icq -->
												<!-- BEGIN forum_news_head.comments.comm.profil.user.aim -->
													- <a href="mailto:{forum_news_head.comments.comm.profil.user.aim.URL}">{forum_news_head.comments.comm.profil.user.aim.TITRE}</a>
												<!-- END forum_news_head.comments.comm.profil.user.aim -->
										<!-- END forum_news_head.comments.comm.profil.user -->
									<!-- END forum_news_head.comments.comm.profil -->
								</td>
								<td colspan="2" bgcolor="#F3F3F3">
									<div id="{forum_news_head.comments.comm.DIV_ID}">
										{forum_news_head.comments.comm.CONTENU}
									</div>
								</td>
							</tr>
								<tr>
									<td bgcolor="#F3F3F3">
								</td>
								<td bgcolor="#F3F3F3">
									<!-- BEGIN forum_news_head.comments.comm.signature -->
										<br />
											<fieldset style="width:100%;">
												{forum_news_head.comments.comm.signature.SIGNATURE}
											</fieldset>
									<!-- END forum_news_head.comments.comm.signature -->
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<!-- END forum_news_head.comments.comm -->
		</table>
	<!-- END forum_news_head.comments -->
	<br /><br /><hr />
	<!-- BEGIN forum_news_head.page_bas -->
		<br />
		<center>
			{forum_news_head.page_bas.PAGE} :
			<!-- BEGIN forum_news_head.page_bas.pg -->
				<a href="{forum_news_head.page_bas.pg.URL}">
					<font size="{forum_news_head.page_bas.pg.SIZE}px">
						{forum_news_head.page_bas.pg.NM}
					</font>
				</a> 
				<!-- BEGIN forum_news_head.page_bas.pg.etc -->
					...
				<!-- END forum_news_head.page_bas.pg.etc -->
			<!-- END forum_news_head.page_bas.pg -->
		</center>
	<!-- END forum_news_head.page_bas -->
	<br />
	<!-- BEGIN forum_news_head.foot_news_post -->
		<a href="{forum_news_head.foot_news_post.HREF}">
			[{forum_news_head.foot_news_post.TXT}]
		</a><br /><br />
	<!-- END forum_news_head.foot_news_post -->
<!-- END forum_news_head -->


<!-- BEGIN forum_topic -->
	{forum_topic.JS}
	<center>
		<strong> - {forum_topic.NOM} - </strong> 
		<br /><br />
		<img src="./themes/tpl/img/forum/puce.png" alt="Puce"/>&nbsp;
			<a href="index.php?mods=forum">
				{forum_topic.ACCUEIL}
			</a>&nbsp;&nbsp;&nbsp;
		<img src="./themes/tpl/img/forum/puce.png" alt="Puce"/>&nbsp;
			<a href="index.php?mods=forum&amp;rules">
				{forum_topic.FORUM_RULES}
			</a>&nbsp;&nbsp;&nbsp;
		<img src="./themes/tpl/img/forum/puce.png" alt="Puce"/>&nbsp;
			<a href="index.php?mods=forum&amp;page=search">
				{forum_topic.SEARCH}
			</a>&nbsp;&nbsp;&nbsp;
		<br /><br />
		<fieldset>
			<legend>
				{forum_topic.FAST_SEARCH}
			</legend>
			<br />
			<form method="post" action="index.php?mods=forum&amp;page=search">
				<table style="width: 90%;" border="0">
					<tr>
						<td>
							<input type="text" style="color: grey;" id="search" value="{forum_topic.SEARCH}" name="search" onblur="reload();" onfocus="load();"/>
						</td>
						<td>
							<input type="checkbox" name="search_titre" value="1"/>
						</td>
						<td>
							{forum_topic.ON_THE_TITLE}
						</td>
						<td>
							<input type="checkbox" name="search_contenu" value="1"/>
						</td>
						<td>
							{forum_topic.ON_THE_CONTENT}
						</td>
						<td>
							<input type="submit" value="{forum_topic.SEARCH}" />
						</td>
					</tr>
				</table>
			</form>
		</fieldset>
	</center>
	<br /><br />
	<a href="./index.php?mods=forum">
		[{forum_topic.ACCUEIL}]
	</a>
	&raquo;
	<a href="index.php?mods=forum">
		<strong>
			{forum_topic.CAT_PARENT}
		</strong>
	</a>
	<!-- BEGIN forum_topic.links -->
		&raquo; ...
	<!-- END forum_topic.links -->
	<!-- BEGIN forum_topic.links1 -->
		&raquo;
		<a href="{forum_topic.links1.URL}">
			<strong>
				{forum_topic.links1.NOM}
			</strong>
		</a>
	<!-- END forum_topic.links1 -->
	<!-- BEGIN forum_topic.links2 -->
		&raquo;
		<a href="{forum_topic.links2.URL}">
			<strong>
				{forum_topic.links2.NOM}
			</strong>
		</a>
	<!-- END forum_topic.links2 -->
	<!-- BEGIN forum_topic.links3 -->
		&raquo;
		<a href="{forum_topic.links3.URL}">
			<strong>
				{forum_topic.links3.NOM}
			</strong>
		</a>
	<!-- END forum_topic.links3 -->
	<br /><br /><br />
	<!-- BEGIN forum_topic.head_post -->
		<br />
		<a href="{forum_topic.head_post.HREF}">
			<strong>
				[{forum_topic.head_post.TXT}]
			</strong>
		</a>
		<br /><br />
	<!-- END forum_topic.head_post -->
	
	<br />
	<script type="text/javascript" src="./mods/ajax/real_time_edit.js"></script>
	<table border="0" align="center" width="95%">
		<tr>
			<td bgcolor="#F3F3F3">
				<table cellspacing="0" align="center" width="100%">
					<tr bgcolor="#CCCCCC">
						<td>
							<div class="topic_head">
								<a href="{forum_topic.PROFIL_URL}">
									<strong>
										{forum_topic.PSEUDO}
									</strong>
								</a>
							</div>
						</td>
						<td>
							<div class="topic_head">
								<!-- BEGIN forum_topic.edit -->
									<a onclick="{forum_topic.edit.ON_CLICK}" href="{forum_topic.edit.HREF}">
										&raquo; {forum_topic.edit.TXT}
									</a>
								<!-- END forum_topic.edit -->
								<!-- BEGIN forum_topic.delete -->
									<a href="{forum_topic.delete.HREF}">
										&raquo; {forum_topic.delete.TXT}
									</a>
								<!-- END forum_topic.delete -->
							</div>
						</td>
						<td align="right">
						{forum_topic.THE} {forum_topic.DATE}
						</td>
					</tr>
					<tr>
						<td width="25%" bgcolor="#DDDDDD" align="center">
							<!-- BEGIN forum_topic.profil -->
								<!-- BEGIN forum_topic.profil.none -->
									{forum_topic.profil.none.TXT}
								<!-- END forum_topic.profil.none -->
								<!-- BEGIN forum_topic.profil.user -->
									<!-- BEGIN forum_topic.profil.user.avatar -->
										<img src="{forum_topic.profil.user.avatar.SRC}" alt="{forum_topic.profil.user.avatar.SRC}" width="{forum_topic.profil.user.avatar.WIDTH}" height="{forum_topic.profil.user.avatar.HEIGHT}" /><br />
									<!-- END forum_topic.profil.user.avatar -->
									<!-- BEGIN forum_topic.profil.user.avatar_default -->
										<img src="./avatars/default.png" alt="./avatars/default.png" width="125" height="125" /><br />
									<!-- END forum_topic.profil.user.avatar_default -->
									<br />{forum_topic.profil.user.POST} : {forum_topic.profil.user.NB_POSTS} <br /><br />
									<!-- BEGIN forum_topic.profil.user.ranks -->
										{forum_topic.profil.user.ranks.RANK}<br /><br />
									<!-- END forum_topic.profil.user.ranks -->
									<!-- BEGIN forum_topic.profil.user.reputation -->
										{forum_topic.profil.user.reputation.REP} : {forum_topic.profil.user.reputation.REPUTATION}<br />
										<a href="{forum_topic.profil.user.reputation.URL_PLUS}">
											<img border="0"/ src="./themes/tpl/img/formulaires/plus.png" width="20" alt="+" style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;"/>
										</a>
										<a href="{forum_topic.profil.user.reputation.URL_MOINS}">
											<img border="0"/ src="./themes/tpl/img/formulaires/moins.png" width="20" alt="-" style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;"/>
										</a>
										<br />
									<!-- END forum_topic.profil.user.reputation -->
										<br />
										<!-- BEGIN forum_topic.profil.user.mp -->
											<a href="{forum_topic.profil.user.mp.MP_URL}">
												{forum_topic.profil.user.mp.MP}
											</a>
										<!-- END forum_topic.profil.user.mp -->
										<!-- BEGIN forum_topic.profil.user.email -->
											 - <a href="mailto:{forum_topic.profil.user.email.URL}">{forum_topic.profil.user.email.TITRE}</a>
										<!-- END forum_topic.profil.user.email -->
										<!-- BEGIN forum_topic.profil.user.msn -->
											- <a href="mailto:{forum_topic.profil.user.msn.URL}">{forum_topic.profil.user.msn.TITRE}</a>
										<!-- END forum_topic.profil.user.msn -->
										<!-- BEGIN forum_topic.profil.user.yahoom -->
											- <a href="mailto:{forum_topic.profil.user.yahoom.URL}">{forum_topic.profil.user.yahoom.TITRE}</a>
										<!-- END forum_topic.profil.user.yahoom -->
										<!-- BEGIN forum_topic.profil.user.icq -->
											- <a href="mailto:{forum_topic.profil.user.icq.URL}">{forum_topic.profil.user.icq.TITRE}</a>
										<!-- END forum_topic.profil.user.icq -->
										<!-- BEGIN forum_topic.profil.user.aim -->
											- <a href="mailto:{forum_topic.profil.user.aim.URL}">{forum_topic.profil.user.aim.TITRE}</a>
										<!-- END forum_topic.profil.user.aim -->
								<!-- END forum_topic.profil.user -->
							<!-- END forum_topic.profil -->
						</td>
						<td colspan="2" bgcolor="#F3F3F3">
							<div id="{forum_topic.DIV_ID}">
								{forum_topic.CONTENU}
							</div>
						</td>
					</tr>
						<tr>
							<td bgcolor="#F3F3F3">
						</td>
						<td bgcolor="#F3F3F3">
							<!-- BEGIN forum_topic.signature -->
								<br />
									<fieldset>
										{forum_topic.signature.SIGNATURE}
									</fieldset>
							<!-- END forum_topic.signature -->
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br />
	<!-- BEGIN forum_topic.page_haut -->
		<br />
		<center>
			{forum_topic.page_haut.PAGE} :
			<!-- BEGIN forum_topic.page_haut.pg -->
				<a href="{forum_topic.page_haut.pg.URL}">
					<font size="{forum_topic.page_haut.pg.SIZE}px">
						{forum_topic.page_haut.pg.NM}
					</font>
				</a> 
				<!-- BEGIN forum_topic.page_haut.pg.etc -->
					...
				<!-- END forum_topic.page_haut.pg.etc -->
			<!-- END forum_topic.page_haut.pg -->
		</center>
	<!-- END forum_topic.page_haut -->
	<!-- BEGIN forum_topic.replys -->
		<hr />
			<b>
				{forum_topic.replys.REPLYS} : 
			</b>
		<br />
		<table border="0" align="center" width="95%">
			<!-- BEGIN forum_topic.replys.rep -->
				<tr>
					<td bgcolor="#F3F3F3">
						<div id="r-{forum_topic.replys.rep.ID}">
							<table cellspacing="0" align="center" width="100%">
								<tr bgcolor="#CCCCCC">
									<td>
										<div class="topic_head">
											<a href="{forum_topic.replys.rep.PROFIL_URL}">
												<strong>
													{forum_topic.replys.rep.PSEUDO}
												</strong>
											</a>
										</div>
									</td>
									<td>
										<div class="topic_head">
											<!-- BEGIN forum_topic.replys.rep.edit -->
												<a onclick="{forum_topic.replys.rep.edit.ON_CLICK}" href="{forum_topic.replys.rep.edit.HREF}">
													&raquo; {forum_topic.replys.rep.edit.TXT}
												</a>
											<!-- END forum_topic.replys.rep.edit -->
											<!-- BEGIN forum_topic.replys.rep.del -->
												<a href="{forum_topic.replys.rep.del.HREF}">
													&raquo; {forum_topic.replys.rep.del.TXT}
												</a>
											<!-- END forum_topic.replys.rep.del -->
										</div>
									</td>
									<td align="right">
										<a href="#r-{forum_topic.replys.rep.ID}">
											{forum_topic.replys.rep.THE} {forum_topic.replys.rep.DATE}
										</a>
									</td>
								</tr>
								<tr>
									<td width="25%" bgcolor="#DDDDDD" align="center">
										<!-- BEGIN forum_topic.replys.rep.profil -->
											<!-- BEGIN forum_topic.replys.rep.profil.none -->
												{forum_topic.replys.rep.profil.none.TXT}
											<!-- END forum_topic.replys.rep.profil.none -->
											<!-- BEGIN forum_topic.replys.rep.profil.user -->
												<!-- BEGIN forum_topic.replys.rep.profil.user.avatar -->
													<img src="{forum_topic.replys.rep.profil.user.avatar.SRC}" alt="{forum_topic.replys.rep.profil.user.avatar.SRC}" width="{forum_topic.replys.rep.profil.user.avatar.WIDTH}" height="{forum_topic.replys.rep.profil.user.avatar.HEIGHT}" /><br />
												<!-- END forum_topic.replys.rep.profil.user.avatar -->
												<!-- BEGIN forum_topic.replys.rep.profil.user.avatar_default -->
													<img src="./avatars/default.png" alt="./avatars/default.png" width="125" height="125" /><br />
												<!-- END forum_topic.replys.rep.profil.user.avatar_default -->
												<br />{forum_topic.replys.rep.profil.user.POST} : {forum_topic.replys.rep.profil.user.NB_POSTS} <br /><br />
												<!-- BEGIN forum_topic.replys.rep.profil.user.ranks -->
													{forum_topic.replys.rep.profil.user.ranks.RANK}<br /><br />
												<!-- END forum_topic.replys.rep.profil.user.ranks -->
												<!-- BEGIN forum_topic.replys.rep.profil.user.reputation -->
													{forum_topic.replys.rep.profil.user.reputation.REP} : {forum_topic.replys.rep.profil.user.reputation.REPUTATION}<br />
													<a href="{forum_topic.replys.rep.profil.user.reputation.URL_PLUS}">
														<img border="0"/ src="./themes/tpl/img/formulaires/plus.png" width="20" alt="+" style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;"/>
													</a>
													<a href="{forum_topic.replys.rep.profil.user.reputation.URL_MOINS}">
														<img border="0"/ src="./themes/tpl/img/formulaires/moins.png" width="20" alt="-" style="-moz-border-radius: 4px;border-width:1px; border-style: solid; border-color:#D3D3D3;"/>
													</a>
													<br />
												<!-- END forum_topic.replys.rep.profil.user.reputation -->
													<br />
													<!-- BEGIN forum_topic.replys.rep.profil.user.mp -->
														<a href="{forum_topic.replys.rep.profil.user.mp.MP_URL}">
															{forum_topic.replys.rep.profil.user.mp.MP}
														</a>
													<!-- END forum_topic.replys.rep.profil.user.mp -->
													<!-- BEGIN forum_topic.replys.rep.profil.user.email -->
														 - <a href="mailto:{forum_topic.replys.rep.profil.user.email.URL}">{forum_topic.replys.rep.profil.user.email.TITRE}</a>
													<!-- END forum_topic.replys.rep.profil.user.email -->
													<!-- BEGIN forum_topic.replys.rep.profil.user.msn -->
														- <a href="mailto:{forum_topic.replys.rep.profil.user.msn.URL}">{forum_topic.replys.rep.profil.user.msn.TITRE}</a>
													<!-- END forum_topic.replys.rep.profil.user.msn -->
													<!-- BEGIN forum_topic.replys.rep.profil.user.yahoom -->
														- <a href="mailto:{forum_topic.replys.rep.profil.user.yahoom.URL}">{forum_topic.replys.rep.profil.user.yahoom.TITRE}</a>
													<!-- END forum_topic.replys.rep.profil.user.yahoom -->
													<!-- BEGIN forum_topic.replys.rep.profil.user.icq -->
														- <a href="mailto:{forum_topic.replys.rep.profil.user.icq.URL}">{forum_topic.replys.rep.profil.user.icq.TITRE}</a>
													<!-- END forum_topic.replys.rep.profil.user.icq -->
													<!-- BEGIN forum_topic.replys.rep.profil.user.aim -->
														- <a href="mailto:{forum_topic.replys.rep.profil.user.aim.URL}">{forum_topic.replys.rep.profil.user.aim.TITRE}</a>
													<!-- END forum_topic.replys.rep.profil.user.aim -->
											<!-- END forum_topic.replys.rep.profil.user -->
										<!-- END forum_topic.replys.rep.profil -->
									</td>
									<td colspan="2" bgcolor="#F3F3F3">
										<div id="{forum_topic.replys.rep.DIV_ID}">
											{forum_topic.replys.rep.CONTENU}
										</div>
									</td>
								</tr>
									<tr>
										<td bgcolor="#F3F3F3">
									</td>
									<td bgcolor="#F3F3F3">
										<!-- BEGIN forum_topic.replys.rep.signature -->
											<br />
												<fieldset style="width:100%;">
													{forum_topic.replys.rep.signature.SIGNATURE}
												</fieldset>
										<!-- END forum_topic.replys.rep.signature -->
									</td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
			<!-- END forum_topic.replys.rep -->
		</table>
	<!-- END forum_topic.replys -->
	<br /><br /><hr />
	<!-- BEGIN forum_topic.page_bas -->
		<br />
		<center>
			{forum_topic.page_bas.PAGE} :
			<!-- BEGIN forum_topic.page_bas.pg -->
				<a href="{forum_topic.page_bas.pg.URL}">
					<font size="{forum_topic.page_bas.pg.SIZE}px">
						{forum_topic.page_bas.pg.NM}
					</font>
				</a> 
				<!-- BEGIN forum_topic.page_bas.pg.etc -->
					...
				<!-- END forum_topic.page_bas.pg.etc -->
			<!-- END forum_topic.page_bas.pg -->
		</center>
	<!-- END forum_topic.page_bas -->
	<br />
	<!-- BEGIN forum_topic.foot_post -->
			<form method="post" action="{forum_topic.foot_post.HREF}">
				{forum_topic.foot_post.FORMULAIRE}
			</form>
		<br /><br />
		<hr />
		<br />
		<a href="{forum_topic.foot_post.HREF}">
			<strong>
				[{forum_topic.foot_post.TXT}]
			</strong>
		</a>
		<br /><br />
	<!-- END forum_topic.foot_post -->
	<br />
	<table border="0" style="width: 98%;">
		<tr>
			<td style="width:50%">
				<!-- BEGIN forum_topic.move -->
					<strong>
						<a href="{forum_topic.move.URL}">
							[{forum_topic.move.TXT}]
						</a>
					</strong>
				<!-- END forum_topic.move -->
			</td>
			<td style="width:50%">
				<!-- BEGIN forum_topic.signal -->
					<strong>
						<a href="{forum_topic.signal.URL}">
							[{forum_topic.signal.TXT}]
						</a>
					</strong>
				<!-- END forum_topic.signal -->
			</td>
		</tr>
		<tr>
			<td style="width:50%">
				<!-- BEGIN forum_topic.lock -->
					<strong>
						<a href="{forum_topic.lock.URL}">
							[{forum_topic.lock.TXT}]
						</a>
					</strong>
				<!-- END forum_topic.lock -->
				<!-- BEGIN forum_topic.unlock -->
					<strong>
						<a href="{forum_topic.unlock.URL}">
							[{forum_topic.unlock.TXT}]
						</a>
					</strong>
				<!-- END forum_topic.unlock -->
			</td>
			<td style="width:50%">
				<!-- BEGIN forum_topic.attach -->
					<strong>
						<a href="{forum_topic.attach.URL}">
							[{forum_topic.attach.TXT}]
						</a>
					</strong>
				<!-- END forum_topic.attach -->
				<!-- BEGIN forum_topic.unattach -->
					<strong>
						<a href="{forum_topic.unattach.URL}">
							[{forum_topic.unattach.TXT}]
						</a>
					</strong>
				<!-- END forum_topic.unattach -->
			</td>
		</tr>
	</table>
<!-- END forum_topic -->

<!-- BEGIN forum_topic_action -->
	<br />
		{forum_topic_action.TXT}
	<br /><br />
	<a href="{forum_topic_action.URL}">
		{forum_topic_action.BACK}
	</a>
<!-- END forum_topic_action -->