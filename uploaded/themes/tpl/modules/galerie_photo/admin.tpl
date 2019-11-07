<!-- BEGIN index -->
	<br />
	<u>
		{index.GALERIE_WHO_EXISTS} : 
	</u>
	<br /><br />
	<!-- BEGIN index.gal -->
		<a href="{index.gal.URL}">
			{index.gal.FILE}
		</a>
	<!-- END index.gal -->
	<!-- BEGIN index.ngal -->
		{index.ngal.TXT}
	<!-- END index.ngal -->
	
	<!-- BEGIN index.indexation -->
		<br /><br />
			{index.indexation.TXT} : 
		<br /><br />
	<!-- END index.indexation -->
	<!-- BEGIN index.ind -->
		<a href="{index.ind.URL}">
			{index.ind.FILE}
		</a>
	<!-- END index.ind -->
	<br /><br />
	<a href="index.php?mods=galerie_photo&amp;page=admin&amp;add">
		{index.ADD_GALLERY}
	</a>
	<br /><br />
	<a href="index.php?mods=admin">
		{index.BACK}
	</a>
<!-- END index -->

<!-- BEGIN text -->
	<br />
	{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
<!-- END text -->

<!-- BEGIN upload_form -->
	<br />
	<form enctype="multipart/form-data" action="" method="post">
		<input name="userfile" type="file" />
		<input type="hidden" name="MAX_FILE_SIZE" value="1" />
		<input type="submit" value="{upload_form.UPLOAD_FILE}" />
	</form>
	<br /><br />
	<fieldset>
		<legend>
			{upload_form.SEND_MORE_PICTURES}
		</legend>
		<br />
			{upload_form.HOW_TO_SEND_MORE_PICTURES}
		<br /><br />
	</fieldset><br /><br />
	<a href="{upload_form.URL}">
		{upload_form.BACK}
	</a>
<!-- END upload_form -->

<!-- BEGIN form_cat -->
	<form method="post" action="">
		<br />
		{form_cat.TITRE} : <input type="text" name="titre" />
		<br /><br />
		{form_cat.DESCRIPTION} : <br /><br />
		{form_cat.FORM}
	</form>
<!-- END form_cat -->

<!-- BEGIN del -->
	<br />
	<!-- BEGIN del.txt -->
		 {del.txt.TXT}<br />
	<!-- END del.txt -->
	<!-- BEGIN del.conc -->
		<br /><br />
		{del.conc.TXT}
		<br /><br />
		<a href="{del.conc.URL}">
			{del.conc.BACK}
		</a>
	<!-- END del.conc -->	
<!-- END del -->

<!-- BEGIN picture -->
	<br />
	<center>
		<img width="150" alt="" src="{picture.SRC}" />
	</center>
	<!-- BEGIN picture.index -->
		<br /><hr /><br />
		{picture.index.TXT}
		<br /><br />
			<a href="{picture.index.URL}">
				{picture.index.INDEX}
			</a>
		<br /><hr />
	<!-- END picture.index -->
	<!-- BEGIN picture.form -->
		<br /><hr style="width:98%;" /><br />
		<form method="post" action="">
			{picture.form.DESCRIPTION}: {picture.form.FORM}
		</form>
		<hr style="width:98%;" /><br />
		<a href="{picture.form.DEL_URL}">
			{picture.form.DEL}
		</a><br /><br />
		<a href="{picture.form.BACKURL}">
			{picture.form.BACK}
		</a>
	<!-- END picture.form -->
<!-- END picture -->

<!-- BEGIN gallery -->
	{gallery.JS}
	<br />
	<center>
		<!-- BEGIN gallery.tof -->
			<a href="{gallery.tof.URL}">
				<img src="{gallery.tof.SRC}" border="0" width="{gallery.tof.WIDTH}" height="{gallery.tof.HEIGHT}" />
			</a>
		<!-- END gallery.tof -->
	</center>
	<br />
	<hr style="width:98%;"/>
	<br />

	<form method="post" action="">
			{gallery.RENAME} : <input type="text" name="new_name" value="{gallery.NAME_VALUE}"/>
								<input type="submit" value="{gallery.VALID}" />
	</form>

	<form method="post" action="">
		<br /><br /><hr style="width:98%;"/><br />
		<u>
			{gallery.RENAME_DEF_GALLERY} : 
		</u>
		<br /><br />
		{gallery.FORM}
	</form>
	<hr style="width:98%;"/>
	<br />
	<a href="{gallery.UPURL}">
		{gallery.UPLOAD_FOR_GALLERY}
	</a>
	<br /><br />
	<a href="javascript:del('{gallery.JS_MODIF}');">
		{gallery.DELETE_GALLERY}
	</a><br /><br />
	<a href="{gallery.BACKURL}">
		{gallery.BACK}
	</a>
<!-- END gallery -->