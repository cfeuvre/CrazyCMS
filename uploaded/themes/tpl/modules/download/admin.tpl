<!-- BEGIN index -->
	<br />
	<a href="index.php?mods=download&amp;page=admin&amp;add_cat">
		&raquo; {index.ADD_MAIN_CAT}
	</a>
	
	<br /><br />
	<fieldset>
		<legend>
			{index.HOWTO_ADD_SUB_AND_FILES}
		</legend>
		<br />
		{index.HOWTO_ADD_SUB_AND_FILES_TXT}
	</fieldset>
<!-- END index -->

<!-- BEGIN add_file -->
	<form method="post" action="" />
		<br />
		{add_file.TITLE} : <input type="text" value="{add_file.TITLE_VALUE}" name="title" />
		<br /><br />
		{add_file.DESCRIPTION} :
		<br /><br />
		{add_file.FORM}
		<br />
		<fieldset style="width: 95%;">
			<br />
			{add_file.MIRRORS} ( <i>{add_file.MIRRORS_HP}</i> ) :
			<textarea rows="3" name="mirrors">{add_file.MIRRORS_VALUE}</textarea>
			<br /><br />
			{add_file.PICTURES} ( <i>{add_file.PICTURES_HP}</i> ) :
			<textarea rows="3" name="pictures">{add_file.PICTURES_VALUE}</textarea>
			<br /><br />
		</fieldset>
			<br />
		<fieldset style="width: 95%;">
			<legend>
				{add_file.COMMENTS} : <input type="checkbox" name="comments" {add_file.COMM_CHECK} />
			</legend>
			<br />
			<!-- BEGIN add_file.gps -->
				<u>{add_file.gps.TXTCOM} :</u>
				<br /><br />
				<table border="0" style="width: 95%;">
					<!-- BEGIN add_file.gps.gp -->
						<tr>
							<td>
								{add_file.gps.gp.NOM}
								<!-- BEGIN add_file.gps.gp.def -->
									<br />
									<i>
										&raquo; {add_file.gps.gp.def.DEF}
									</i>
								<!-- END add_file.gps.gp.def -->
							</td>
							<td>
								<input type="checkbox" {add_file.gps.gp.CHECKED} value="1" name="gps_com_{add_file.gps.gp.ID}" />
							</td>
						</tr>
					<!-- END add_file.gps.gp -->
				</table>
			<!-- END add_file.gps -->
			<!-- BEGIN add_file.gds -->
				<br /><br />
				<u>{add_file.gds.TXTCOM} :</u>
				<br /><br />
				<table border="0" style="width: 95%;">
					<!-- BEGIN add_file.gds.gd -->
						<tr>
							<td>
								{add_file.gds.gd.NOM}
							</td>
							<td>
								<input type="checkbox" {add_file.gds.gd.CHECKED} value="1" name="gds_com_{add_file.gds.gd.ID}" />
							</td>
						</tr>
					<!-- END add_file.gds.gd -->
				</table>
			<!-- END add_file.gds -->
			<br /><br />
		</fieldset>
		<br />
		<fieldset style="width: 95%;">
			<legend>
				{add_file.OPT_OPTIONS}
			</legend>
			<br />
			{add_file.MIN_DATE} :
			<br /><br />
			<select name="min_date_day">
				<!-- BEGIN add_file.day -->
					<option value="{add_file.day.ID}" {add_file.day.SELECTED}>{add_file.day.ID}</option>
				<!-- END add_file.day -->
			</select> / 
			<select name="min_date_month">
				<!-- BEGIN add_file.mth -->
					<option value="{add_file.mth.ID}" {add_file.mth.SELECTED}>{add_file.mth.ID}</option>
				<!-- END add_file.mth -->
			</select> / 
			<select name="min_date_y">
				<!-- BEGIN add_file.year -->
					<option value="{add_file.year.ID}" {add_file.year.SELECTED}>{add_file.year.ID}</option>
				<!-- END add_file.year -->
			</select> - 
			<select name="min_date_hour">
				<!-- BEGIN add_file.hour -->
					<option value="{add_file.hour.ID}" {add_file.hour.SELECTED}>{add_file.hour.ID}</option>
				<!-- END add_file.hour -->
			</select> :
			<select name="min_date_mn">
				<!-- BEGIN add_file.mn -->
					<option value="{add_file.mn.ID}" {add_file.mn.SELECTED}>{add_file.mn.ID}</option>
				<!-- END add_file.mn -->
			</select>
			<br /><br />
			{add_file.MAX_DATE} :
			<br /><br />
			<select name="max_date_day">
				<!-- BEGIN add_file.day2 -->
					<option value="{add_file.day2.ID}" {add_file.day2.SELECTED}>{add_file.day2.ID}</option>
				<!-- END add_file.day2 -->
			</select> / 
			<select name="max_date_month">
				<!-- BEGIN add_file.mth2 -->
					<option value="{add_file.mth2.ID}" {add_file.mth2.SELECTED}>{add_file.mth2.ID}</option>
				<!-- END add_file.mth2 -->
			</select> / 
			<select name="max_date_y">
				<!-- BEGIN add_file.year2 -->
					<option value="{add_file.year2.ID}" {add_file.year2.SELECTED}>{add_file.year2.ID}</optiZon>
				<!-- END add_file.year2 -->
			</select> - 
			<select name="max_date_hour">
				<!-- BEGIN add_file.hour2 -->
					<option value="{add_file.hour2.ID}" {add_file.hour2.SELECTED}>{add_file.hour2.ID}</option>
				<!-- END add_file.hour2 -->
			</select> :
			<select name="max_date_mn">
				<!-- BEGIN add_file.mn2 -->
					<option value="{add_file.mn2.ID}" {add_file.mn2.SELECTED}>{add_file.mn2.ID}</option>
				<!-- END add_file.mn2 -->
			</select>
			<br /><br />
			{add_file.VERSION} : <input type="text" name="version" value="{add_file.VERSION_VALUE}" />
			<br /><br />
			{add_file.EDITEUR} : <input type="text" name="editeur" value="{add_file.EDITEUR_VALUE}" />
			<br /><br />
			{add_file.LICENCE} : <input type="text" name="licence" value="{add_file.LICENCE_VALUE}" />
			<br /><br />
			{add_file.SIZE} : <input type="text" name="size" value="{add_file.SIZE_VALUE}" />
			<select name="size_type">
				<option value="0" {add_file.SIZE_0} {add_file.SIZE_CHK}>Octets</option>
				<option value="1" {add_file.SIZE_1} {add_file.SIZE_CHK_1}>Kilo-Octets</option>
				<option value="2" {add_file.SIZE_2} {add_file.SIZE_CHK_2}>Mega-Octets</option>
				<option value="3" {add_file.SIZE_3} {add_file.SIZE_CHK_3}>Giga-Octets</option>
			</select>
			<br /><br />
			{add_file.SORTIE_DATE} :
			<br /><br />
			<select name="sortie_date_day">
				<!-- BEGIN add_file.day3 -->
					<option value="{add_file.day3.ID}" {add_file.day3.SELECTED}>{add_file.day3.ID}</option>
				<!-- END add_file.day3 -->
			</select> / 
			<select name="sortie_date_month">
				<!-- BEGIN add_file.mth3 -->
					<option value="{add_file.mth3.ID}" {add_file.mth3.SELECTED}>{add_file.mth3.ID}</option>
				<!-- END add_file.mth3 -->
			</select> / 
			<select name="sortie_date_y">
				<!-- BEGIN add_file.year3 -->
					<option value="{add_file.year3.ID}" {add_file.year3.SELECTED}>{add_file.year3.ID}</option>
				<!-- END add_file.year3 -->
			</select> - 
			<select name="sortie_date_hour">
				<!-- BEGIN add_file.hour3 -->
					<option value="{add_file.hour3.ID}" {add_file.hour3.SELECTED}>{add_file.hour3.ID}</option>
				<!-- END add_file.hour3 -->
			</select> :
			<select name="sortie_date_mn">
				<!-- BEGIN add_file.mn3 -->
					<option value="{add_file.mn3.ID}" {add_file.mn3.SELECTED}>{add_file.mn3.ID}</option>
				<!-- END add_file.mn3 -->
			</select>
			<br /><br />
		</fieldset>
		<br />
		<fieldset style="width: 95%;">
			<legend>
				{add_file.SECURITY}
			</legend>
			<br />
			<u> {add_file.PASSWORD} :</u>
				<input type="text" value="" name="password" />
			<!-- BEGIN add_file.gps2 -->
				<br /><br />
				<u>{add_file.gps2.TXT} :</u>
				<br /><br />
				<table border="0" style="width: 95%;">
					<!-- BEGIN add_file.gps2.gp -->
						<tr>
							<td>
								{add_file.gps2.gp.NOM}
								<!-- BEGIN add_file.gps2.gp.def -->
									<br />
									<i>
										&raquo; {add_file.gps2.gp.def.DEF}
									</i>
								<!-- END add_file.gps2.gp.def -->
							</td>
							<td>
								<input type="checkbox" {add_file.gps2.gp.CHECKED} value="1" name="gps_{add_file.gps2.gp.ID}" />
							</td>
						</tr>
					<!-- END add_file.gps2.gp -->
				</table>
			<!-- END add_file.gps2 -->
			<!-- BEGIN add_file.gds2 -->
				<br /><br />
				<u>{add_file.gds2.TXT} :</u>
				<br /><br />
				<table border="0" style="width: 95%;">
					<!-- BEGIN add_file.gds2.gd -->
						<tr>
							<td>
								{add_file.gds2.gd.NOM}
							</td>
							<td>
								<input type="checkbox" {add_file.gds2.gd.CHECKED} value="1" name="gds_{add_file.gds2.gd.ID}" />
							</td>
						</tr>
					<!-- END add_file.gds2.gd -->
				</table>
			<!-- END add_file.gds2 -->
		</fieldset>
		<p style="text-align: center;">
			<input type="submit" onclick="getContent('');" value="{add_file.VALID}" />
		</p>
	</form>
<!-- END add_file -->

<!-- BEGIN add_cat_form -->
	<form method="post" action="" />
		<br />
		{add_cat_form.TITLE} : <input type="text" value="{add_cat_form.TITLE_VALUE}" name="title" />
		<br /><br />
		{add_cat_form.DESCRIPTION} :
		<br /><br />
		{add_cat_form.FORM}
		<br />
		<fieldset>
			<legend>
				{add_cat_form.SECURITY}
			</legend>
			<br />
			<!-- BEGIN add_cat_form.sub -->
				{add_cat_form.sub.JS}
				<table border="0" style="width: 98%;">
					<tr>
						<td>
							<input type="radio" checked="checked" onclick="strateg(0);" name="strategie" value="0" />
						</td>
						<td>
							{add_cat_form.sub.HERIT}
						</td>
					</tr>
					<tr>
						<td>
							<input type="radio" onclick="strateg(1);" name="strategie" value="1" />
						</td>
						<td>
							{add_cat_form.sub.NEW}
						</td>
					</tr>
				</table><br />
				<div id="strateg" style="visibility: hidden; overflow: auto; height: 0px; width: 0px;">
			<!-- END add_cat_form.sub -->
			<u> {add_cat_form.PASSWORD} :</u>
				<input type="text" value="" name="password" />
			<!-- BEGIN add_cat_form.gps -->
				<br /><br />
				<u>{add_cat_form.gps.TXT} :</u>
				<br /><br />
				<table border="0" style="width: 95%;">
					<!-- BEGIN add_cat_form.gps.gp -->
						<tr>
							<td>
								{add_cat_form.gps.gp.NOM}
								<!-- BEGIN add_cat_form.gps.gp.def -->
									<br />
									<i>
										&raquo; {add_cat_form.gps.gp.def.DEF}
									</i>
								<!-- END add_cat_form.gps.gp.def -->
							</td>
							<td>
								<input type="checkbox" {add_cat_form.gps.gp.CHECKED} value="1" name="gps_{add_cat_form.gps.gp.ID}" />
							</td>
						</tr>
					<!-- END add_cat_form.gps.gp -->
				</table>
			<!-- END add_cat_form.gps -->
			<!-- BEGIN add_cat_form.gds -->
				<br /><br />
				<u>{add_cat_form.gds.TXT} :</u>
				<br /><br />
				<table border="0" style="width: 95%;">
					<!-- BEGIN add_cat_form.gds.gd -->
						<tr>
							<td>
								{add_cat_form.gds.gd.NOM}
							</td>
							<td>
								<input type="checkbox" {add_cat_form.gds.gd.CHECKED} value="1" name="gds_{add_cat_form.gds.gd.ID}" />
							</td>
						</tr>
					<!-- END add_cat_form.gds.gd -->
				</table>
			<!-- END add_cat_form.gds -->
			<!-- BEGIN add_cat_form.sub -->
				</div>
			<!-- END add_cat_form.sub -->
		</fieldset>
		<p style="text-align: center;">
			<input type="submit" value="{add_cat_form.VALID}" onclick="getContent('');"/>
		</p>
	</form>
<!-- END add_cat_form -->

<!-- BEGIN add_cat_valid -->
		&raquo; {add_cat_valid.TXT}
		<br /><br />
		<a href="{add_cat_valid.URL}">
			{add_cat_valid.BACK}
		</a>
<!-- END add_cat_valid -->

<!-- BEGIN edit_comment_form -->
	<br />
	<form method="post" action="">
		{edit_comment_form.FORM}
		<br /><br />
	</form>
	<a href="{edit_comment_form.URL}">
		{edit_comment_form.BACK}
	</a>
<!-- END edit_comment_form -->