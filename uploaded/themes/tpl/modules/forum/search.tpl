<!-- BEGIN search_form -->
	{search_form.JS}
	<form method="post" action="">
		<table style="width:100%;">
			<tr>
				<td>
					{search_form.SEARCH_INTO}
				</td>
				<td>
					<input type="checkbox" onclick="document.getElementById(\'result\').innerHTML=\'\';" id="topic" name="search_titre" checked="true" value="1"/> {search_form.ON_THE_TITLE}<br />
					<input type="checkbox" onclick="document.getElementById(\'result\').innerHTML=\'\';" id="contenu" name="search_contenu" value="1"/> {search_form.ON_THE_CONTENT}
				</td>
			</tr>
			<tr>
				<td>
					{search_form.KEYWORDS}
				</td>
				<td>
					<input onkeyup="search_load();" onblur="reload();" style="color: grey;" onfocus="load();" type="text" size="40" id="search" name="search" value="{search_form.SEARCH}" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<center>
						<input type="submit" value="{search_form.SEARCH}" />
					</center>
				</td>
			</tr>
		</table>
	</form>
	<br /><br />
	<div id="result"></div>
<!-- END search_form -->
<!-- BEGIN search_valid -->
	<br />
		<b>
			<u>ff
				{search_valid.RESEARCH_ON_THE_TOPIC} : 
			</u>
		</b>
		<br /><br />
		<table style="width:100%;" border="1">
			<tr>
				<td>
					{search_valid.TOPICS}
				</td>
				<td>
					{search_valid.AUTHOR}
				</td>
				<td>
					{search_valid.REPLYS}
				</td>
				<td>
					{search_valid.CREATION_DATE}
				</td>
			</tr>
			<!-- BEGIN search_valid.search_valid_rep -->
				<tr>
					<td>
						<a href="{search_valid.search_valid_rep.URL}">
							{search_valid.search_valid_rep.NOM}
						</a>
					</td>
					<td>
						{search_valid.search_valid_rep.PSEUDO}
					</td>
					<td>
						{search_valid.search_valid_rep.REPLYS}
					</td>
					<td>
						{search_valid.search_valid_rep.DATE}
					</td>
				</tr>
			<!-- END search_valid.search_valid_rep -->
			<!-- BEGIN search_valid.search_valid_empty -->
				<tr>
					<td colspan="4">
						{search_valid.search_valid_empty.TXT}
					</td>
				</tr>
			<!-- END search_valid.search_valid_empty -->
		</table>
		<br /><br />
		<b>
			<u>
				{search_valid.RESEARCH_ON_THE_CONTENT} : 
			</u>
		</b>
		<br /><br />
		<table style="width:100%;" border="1">
			<tr>
				<td>
					{search_valid.TOPICS}
				</td>
				<td>
					{search_valid.TOPICS}
				</td>
				<td>
					{search_valid.CREATION_DATE}
				</td>
			</tr>
			<!-- BEGIN search_valid.search_valid_reps -->
				<tr>
					<td>
						<a href="{search_valid.search_valid_reps.URL}">
							{search_valid.search_valid_reps.NOM}
						</a>
					</td>
					<td>
						{search_valid.search_valid_reps.PSEUDO}
					</td>
					<td>
						{search_valid.search_valid_reps.DATE}
					</td>
				</tr>
			<!-- END search_valid.search_valid_reps -->
			<!-- BEGIN search_valid.search_valid_emptys -->
				<tr>
					<td colspan="3">
						{search_valid.search_valid_emptys.TXT}
					</td>
				</tr>
			<!-- END search_valid.search_valid_emptys -->
		</table>
		<br /><br />
		<a href="index.php?mods=forum&amp;page=search">
			{search_valid.BACK}
		</a>
<!-- END search_valid -->

<!-- BEGIN ajax_search -->
	<u>
		{ajax_search.TOTAL} {ajax_search.TOPICS} : 
	</u>
	<br />
	<!-- BEGIN ajax_search.reps -->
		<br />
		<a href="{ajax_search.reps.URL}">
			{ajax_search.reps.NOM}
		</a>
	<!-- END ajax_search.reps -->
<!-- END ajax_search -->