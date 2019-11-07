<!-- BEGIN index -->
	{index.JS}
	<br />
	<!-- BEGIN index.news -->
		<div class="bloc2" style="display: block;overflow:hidden;overflow-x: auto;overflow-y: hidden;width:95%;">
		    <h2>
				{index.news.TITRE}
			</h2>
			<div id="news_{index.news.ID}">
				<br />
				{index.news.TEXTE}
				<br />
			</div>
			<br />
			{index.news.BY} : 
			<a href="index.php?mods=espace_membre&amp;page=profil&amp;id={index.news.ID_USER}">
				{index.news.PSEUDO}
			</a>, 
			{index.news.THE} : {index.news.DATE}.
			{index.news.VIEW} : {index.news.HIT} {index.news.FOIS}, 
			{index.news.COMMENTS_NBR} {index.news.COMMENTS}
			<br />
			<!-- BEGIN index.news.edit -->
				<a onclick="real_edit('news_{index.news.ID}','{index.news.edit.UID}','{index.news.edit.PWD}','{index.news.ID}','news', '{index.news.edit.USER_AGENT}','{index.news.edit.LANG}','{index.news.edit.THEME}' );return false;">
					[ {index.news.edit.EDIT} ]
				</a>
			<!-- END index.news.edit -->
			<!-- BEGIN index.news.addc -->
				<a href="./index.php?mods=news&amp;page=post_comment&amp;news={index.news.ID}">
					{index.news.addc.ADD}.
				</a>
			<!-- END index.news.addc -->
			<a href="./index.php?mods=news&amp;page=viewnews&amp;news={index.news.ID}">
				{index.news.SUITE}.
			</a>
		</div>
	<!-- END index.news -->
	<!-- BEGIN index.none -->
		{index.none.TXT}
		<br /><br />
	<!-- END index.none -->
	<a href="./mods/news/news.xml">
		<img src="./themes/tpl/img/news/rss.png" alt="rss" border="0"/>
	</a>
	<a href="index.php?mods=news&amp;page=allnews">
		{index.VIEW_ALL_NEWS}
	</a>
<!-- END index -->