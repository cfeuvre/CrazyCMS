<!-- BEGIN text -->
	<br /><br />
	{text.TXT}
	<br /><br />
	<a href="{text.URL}">
		{text.BACK}
	</a>
	<br /><br /><hr />
<!-- END text -->

<!-- BEGIN index -->
	{index.JS}
	<noscript>
		<br />
		<center>
			<font color="red">
				{index.NO_JS}
			</font>
		</center>
		<br />
	</noscript>
	<table style="width:98%;">
		<tr>
			<td style="width:25%;valign:top; ">
				<a href="javascript:addbloc();">
					{index.ADD_BLOC}
				</a>
				<br />
				<div id="all_blocs">
					<!-- BEGIN index.bloc -->
						<br />
						<fieldset>
							<legend>{index.bloc.TITLE}</legend>
							<!-- BEGIN index.bloc.int -->
								<a href="javascript:{index.bloc.int.TYPE}('{index.bloc.int.ID}','{index.bloc.int.TYPE2}','{index.bloc.int.POSITION}','left');">
									<img src="{index.bloc.int.SRC}" border="0" alt="{index.bloc.int.ALT}" />
								</a>
							<!-- END index.bloc.int -->
							<!-- BEGIN index.bloc.hide -->
								<a href="javascript:cacher('{index.bloc.hide.ID}','{index.bloc.hide.TYPE}');">
									<img src="{index.bloc.hide.SRC}" border="0" alt="{index.bloc.hide.ALT}" />
								</a>
							<!-- END index.bloc.hide -->
							<!-- BEGIN index.bloc.del -->
								<a href="javascript:del( '{index.bloc.del.ID}' );">
									<img src="./themes/tpl2.0/img/admin/del.gif" border="0" alt="{index.bloc.del.ALT}" />
								</a>
							<!-- END index.bloc.del -->
							<!-- BEGIN index.bloc.col -->
								<a href="javascript:col('{index.bloc.col.ID}','left');">
									<img src="./themes/tpl/img/admin/right.gif" border="0" alt=">" />
								</a>
							<!-- END index.bloc.col -->
						</fieldset>
					<!-- END index.bloc -->
				</div>
				<br />
			</td>
			<td style="width:75%;valign:top; ">
				<br /> 
				<fieldset>
					<legend>
						{index.ACTUAL_MOD} : 
						<b>
							{index.MOD}
						</b>
					</legend>
					<br />
					<a href="javascript:changemod();">{index.ADMIN_MOD_ACC}</a><br /><br />
					<div id="moddem" style="visibility:hidden;height:0px;overflow:auto;margin-left:30px;">
						<u>
							{index.LISTEMOD} : 
						</u>
						<br /><br />
						<!-- BEGIN index.mods -->
							<a href="{index.mods.URL}">
								&raquo; {index.mods.NAME}
							</a>
							<br />
						<!-- END index.mods -->
						<br />
						<u>
							{index.FREEPAGES_CREATED} :
						</u>
						<br /><br />
						<!-- BEGIN index.freem -->
							<a href="{index.freem.URL}">
								&raquo; {index.freem.NAME}
							</a>
							<br />
						<!-- END index.freem -->
						<br />
						<u>
							{index.PAGES_CREATED} :
						</u>
						<br /><br />
						<!-- BEGIN index.pagem -->
							<a href="{index.pagem.URL}">
								&raquo; {index.pagem.NAME}
							</a>
							<br />
						<!-- END index.pagem -->
					</div>
				</fieldset>
				<br />
				<fieldset>
					<legend>
						<a href="javascript:addbloc();">
							{index.ADD_BLOC}
						</a>
					</legend>
					<br />
					<div id="ttblok" style="visibility:hidden;height:0px;overflow:auto;text-align:left; ">
						<u>
							{index.BLOC_LIST} :
						</u>
						<br /><br />
						<!-- BEGIN index.blocs -->
							<a href="{index.blocs.URL}">
								&raquo; {index.blocs.NAME}
							</a>
							<br />
						<!-- END index.blocs -->
						<br />
						<u>
							{index.BLOCS_MANUAL} :
						</u>
						<br /><br />
						<!-- BEGIN index.blocm -->
							<a href="{index.blocm.URL}">
								&raquo; {index.blocm.NAME}
							</a>
							<br />
						<!-- END index.blocm -->
					</div>
				</fieldset>
			</td>
			<td style="width:25%;valign:top; ">
				<div id="all_blocs">
					<!-- BEGIN index.bloc2 -->
						<br />
						<fieldset>
							<legend>{index.bloc2.TITLE}</legend>
							<!-- BEGIN index.bloc2.int -->
								<a href="javascript:{index.bloc2.int.TYPE}('{index.bloc2.int.ID}','{index.bloc2.int.TYPE2}','{index.bloc2.int.POSITION}','right');">
									<img src="{index.bloc2.int.SRC}" border="0" alt="{index.bloc2.int.ALT}" />
								</a>
							<!-- END index.bloc2.int -->
							<!-- BEGIN index.bloc2.hide -->
								<a href="javascript:cacher('{index.bloc2.hide.ID}','{index.bloc2.hide.TYPE}');">
									<img src="{index.bloc2.hide.SRC}" border="0" alt="{index.bloc2.hide.ALT}" />
								</a>
							<!-- END index.bloc2.hide -->
							<!-- BEGIN index.bloc2.del -->
								<a href="javascript:del( '{index.bloc2.del.ID}' );">
									<img src="./themes/tpl2.0/img/admin/del.gif" border="0" alt="{index.bloc2.del.ALT}" />
								</a>
							<!-- END index.bloc2.del -->
							<!-- BEGIN index.bloc2.col -->
								<a href="javascript:col('{index.bloc2.col.ID}','right');">
									<img src="./themes/tpl/img/admin/left.gif" border="0" alt="<" />
								</a>
							<!-- END index.bloc2.col -->
						</fieldset>
					<!-- END index.bloc2 -->
				</div>
			</td>
		</tr>
	</table>
	<br />
	<br />
	<a href="index.php?mods=admin">
		{index.BACK}
	</a>
<!-- END index -->