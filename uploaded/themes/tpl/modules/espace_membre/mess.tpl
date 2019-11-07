<!-- BEGIN index -->
	{index.JS}
	<fieldset>
		<legend>
			<strong>
				{index.SEND_MP}
			</strong>
		</legend>
		<form method="post" action="">
			<table width="95%">
				<tr>
					<!-- BEGIN index.to -->
						<td> 
							{index.to.MEMBERLIST} :
						</td>
						<td>
							<select name="destinataire" id="destin" onchange="upd_field();">
								<!-- BEGIN index.to.user -->
									<option value="{index.to.user.PSEUDO}">
										{index.to.user.PSEUDO}
									</option>
								<!-- END index.to.user -->
							</select>
						</td>
					<!-- END index.to -->
				</tr>
					<td>
						{index.DESTINATAIRE} :
					</td>
					<td>
						<input type="text" id="dest" name="destinataire" value="{index.TO_VALUE}"/>( {index.U_CAN_SEND_MULTY} )
					</td>
				</tr>
				<tr>
					<td>
						{index.AUTHOR} :
					</td>
					<td>
						<input name="pseudo" value="{index.PSEUDO}" disabled>
					</td>
				</tr>
				<tr>
					<td>
						{index.TOPIC} :
					</td>
					<td>
						<input name="sujet" value="{index.TOPIC}">
					</td>
				</tr>
				<tr>
					<td>
						{index.CONTENT} :
					</td>
					<td>
						{index.FORM}
					</td>
				</tr>
			</table>
			<center>
				<input type="submit" value="{index.VALID}">
				<input type="hidden" name="envoyer"  value="envoyer">
			</center
		</form>
	</fieldset>
<!-- END index -->

<!-- BEGIN valid -->
	<fieldset>
		<legend>
			{valid.CONFIRMATION}
		</legend>
		<br /><br />
		<center>
				{valid.MESSAGE_SENDED}
		</center>
		<br /><br />
	</fieldset>
<!-- END valid -->