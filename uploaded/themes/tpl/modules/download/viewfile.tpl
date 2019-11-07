<!-- BEGIN file -->
	<script type="text/javascript" src="./mods/ajax/real_time_edit.js"></script>
	<!-- BEGIN file.admin_file -->
		<a href="index.php?mods=download&amp;page=admin&amp;edit_file={file.admin_file.ID}">
			[{file.admin_file.EDIT}]
		</a>
		<a href="index.php?mods=download&amp;page=admin&amp;del_file={file.admin_file.ID}">
			[{file.admin_file.DEL}]
		</a>
		<br /><br />
	<!-- END file.admin_file -->
	<fieldset>
		<legend>
			{file.NOM}
		</legend>
		<br />
		{file.CONTENU}
			<!-- BEGIN file.notes -->
				<br /><br />
				{file.notes.NOTE} : <br />
				<p style="text-align: center;">
					<!-- BEGIN file.notes.note -->
						<img src="./themes/tpl/img/download/{file.notes.note.IMG}.png" alt="{file.notes.note.IMG}"/>
					<!-- END file.notes.note -->
				</p>
			<!-- END file.notes -->
	</fieldset>
	<br />
	<fieldset>
		<legend>
			{file.DOWNLOAD}
		</legend>
		<br />
		<!-- BEGIN file.dl_need -->
			<font color="red">
				{file.dl_need.CANT}<br /><br />
				<!-- BEGIN file.dl_need.err -->
					&raquo; {file.dl_need.err.TXT}<br />
				<!-- END file.dl_need.err -->
			</font>
		<!-- END file.dl_need -->
		
		<!-- BEGIN file.pass -->
			<!-- BEGIN file.pass.error -->
				<font color="red">
					{file.pass.error.TXT}
				</font>
				<br /><br />
			<!-- END file.pass.error -->
			<form method="post" action="">
				&raquo; {file.pass.TXT} <br /><br />
				<input type="password" name="file_pass" />
				<input type="hidden" name="file_id" value="{file.pass.ID}" />
				<p style="text-align: center;">
					<input type="submit" value="{file.pass.VALID}"
				</p>
			</form>
		<!-- END file.pass -->
		
		<!-- BEGIN file.dl -->
			<center>
				<table border="0" style="width: 95%;">
					<tr>
						<td style="width: 50%;">
							<p style="text-align: center;">
								<a href="index.php?mods=download&amp;page=dl&amp;id={file.dl.ID}">
									<img src="./themes/tpl/img/download/dl.png" alt="GO" border="0"/>
								</a>
							</p>
						</td>
						<td style="width: 50%;">
							<p style="text-align: center;">
								<a href="index.php?mods=download&amp;page=recommander&amp;id={file.dl.ID}">
									<img src="./themes/tpl/img/download/reco.png" alt="x" border="0"/>
								</a>
							</p>
						</td>
					</tr>
				</table>
			</center>
		<!-- END file.dl -->		
	</fieldset><br />
	<!-- BEGIN file.plus -->
		<fieldset>
			<legend>
				{file.plus.INFOPLUS}
			</legend>
			<br />
			<!-- BEGIN file.plus.editor -->
				{file.plus.editor.NOM} : {file.plus.editor.VALUE}<br />
			<!-- END file.plus.editor -->
			<!-- BEGIN file.plus.version -->
				{file.plus.version.NOM} : {file.plus.version.VALUE}<br />
			<!-- END file.plus.version -->
			<!-- BEGIN file.plus.sortie -->
				{file.plus.sortie.NOM} : {file.plus.sortie.VALUE}<br />
			<!-- END file.plus.sortie -->
			<!-- BEGIN file.plus.licence -->
				{file.plus.licence.NOM} : {file.plus.licence.VALUE}<br />
			<!-- END file.plus.licence -->
			<!-- BEGIN file.plus.size -->
				{file.plus.size.NOM} : {file.plus.size.VALUE} {file.plus.size.EXT}<br />
			<!-- END file.plus.size -->
		</fieldset><br />
	<!-- END file.plus -->
	<!-- BEGIN file.stats -->
		<fieldset>
			{file.stats.NB_HIT} : {file.stats.NB_HITS}<br />
			{file.stats.NB_DL} : {file.stats.NB_DLS}<br />
		</fieldset><br />
	<!-- END file.stats -->
	<!-- BEGIN file.pics -->
		<fieldset>
			<legend>
				{file.pics.TXT}
			</legend>
			<br />
			<!-- BEGIN file.pics.pic -->
				&raquo; <a href="{file.pics.pic.URL}">
					{file.pics.pic.URL}
				</a><br />
			<!-- END file.pics.pic -->
		</fieldset><br />
	<!-- END file.pics -->
	<!-- BEGIN file.comms -->
		<fieldset>
			<legend>
				{file.comms.COMMENTS}
			</legend>
			<br />
			<!-- BEGIN file.comms.add -->
				<a href="index.php?mods=download&amp;page=add_comment&amp;id={file.comms.add.ID}">
					&raquo; {file.comms.add.ADD}
				</a><br /><br />
			<!-- END file.comms.add -->
			<!-- BEGIN file.comms.cant_add -->
				&raquo; {file.comms.cant_add.TXT}
				<br /><br />
			<!-- END file.comms.cant_add -->
			
			<!-- BEGIN file.comms.none -->
				{file.comms.none.TXT}<br /><br />
			<!-- END file.comms.none -->
			
			<!-- BEGIN file.comms.com -->
				<fieldset>
					<legend>
						{file.comms.com.COMMENT_FROM} : {file.comms.com.PSEUDO}
						<!-- BEGIN file.comms.com.admin -->
							&nbsp; 
							<a href="index.php?mods=download&page=admin&del_comment={file.comms.com.admin.ID}">
								[ {file.comms.com.admin.DELETE} ]
							</a>
							&nbsp; 
							<a onclick="real_edit('com_{file.comms.com.admin.ID}','{file.comms.com.admin.UID}','{file.comms.com.admin.PWD}','{file.comms.com.admin.ID}','dl_comment', '{file.comms.com.admin.USER_AGENT}','{file.comms.com.admin.LANGUE}','{file.comms.com.admin.THEME}' );return false;" href="index.php?mods=download&page=admin&edit_comment={file.comms.com.admin.ID}">
								[ {file.comms.com.admin.EDIT} ]
							</a>
						<!-- END file.comms.com.admin -->
					</legend>
					<br />
					<div id="com_{file.comms.com.ID}">
						{file.comms.com.CONTENU}
					</div>
					<br /><br />
					{file.comms.com.NOTE} : {file.comms.com.NT} / 10.<br />
					{file.comms.com.THE} {file.comms.com.DATE}
				</fieldset><br />
			<!-- END file.comms.com -->
			
			<!-- BEGIN file.comms.add -->
				<a href="index.php?mods=download&amp;page=add_comment&amp;id={file.comms.add.ID}">
					&raquo; {file.comms.add.ADD}
				</a><br /><br />
			<!-- END file.comms.add -->
			<!-- BEGIN file.comms.cant_add -->
				&raquo; {file.comms.cant_add.TXT}
				<br /><br />
			<!-- END file.comms.cant_add -->
			<!-- BEGIN file.comms.page -->
				<br />
				<center>
					{file.comms.page.PAGE} :
					<!-- BEGIN file.comms.page.pg -->
						<a href="{file.comms.page.pg.URL}">
							<font size="{file.comms.page.pg.SIZE}px">
								{file.comms.page.pg.NM}
							</font>
						</a> 
						<!-- BEGIN file.comms.page.pg.etc -->
							...
						<!-- END file.comms.page.pg.etc -->
					<!-- END file.comms.page.pg -->
				</center>
			<!-- END file.comms.page -->
		</fieldset>
	<!-- END file.comms -->
	<!-- BEGIN file.expiration -->
		<font color="red">
			&raquo; {file.expiration.TXT}
		</font><br />
	<!-- END file.expiration -->
	
	<br />
	<a href="index.php?mods=download&amp;page=viewcat&amp;id={file.ID}">
		{file.BACK}
	</a>
<!-- END file -->