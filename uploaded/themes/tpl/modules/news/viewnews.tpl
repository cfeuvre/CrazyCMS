<!-- BEGIN text -->
	{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
<!-- END text -->

<!-- BEGIN news -->
	{news.JS}
	<div id="news_{news.ID}">
		<br />
		{news.TXT}
		<br />
	</div>
	<br />
	{news.BY} : 
	<a href="index.php?mods=espace_membre&amp;page=profil&amp;id={news.ID_USER}">
		{news.PSEUDO}
	</a>, {news.THE} : {news.DATE}
	<!-- BEGIN news.add_comment -->
		<a href="./index.php?mods=news&amp;page=post_comment&amp;news={news.add_comment.ID}">
			{news.add_comment.ADD}
		</a>
	<!-- END news.add_comment -->
	<!-- BEGIN news.edit -->
		<a onclick="real_edit('news_{news.edit.ID}','{news.edit.UID}','{news.edit.PWD}','{news.edit.ID}','news', '{news.edit.USER_AGENT}','{news.edit.LANG}','{news.edit.THEME}' );return false;" href="index.php?mods=news&page=admin&modif={news.edit.ID}">
			[ {news.edit.EDIT} ]
		</a>
	<!-- END news.edit -->
	
	<!-- BEGIN news.comm -->
		<br /><br /><hr />
		<h2>
			<a href="#n{news.comm.I}">
				[{news.comm.I}]
			</a>
			 {news.comm.COMMENT_FROM} : {news.comm.PSEUDO}
		</h2>
		<div id="n{news.comm.I}">
			<br />
			{news.comm.CONTENU}
			<br /><br />
			{news.THE} {news.comm.DATE}
		</div>
		<!-- BEGIN news.comm.del -->
			<br />{news.comm.del.JS}
			<a href="javascript:del('{news.comm.del.ID}');">
				{news.comm.del.REMOVE}
			</a>
		<!-- END news.comm.del -->
		<!-- BEGIN news.comm.edit -->
			&nbsp;
			<a onclick="real_edit('n{news.comm.I}','{news.comm.edit.UID}','{news.comm.edit.PWD}','{news.comm.edit.ID_COM}','comment', '{news.comm.edit.USER_AGENT}','{news.comm.edit.LANG}','{news.comm.edit.THEME}' );return false;" href="index.php?mods=news&amp;page=editcom&amp;edit={news.comm.edit.ID_COM}&amp;news={news.comm.edit.ID_NEWS}&amp;i={news.comm.I}">
				{news.comm.edit.MODIFY}
			</a>
		<!-- END news.comm.edit -->
	<!-- END news.comm -->
<!-- END news -->