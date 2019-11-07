<!-- BEGIN text -->
	<br /><br />
	{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
<!-- END text -->

<!-- BEGIN gallery -->
	<!-- BEGIN gallery.pic -->
		<a href="{gallery.pic.HREF}">
			<img id="{gallery.pic.ID}" src="{gallery.pic.SRC}" border="0" alt="Error" width="{gallery.pic.WIDTH}" height="{gallery.pic.HEIGHT}" />
		</a>
	<!-- END gallery.pic -->
	<div onclick="close_pic();" id="picture"><img id="pic" src="" alt="Image Indisponible" border="1" style="border-color: #ffffff;"/></div>
	<div onclick="close_pic();" id="im_page"></div>
	{gallery.STYLE}
	{gallery.JS}
	<!-- BEGIN gallery.none -->
		<br />
		<p style="text-align: center;">
			{gallery.none.TXT}
		</p>
	<!-- END gallery.none -->
	<!-- BEGIN gallery.diap -->
		<br /><br />
		<a href="javascript:diaporama();">
			{gallery.diap.TXT}
		</a>
	<!-- END gallery.diap -->
	<br /><br />
	<a href="index.php?mods=galerie_photo">
		{gallery.BACK}
	</a>
<!-- END gallery -->

<!-- BEGIN picture -->
	<br />
	<center>
		<a href="" onclick="{picture.ONCLICK}">
			<img id="img" src="{picture.SRC}" border="0" alt="picture" width="{picture.WIDTH}" height="{picture.HEIGHT}" />
		</a>
	</center>
	<div onclick="close_pic();" id="picture"><img id="pic" src="" alt="Image Indisponible" border="1" style="border-color: #ffffff;"/></div>
	<div onclick="close_pic();" id="im_page"></div>
	{picture.JS}
	{picture.STYLE}
	<br /><br />
	<fieldset>
		<legend>
			{picture.DESCRIPTION} : 
		</legend>
		<br />{picture.DES}<br />
	</fieldset>
	<br /><br />
	<fieldset>
		<legend>
			<a href="{picture.HREF}">
				{picture.ADD_COMMENT}
			</a>
		</legend>
		<br />
		<a href="javascript:viewcomment();">
			{picture.SEE_COMMENTS}
		</a><br /><br />
		<div style="visibility:hidden;overflow:auto;" id="view_comment"></div>
	</fieldset>
		<br /><br />
	<fieldset>
		<legend>
			{picture.VOTES}
		</legend>
		<!-- BEGIN picture.nonevote -->
			<p style="text-align: center;">
				{picture.nonevote.TXT}
			</p>
		<!-- END picture.nonevote -->
		<!-- BEGIN picture.vote -->
			<p style="text-align: center;">
				<!-- BEGIN picture.vote.v -->
					<img src="{picture.vote.v.SRC}" width="20" alt="picture">
				<!-- END picture.vote.v -->
			</p>
		<!-- END picture.vote -->
		<div id="div_voter">
			<form method="post" action="">
				<select name="vote" id="vote">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				<a href="javascript:voter();">{picture.MARK}</a>	
			</form>
		</div>
	</fieldset>
	<br /><br />
	<br /><br />
	<a href="{picture.BACK_URL}">
		{picture.BACK}
	</a>
<!-- END picture -->

<!-- BEGIN index -->
	<!-- BEGIN index.none -->
		<br />{index.none.TXT}
	<!-- END index.none -->
	<!-- BEGIN index.gal -->
		<table>
			<tr>
				<td>
					<u>
						<a href="{index.gal.HREF}">
							{index.gal.NAME}
						</a>
					</u>
					<br /><br />
					<!-- BEGIN index.gal.pic -->
						<a href="{index.gal.pic.HREF}">
							<img src="{index.gal.pic.SRC}"  border="0" width="{index.gal.pic.WIDTH}" height="{index.gal.pic.HEIGHT}"/>
						</a>
					<!-- END index.gal.pic -->
				</td>
				<td>
					<!-- BEGIN index.gal.des -->
						<a href="{index.gal.des.HREF}">
							{index.gal.des.TXT}
						</a>
					<!-- END index.gal.des -->
				</td>
			</tr>
		</table>
		<br />
	<!-- END index.gal -->
<!-- END index -->
