<!-- BEGIN index -->
	{index.JS}
	<br />
	<a href="./index.php?mods=news&amp;page=admin&amp;add">
		{index.ADD}
	</a>
	<br /><br />
	<a href="./index.php?mods=news&amp;page=gestion">
		{index.GESTION}
	</a>
	<br /><br />
	<fieldset>
		<legend>
			<strong>
				{index.NEWS_WAITING}
			</strong>
		</legend>
		<!-- BEGIN index.wnews -->
			<a href="index.php?mods=news&amp;page=viewnews&amp;news={index.wnews.ID}">
				{index.wnews.TITLE} : 
				<b>
					{index.wnews.TITLE_VALUE}
				</b>
			</a>
			<br />
			{index.wnews.CONTENU} : 
			<i>
				{index.wnews.CONTENU_VALUE}
			</i>...
			<br />
			<a href="./index.php?mods=news&amp;page=valide&amp;id={index.wnews.ID}">
				{index.wnews.VALID}
			</a>

			<a href="./index.php?mods=news&page=admin&amp;add&amp;modif={index.wnews.ID}">
				{index.wnews.MODIFY}
			</a>
			
			<a href="javascript:del('{index.wnews.ID}');">
				{index.wnews.REMOVE}
			</a> 
			<br/><br />
		<!-- END index.wnews -->
		<!-- BEGIN index.nwnews -->
			{index.nwnews.TXT}
		<!-- END index.nwnews -->
	</fieldset>
	<fieldset>
		<legend>
			<strong>
				{index.NEWS}
			</strong>
		</legend>
		<!-- BEGIN index.news -->
			{index.news.TITLE} : 
			<b> 
				{index.news.TITLE_VALUE}
			</b>
			<br />
				{index.news.CONTENU} : 
			<i>
				{index.news.CONTENU_VALUE}
			</i>...
			<br />
			<a href="./index.php?mods=news&page=admin&modif={index.news.ID}">
				{index.news.MODIFY}
			</a>
			<a href="javascript:del('{index.news.ID}');">
				{index.news.REMOVE}
			</a> 
			<br/><br />
		<!-- END index.news -->
	</fieldset>
	<br />
	<br />
	<a href="index.php?mods=admin">
		{index.BACK}
	</a>
<!-- END index -->

<!-- BEGIN text -->
	{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
<!-- END text -->

<!-- BEGIN form -->
	<form action="{form.ACTION}" method="post">
		{form.FORM}
		<fieldset style="width:95%;">
			<table>
				<tr>
					<td colspan="2">
						<u>{form.WHEN_PRINT}</u>
						<br /><br />
					</td>
				</tr>
				<tr>
					<td>
						<input type="radio" name="publication" value="0" checked="checked" />
					</td>
					<td>
						{form.ACTUAL_DATE}
					</td>
				</tr>
				<tr>
					<td>
						<input type="radio" name="publication" value="1" />
					</td>
					<td>
						{form.THE}
						<select name="public_day">
							<!-- BEGIN form.day -->
								<option value="{form.day.I}">
									{form.day.I}
								</option>
							<!-- END form.day -->
						</select>
						<select name="public_month">
							<!-- BEGIN form.mth -->
								<option value="{form.mth.I}">
									{form.mth.I}
								</option>
							<!-- END form.mth -->
						</select>
						<input type="text" size="1" maxlength="4" name="public_year" value="{form.YEAR_VALUE}" />
						{form.AT}
						<select name="public_hour">
							<!-- BEGIN form.hr -->
								<option value="{form.hr.I}">
									{form.hr.I}
								</option>
							<!-- END form.hr -->
						</select>
							{form.HOUR}
						<select name="public_min">
							<!-- BEGIN form.mn -->
								<option value="{form.mn.I}">
									{form.mn.I}
								</option>
							<!-- END form.mn -->
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<input type="checkbox" checked="checked" name="add_comment"/>
					</td>
					<td>	
						{form.ADD_COMMENT_AUTH}
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<br />
						{form.GROUPES_WHO_CAN_VIEW} : 
						<br /><br />
					</td>
				</tr>
				<!-- BEGIN form.gr -->
					<tr>
						<td>
							{form.gr.DESC}
						</td>
						<td>
							<input type="checkbox" {form.gr.CHECKED} name="group:{form.gr.ID}" value="1" />
						</td>
					</tr>
				<!-- END form.gr -->
				<tr>
					<td colspan="2">
						<p style="text-align:center;">
							<input type="submit" value="{form.VALID}" onclick="getContent('');" />
						</p>
					</td>
				</tr>
			</table>
		</fieldset>
	</form>
	<br /><br />
	<a href="index.php?mods=news&amp;page=admin">
		{form.BACK}
	</a>
<!-- END form -->