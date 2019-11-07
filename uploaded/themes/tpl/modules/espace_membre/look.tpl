<!-- BEGIN text -->
	<fieldset>
		<legend>
			<strong>
				{text.DEL_MESS}
			</strong>
		</legend>
		<!-- BEGIN text.line -->
			 {text.line.MESS} {text.line.NOM} {text.line.DELETED}
			 <br />
		<!-- END text.line -->
		<p>
			{text.DELETED}
		</p>
		<p>
			<a href="index.php?mods=espace_membre&amp;page=look">
				{text.BACK}
			</a>
		</p>
	</fieldset>
<!-- END text -->

<!-- BEGIN index -->
	<fieldset>
		<legend>
			<strong>
				<font color="#c00000">
					{index.SEEN_YOUR_MESSAGES}
				</font>
			</strong>
		</legend>
		<br />
		<form method="post" action="">
			<table border cellspacing="0" cellpadding="5" width="95%" align="center">
				<tr>
					<td align="center">
						<strong>
							{index.STATUT}
						</strong>
					</td>
					<td align="center">
						<strong>
							{index.TITLE}
						</strong>
					</td>
					<td align="center">
						<strong>
							{index.SHIPPER}
						</strong>
					</td>
					<td>
						<strong>
							{index.DELET}
						</strong>
					</td>
				</tr>
				<!-- BEGIN index.mp -->
					<tr>
						<td align="center">
							<font color="{index.mp.COLOR}">
								{index.mp.STATUT}
							</font>
						</td>
						<td>
							<a href="index.php?mods=espace_membre&amp;page=look&amp;action=voir&amp;id={index.mp.ID}#mp">
								- {index.mp.TITRE}
							</a>
						</td>
						<td align="center">
							<strong>
								{index.mp.PSEUDO}
							</strong>
						</td>
						<td align="center">
							<input type="checkbox" name="mess:{index.mp.ID}" value="1" />
						</td>
					</tr>
				<!-- END index.mp -->
				<tr>
					<td align="right" colspan="4">
						<input type="submit" value="{index.DELET}" />
						<input type="hidden" name="sup"  value="supprimer" />
					</td>
				</tr>
			</table>
		</form>
	</fieldset>
<!-- END index -->

<!-- BEGIN none -->
	<fieldset>
		<legend>
			<strong>
				{none.MP}
			</strong>
		</legend>
		<p style="text-decoration: underline;text-align: center;">
			<strong>
				{none.NONE_MP}
			</strong>
		</p>
	</fieldset>
<!-- END none -->

<!-- BEGIN mp -->
	<fieldset>
		<legend>
			<strong>
				{mp.MP}
			</strong>
		</legend>
		<h2>
			<center>
				<p style="text-decoration: underline;" id="mp">
					<strong>
						{mp.TITRE}
					</strong>
				</p>
			</center>
		</h2>
		<h5>
			{mp.ENVOY_BY}
			<strong>
				<a href="index.php?mods=espace_membre&amp;page=profil&amp;id={mp.AUTEUR}">
					{mp.PSEUDO}
				</a>
			</strong> 
			{mp.THE} {mp.DATE}
		</h5> 
		<br />
		<ul>
			{mp.CONTENU}
		</ul>
		<br /><br />
		<center>
			<a href="index.php?mods=espace_membre&amp;page=look&amp;action=rep&amp;id={mp.ID}">
				{mp.ANSWER}
			</a>&nbsp;&nbsp;-&nbsp;&nbsp;
			<a href="index.php?mods=espace_membre&amp;page=look">
				{mp.BACK}
			</a>
		&nbsp;&nbsp;-&nbsp;&nbsp;
			<a href="javascript:window.print()">
				{mp.TO_PRINT_THIS_MESS}
			</a>
		</center>
<!-- END mp -->

<!-- BEGIN answer -->
	<fieldset>
		<legend>
			<strong>
				{answer.ANSWER_MP}
			</strong>
		</legend>
		<form method="post" action="index.php?mods=espace_membre&amp;page=look&amp;action=rep">
			<table width="95%">
				<tr>
					<td>
						{answer.RECIPIENT} : 
					</td>
					<td>
						<input name="des" value="{answer.PSEUDO}" />
					</td>
				</tr>
				<tr>
					<td>
						{answer.AUTHOR} :
					</td>
					<td>
						<input name"auteur" value="{answer.PPSEUDO}" disabled>
					</td>
				</tr>
				<tr>
					<td>
						{answer.TOPIC} :
					</td>
					<td>
						<input name="sujet" value="RE:{answer.TITRE}">
					</td>
				</tr>
				<tr>
					<td>
						{answer.CONTENT} :
					</td>
					<td>
						{answer.FORM}
					</td>
				</tr>
			</table>
			<center>
				<input type="submit" value="{answer.ANSWER}">
				<input type="hidden" name="repondre"  value="repondre">
			</center>
		</form>
	</fieldset>
<!-- END answer -->