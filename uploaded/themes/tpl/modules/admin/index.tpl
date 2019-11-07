<!-- BEGIN index -->	
	<center>
		<!-- BEGIN index.main -->
			
			<fieldset>
				<legend>
					<strong>
						{index.ADM_OPTIONS}
					</strong>
				</legend>
				<table border="0" style="text-align: center;">
					<tr align="center">
						<td style="width:20%;">
							&nbsp;&nbsp;{index.main.USERS}<br /><br />&nbsp;&nbsp;
							<a title="{index.main.USERS}" href="./index.php?mods=admin&amp;page=user">
								<img src="./themes/tpl/img/admin/users.png" border="0" alt="{index.main.USERS}" />
							</a>
						</td>
						<td style="width:20%;">
							&nbsp;&nbsp;{index.main.GEN}<br /><br />&nbsp;&nbsp;
							<a title="{index.main.GEN}" href="./index.php?mods=admin&amp;page=gen">
								<img src="./themes/tpl/img/admin/gen.png" border="0" alt="{index.main.GEN}" />
							</a>
						</td> 
						<td style="width:20%;">
							&nbsp;&nbsp;{index.main.ADMIN_INTERFACE}<br /><br />&nbsp;&nbsp;
							<a title="{index.main.ADMIN_INTERFACE}" href="./index.php?mods=admin&amp;page=interface">
								<img src="./themes/tpl/img/admin/interface.png" border="0" alt="{index.main.ADMIN_INTERFACE}"/>
							</a>
						</td> 
						<td style="width:20%;">
							&nbsp;&nbsp;{index.main.GRADES}<br /><br />&nbsp;&nbsp;
							<a title="{index.main.GRADES}" href="./index.php?mods=admin&amp;page=grade">
								<img src="./themes/tpl/img/admin/grade.png" border="0" alt="{index.main.GRADES}"/>
							</a>
						</td>
						<td style="width:20%;">
							&nbsp;&nbsp;{index.main.SEE_ADMIN_MOD}<br /><br />&nbsp;&nbsp;
							<a title="{index.main.SEE_ADMIN_MOD}" href="./index.php?mods=admin&amp;page=admin_mod">
								<img src="./themes/tpl/img/admin/permissions.png" border="0" alt="{index.main.PERMS}"  />
							</a>
						</td>
					</tr>
					<tr>
						<td style="width:20%;">
							&nbsp;&nbsp;{index.main.GESTION_ALERTE}<br /><br />&nbsp;&nbsp;
							<a title="{index.main.GESTION_ALERTE}" href="./index.php?mods=admin&amp;page=galerte">
								<img src="./themes/tpl/img/admin/alerte.png" border="0" alt="{index.main.GESTION_ALERTE}"/>
							</a>
						</td>		
						<td style="width:20%;">
							&nbsp;&nbsp;{index.main.MODS}<br /><br />&nbsp;&nbsp;
							<a title="{index.main.MODS}" href="./index.php?mods=admin&amp;page=modules">
								<img src="./themes/tpl/img/admin/modules.png" border="0" alt="{index.main.MODS}"/>
							</a>
						</td>
						<td style="width:20%;">
							&nbsp;&nbsp;{index.main.CACHE}<br /><br />&nbsp;&nbsp;
							<a title="{index.main.CACHE}" href="./index.php?mods=admin&amp;page=cache">
								<img src="./themes/tpl/img/admin/cache.png" border="0" alt="{index.main.CACHE}"/>
							</a>
						</td>
						<td style="width:20%;">
							&nbsp;&nbsp;{index.main.LOGS}<br /><br />&nbsp;&nbsp;
							<a title="{index.main.LOGS}" href="./index.php?mods=admin&amp;page=log">
								<img src="./themes/tpl/img/admin/log.png" border="0" alt="{index.main.LOGS}" />
							</a>
						</td>
						<td style="width:20%;">
							&nbsp;&nbsp;{index.main.DATE}<br /><br />&nbsp;&nbsp;
							<a title="{index.main.DATE}" href="./index.php?mods=admin&amp;page=date">
								<img src="./themes/tpl/img/admin/date.png" border="0" alt="{index.main.DATE}" />
							</a>
						</td>
					</tr>
					<tr>
					
					<!-- BEGIN index.main.cat -->
						<!-- BEGIN index.main.cat.sep -->
							</tr><tr>
						<!-- END index.main.cat.sep -->
						<td style="text-align: center;">
							<a title="{index.main.cat.FILE}" href="./index.php?mods={index.main.cat.FILE}&amp;page=admin">
								{index.main.cat.NOM}
								<br /><br />
								<img src="./themes/tpl/img/{index.main.cat.FILE}/admin.png" border="0" alt="..." />
							</a>
						</td>
					<!-- END index.main.cat -->
					
					</tr>
					<tr>
						<td colspan="5">
							<!-- BEGIN index.main.sql -->
								&nbsp;&nbsp;{index.main.sql.SQL}<br /><br />&nbsp;&nbsp;
								<a title="{index.main.sql.SQL}" href="./index.php?mods=admin&amp;page=sql">
									<img src="./themes/tpl/img/admin/sql.png" border="0" alt="{index.main.sql.SQL}" />
								</a>
							<!-- END index.main.sql -->
						</td>
					</tr>
				</table>
			</fieldset>
			<br />
			<hr width="50%">	</hr>
			<br />
		<!-- END index.main -->
		<fieldset>
			<legend>
				<strong>
					{index.MODS_ADM}
				</strong>
			</legend>
			<table width="95%" style="text-align:center;">
				<tr>
					<!-- BEGIN index.cat -->
						<!-- BEGIN index.cat.sep -->
							</tr><tr>
						<!-- END index.cat.sep -->
						<td style="text-align: center;">
							<a title="{index.cat.FILE}" href="./index.php?mods={index.cat.FILE}&amp;page=admin">
								{index.cat.NOM}
								<br /><br />
								<img src="{index.cat.IMG_URL}" width="{index.cat.WIDTH}" height="{index.cat.HEIGHT}" border="0" alt="..." />
							</a>
						</td>
					<!-- END index.cat -->
				</tr>
			</table>
		</fieldset>
	</center>
<!-- END index -->