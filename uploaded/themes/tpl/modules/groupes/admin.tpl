<noscript>
	<font color="red">
		{NO_JS}
	</font>
</noscript>

<!-- BEGIN text -->
	{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
<!-- END text -->

<!-- BEGIN admin -->
	{admin.JS}
	<a href="javascript:affiche_div('add_member_groupe' );">
		{admin.ADD_MEMBER}
	</a>
	<div id="add_member_groupe" style="visibility:hidden;height:0px;width:93%;" >
		<p align="center">
			<strong>
				{admin.CHOOSE_GROUP}
			</strong><br/>
			<!-- BEGIN admin.list -->
				<a href="{admin.list.URL}">
					{admin.list.NOM}
				</a><br />
			<!-- END admin.list -->
		</p>
	</div>
	<a href="javascript:affiche_div('modif_groupe');">
		{admin.MODIF}
	</a>
	<div id="modif_groupe" style="visibility:hidden;height:0px;width:93%;" >
		<p align="center">
			<strong>
				{admin.CHOOSE_GROUP}
			</strong><br/>
			<!-- BEGIN admin.list2 -->
				<a href="{admin.list2.URL}">
					{admin.list2.NOM}
				</a><br />
			<!-- END admin.list2 -->
		</p>
	</div>
	<a href="javascript:affiche_div('create_groupe');">
		{admin.CREATE}
	</a>
	<div id="create_groupe" style="visibility:hidden;height:0px;width:93%;">
		<form action="index.php?mods=groupes&amp;page=admin&amp;create" method="post">
			<p>
				{admin.NAME_OF_GROUP} : <input type="text" name="nomdugroup" />
			</p>
			<p>
				{admin.GROUP_DESC} : <p><textarea name="desc" id="create_groupetxt" style="height: 0px;"></textarea>
			</p>
			<p>
				{admin.GROUP_AFF} : <input type="radio" name="aff" value="1" checked="checked" />{admin.YES} <input type="radio" name="aff" value="0" />{admin.NO}
			</p>
			<p>
				{admin.GROUP_PUB} : <input type="radio" name="pub" value="1" checked="checked" />{admin.YES} <input type="radio" name="pub" value="0" />{admin.NO}
			</p>
			<p align="center">
				<input type="submit" value="{admin.ADD}" />
			</p>
		</form>
	</div>
	<a href="javascript:affiche_div('modif_member_group');">
		{admin.MODIF_MBR}
	</a>
	<div id="modif_member_group" style="visibility:hidden;height:0px;width:93%;">
		<p align="center">
			<strong>
				{admin.CHOOSE_GROUP}
			</strong><br/>
			<!-- BEGIN admin.list3 -->
				<a href="{admin.list3.URL}">
					{admin.list3.NOM}
				</a><br />
			<!-- END admin.list3 -->
		</p>
	</div>
	<a href="javascript:affiche_div('del_group');">
		{admin.DEL_GROUP}
	</a>
	<div id="del_group" style="visibility:hidden;height:0px;width:93%;">
		<p align="center">
			<strong>
				{admin.CHOOSE_GROUP}
			</strong><br/>
			<!-- BEGIN admin.list4 -->
				<a href="{admin.list4.URL}">
					{admin.list4.NOM}
				</a><br />
			<!-- END admin.list4 -->
		</p>
	</div>
	<a href="javascript:affiche_div('modif_color');">
		{admin.MODIF_COLOR}
	</a>
	<div id="modif_color" style="visibility:hidden;height:0px;width:93%;">
		<form action="index.php?mods=groupes&amp;page=admin&amp;color" method="post">
			<p>{admin.CHOOSE_A_LEVEL} :
				<select name="level_choose">
					<option value="0">{admin.MEMBER}</option>
					<option value="1">{admin.VIP}</option>
					<option value="2">{admin.FONDATEUR}</option>
				</select>
			</p>
			<p>{admin.CHOOSE_COLOR} :<input type="text" name="color" /> ( {admin.HTML_OR_NAME} )</p>
			<p><input type="submit" value="{admin.SEND}" /></p>
		</form>
	</div>
	<br />
	<a href="./index.php?mods=admin">
		{admin.BACK}
	</a>
<!-- END admin -->

<!-- BEGIN add -->
	<form action="index.php?mods=groupes&amp;page=admin&amp;id={add.ID}&amp;add&amp;ajout" method="post">
		<table border="0" style="width:93%">
		<!-- BEGIN add.none -->
			<tr>
				<td style="text-align: center;">
					{add.none.TXT}
				</td>
			</tr>
		<!-- END add.none -->
		<!-- BEGIN add.td1 -->
				<td>
					<input type="checkbox" name="{add.td1.PSEUDO}" value="{add.td1.ID}" /> {add.td1.PSEUDO}
				</td>
			</tr>
			<tr>
		<!-- END add.td1 -->
		<!-- BEGIN add.td2 -->
				<td>
					<input type="checkbox" name="{add.td2.PSEUDO}" value="{add.td2.ID}" /> {add.td2.PSEUDO}
				</td>
		<!-- END add.td2 -->
		<!-- BEGIN add.td3 -->
				<td>
					&nbsp;
				</td>
			</tr>
		<!-- END add.td3 -->
		<!-- BEGIN add.td4 -->
				<td colspan="2">
					&nbsp;
				</td>
			</tr>
		<!-- END add.td4 -->
		<!-- BEGIN add.td5 -->
			<tr>
				<td colspan="3">
					<br /><hr />
					<b>
						{add.td5.LETTER}
					</b><br /><hr /><br />
				</td>
			</tr>
			<tr>
				<td>
					<input type="checkbox" name="{add.td5.PSEUDO}" value="{add.td5.ID}" /> {add.td5.PSEUDO}
				</td>
		<!-- END add.td5 -->
		</table>
		<p align="center">
			<input type="submit" value="{add.ADD}" />
		</p>
	</form>
	<br /><br />
	<a href="./index.php?mods=groupes&amp;page=admin">
		{add.BACK}
	</a>
<!-- END add -->

<!-- BEGIN modif -->
	<form action="index.php?mods=groupes&amp;page=admin&amp;modif&amp;ok" method="post">
		<input type="hidden" name="idg" value="{modif.ID}" /><br/>
		<p>
			{modif.NAME_OF_GROUP} : 
			<input type="text" name="nomdugroup" value="{modif.GROUPNAME}" />
		</p>
		<p>
			{modif.GROUP_DESC} : 
		</p>
		<p>
			<textarea name="desc" rows="8" cols="15" style="width:95%;">{modif.DESC}</textarea>
		</p>
		<!-- BEGIN modif.input -->
			<p>
				{modif.input.TXT} : 
				<input type="radio" name="{modif.input.NAME}" value="{modif.input.VAL1}" {modif.input.CHECKED} />
				{modif.input.YES}
				<input type="radio" name="{modif.input.NAME}" value="{modif.input.VAL2}" {modif.input.CHECKED2} />
				{modif.input.NO}
			</p>
		<!-- END modif.input -->
		<p align="center">
			<input type="submit" value="{modif.UPDATE}" />
		</p>
<!-- END modif -->

<!-- BEGIN delgroupe -->
	{delgroupe.JS}
	{delgroupe.SURE}
	<br />
	<center>
		<input type="button" value="{delgroupe.GROUP_TO_DELETE}" onclick="del('{delgroupe.ID}');" />
	</center>
<!-- END delgroupe -->

<!-- BEGIN member_choose -->
	{member_choose.TXT} : 
	<form action="index.php?mods=groupes&amp;page=admin&amp;member&amp;ok" method="post">
		<br/>
		<table style="width:95%;">
			<!-- BEGIN member_choose.td -->
				</tr>
				<tr>
					<td>
						<input type="radio" name="id_u" value="{member_choose.td.ID}" />
					</td>
					<td>
						{member_choose.td.PSEUDO}
					</td>
				</tr>
			<!-- END member_choose.td -->
		</table>
		<p align="center">
		<input type="hidden" name="idg" value="{member_choose.ID}" />
		<input type="submit" value="{member_choose.VALID}" />
	</form>
<!-- END member_choose -->

<!-- BEGIN mod_member -->
	{mod_member.JS}
	<form action="index.php?mods=groupes&amp;page=admin&amp;member&amp;ok&amp;mo" method="post">
		{mod_member.PSEUDO} : 
			<input type="text" name="pseudo" value="{mod_member.PSEUDO_VALUE}" disabled /><br/>
		{mod_member.GROUP_LEVEL}: 
		<select name="level">
			<!-- BEGIN mod_member.titre -->
				<option value="{mod_member.titre.VALUE}" {mod_member.titre.SELECTED}>
					{mod_member.titre.NAME}
				</option>
			<!-- END mod_member.titre -->
		</select>
		<p align="center">
			<input type="hidden" name="id_u" value="{mod_member.ID}" />
			<input type="hidden" name="idgrp" value="{mod_member.ID2}" />
			<input type="submit" value="{mod_member.UPDATE}" />
			<input type="button" value="{mod_member.DEL_MEMBER_GROUP}" onclick="del('{mod_member.ID}' , '{mod_member.ID2}' );" />
		</p>
	</form>
<!-- END mod_member -->