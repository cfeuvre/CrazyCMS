<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
		<head>
			<meta http-equiv="content-type" content="text/html; charset=iso-8859-15" />
			<link rel="stylesheet" type="text/css" href="./themes/crazycms1.0/style/style.css" media="screen" />
			<title>{MAINTENANCE_TITLE}</title>
		</head>
		<body>
			<br /><h2>{MAINTENANCE_TITLE}</h2><br /><br />
	<fieldset>
		<legend>
			{MAINTENANCE_NOTE_TITLE}
		</legend>
		{MAINTENANCE_NOTE}
	</fieldset>
	<br /><br />
	<fieldset>
		<legend>{CONNECTION_ADMIN_ONLY}</legend>
		<form action = "./session.php" method="post">
			<table width="75%">
				<tr>
					<td align="left">
						<strong>&raquo; {PSEUDO} : </strong><br />
					</td>
				</tr>
				<tr>
					<td>
						<input type="text" name="pseudo" /><br /><br />
					</td>
				</tr>
				<tr>
					<td align="left">
						<strong>&raquo; {PASSWORD} : </strong><br />
					</td>
				</tr>
				<tr>
					<td>
						<input type="password" name="password" /> <br /><br />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<br />
						<center>	
							<input type="hidden" name="lang" value="{LANG}" />
							<input type="hidden" name="theme" value="{THEME}" />
							<input type="submit" value="{VALID}" />
						</center>
					</td>
				</tr>
			</table>
		</form>
		</body>
	</html>