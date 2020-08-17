<?php
$this_script = $_SERVER['SCRIPT_NAME'];


$outvars .= "\t<tr>\n\t\t<td colspan=\"100%\"><h1>\$_ENV</h1></td>\n\t</tr>\n";
foreach( $_ENV as $key => $value){
	$count++;
	$linefront = "\t<tr>\n\t\t<td>$count</td>\n\t\t<td>";
	$lineend = "</td>\n\t\t<td>$value</td>\n\t</tr>\n";
	$outvars .= "$linefront\$_ENV['$key']$lineend";
}


$outvars .= "\t<tr>\n\t\t<td colspan=\"100%\"><h1>\$_SERVER</h1></td>\n\t</tr>\n";
foreach( $_SERVER as $key => $value){
	if ($key == "PHP_AUTH_PW"){
		$value = ereg_replace("[^.*]", "*", $value) . " <--- (this value displays in plaintext but has been obfusticated in this script)";
	}
	$count++;
	$linefront = "\t<tr>\n\t\t<td>$count</td>\n\t\t<td>";
	$lineend = "</td>\n\t\t<td>$value</td>\n\t</tr>\n";
	$outvars .= "$linefront\$_SERVER['$key']$lineend";
}


$outvars .= "\t<tr>\n\t\t<td colspan=\"100%\"><h1>\$_POST</h1></td>\n\t</tr>\n";
foreach( $_POST as $key => $value){
	$count++;
	$linefront = "\t<tr>\n\t\t<td>$count</td>\n\t\t<td>";
	$lineend = "</td>\n\t\t<td>$value</td>\n\t</tr>\n";
	$outvars .= "$linefront\$_POST['$key']$lineend";
}


$outvars .= "\t<tr>\n\t\t<td colspan=\"100%\"><h1>\$_GET</h1></td>\n\t</tr>\n";
foreach( $_GET as $key => $value){
	$count++;
	$linefront = "\t<tr>\n\t\t<td>$count</td>\n\t\t<td>";
	$lineend = "</td>\n\t\t<td>$value</td>\n\t</tr>\n";
	$outvars .= "$linefront\$_GET['$key']$lineend";
}


?>
<style type="text/css">
FONT,BODY {
	font-family: Verdana,sans,arial,Helvetica;
	font-size: 36px;
}
table.vars {
	border-width: 0px 0px 0px 0px;
	border-spacing: 2px;
	border-style: double double double double;
	border-color: gray gray gray gray;
	border-collapse: separate;
	background-color: white;
}
table.vars th {
	border-width: 1px 1px 1px 1px;
	padding: 3px 3px 3px 3px;
	border-style: groove groove groove groove;
	border-color: gray gray gray gray;
	background-color: white;
	-moz-border-radius: 9px 9px 9px 9px;
}
table.vars td {
	border-width: 1px 1px 1px 1px;
	padding: 5px 5px 5px 5px;
	border-style: groove groove groove groove;
	border-color: gray gray gray gray;
	background-color: white;
	-moz-border-radius: 9px 9px 9px 9px;
}
table.vars tr {
	height: 25px;
}

</style>
<form method="POST" action="<?=$this_script?>">

<table class="vars">
<a href="<?=$this_script?>"><?=$this_script?> (this script)</a><br>
<input type="submit" value="SUBMIT POST"><br>
<input type="text" name="text"><br>
<br>
<?=$outvars?>
</table>

</form>
