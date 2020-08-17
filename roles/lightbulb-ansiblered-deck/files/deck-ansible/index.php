<?php

// I updated this here to be a variable so we can easily change it in other places in the deck, dynamically

$module_count="2800+";
$gihub_stars="37,500+";
$download_permonth="500,000+";

$dry_run = (isset($_GET['dryrun']) ? 1 : 0);

/* LAB LIMITs
	0 = No Restrictions		/deck-ansible/
	1 = Only Labs			/deck-ansible/?labs/
	2 = No Labs, only deck	/deck-ansible/?nolabs/
*/

$lab_limit = (isset($_GET['labs']) ? 1 : 0);
$lab_limit = (isset($_GET['nolabs']) ? 2 : $lab_limit);

//if (! isset($_GET['force'])) $lab_limit = 2;

if (isset($_GET['force'])) print "LAB LIMIT ";
if ((isset($_GET['force'])) and ($lab_limit == 0)) print "0 = Deck + Labs /deck-ansible/";
if ((isset($_GET['force'])) and ($lab_limit == 1)) print "1 = Only Labs /deck-ansible/?labs/";
if ((isset($_GET['force'])) and ($lab_limit == 2)) print "2 = No Labs, only deck /deck-ansible/?nolabs/";

//$lab_limit\n";
/*
	We dynamically detect our currrent directory and use it for
	all of our include paths since they must be absolute
*/

$myfile = preg_replace("/^.*\//","",$_SERVER['PHP_SELF']);
$mydir = preg_replace("/$myfile/","",$_SERVER['SCRIPT_FILENAME']);
$servervar = $_SERVER['HTTP_HOST'];

// If we pass a parameter for person, use that.  Otherwise, use subdomain.
$person = (isset($_GET['person']) ? addslashes($_GET['person']) : preg_replace("/^(.*?)\.(.*)$/","$1",$_SERVER['HTTP_HOST']));

// If we can't find a prefs file for the person, use the default
$custom_prefs_file = "prefs/" . $person . ".prefs.php";
$standard_prefs_file = "prefs/default.prefs.php";

/*
	Default or customized titles for the first slide.
	The default.prefs.php file here is a template and
	is built dynamically via the Ansible playbook.
*/

$prefs_file = (file_exists($custom_prefs_file) ? $custom_prefs_file : $standard_prefs_file);
require_once($prefs_file);

if (! $dry_run){
	require_once("page_first.html");
}else{
	?>
<pre>
RUNNING IN DRY RUN with LAB LIMIT SET TO <?=$lab_limit?>

 0 = No Restrictions		/deck-ansible/
 1 = Only Labs			/deck-ansible/?labs/
 2 = No Labs, only deck		/deck-ansible/?nolabs/

######################################################
	<?php
}

/*	We build an array of each directory*/
$html_dir = $mydir . "html_slides";
$html_topics = explode("\n",shell_exec("find $html_dir -maxdepth 1 -type d  | sort"));

/*	We scan each dir and include each HTML slides from the diretory*/

foreach( $html_topics as $key => $htmldir){
	$pretty_htmldir = preg_replace("/^.*\/html_slides/","",$htmldir);
	$pretty_htmldir = preg_replace("/^.*\//","",$pretty_htmldir);
	$pretty_htmldir = preg_replace("/^[0-9]+_+/","",$pretty_htmldir);
	$pretty_htmldir = preg_replace("/^[0-9]+_+/","",$pretty_htmldir);
	$pretty_htmldir = preg_replace("/_+/"," ",$pretty_htmldir);

	$html_files = explode("\n",shell_exec("find $htmldir -maxdepth 1 -type f -iname \"*html\" | sort"));
	$html_files = array_filter($html_files);

	if (($pretty_htmldir) and (count($html_files))){
		if ($dry_run) print "\n#$key \"$pretty_htmldir\" contains " . count($html_files) . " slides\n\n";
		$labid = "LABS-" . preg_replace("/[^0-9a-zA-Z]+/","", $pretty_htmldir);

		foreach( $html_files as $key => $htmlinc){
			if (($dry_run) and ($lab_limit != 1)) print "INCLUDE $htmlinc\n";
			$localdir = str_replace($html_dir . '/',"",$htmlinc);
			$localfile = preg_replace("/^.*\//","",$htmlinc);

			if ((! $dry_run) and ($lab_limit != 1 )) {
				if ( (file_exists($htmlinc)) and (!preg_match("/^_/",$localdir)) and (!preg_match("/^_/",$localfile)) ) include($htmlinc);
			}

		}

		if ($lab_limit != 2){
			$lab_files = explode("\n",shell_exec("find $htmldir/labs -maxdepth 1 -type f -iname \"*html\" | sort"));
			$lab_files = array_filter($lab_files);

			if (count($lab_files)){
				if ($dry_run){
					print "\nSTART-LAB-INCLUDE for \"$pretty_htmldir\"\n\n";
				}else{
					?>
	<section>
		<section data-state="lab alt" id="<?=$labid?>-Start">
			<h1>LABS:<br><?=$pretty_htmldir?></h1>
			<p>Click down arrow to continune into the labs</p>

		</section>
					<?php
				}


				foreach( $lab_files as $key => $labinc){
					if ($dry_run){
						print "INCLUDE-LABS $labinc\n";
					}else{
						$labdir = str_replace($html_dir . '/',"",$labinc);
						$labfile = preg_replace("/^.*\//","",$labinc);

						if ( (file_exists($labinc)) and (!preg_match("/^_/",$labdir)) and (!preg_match("/^_/",$labfile)) ) include($labinc);

	//					print " $labinc\n";
					}
				}

				if ($dry_run){
					print "\nEND-LAB-INCLUDE for \"$pretty_htmldir\"\n";
				}else{
					?>
		<section data-state="lab alt" id="<?=$labid?>-Finish">
			<h1>LABS:<br><?=$pretty_htmldir?> Complete!</h1>
			<p>Click right to continune</p>
		</section>

	</section>
					<?php
				}
			}
		}
	}
}

if ($dry_run) print "</pre>\n";
if (! $dry_run) require_once("page_final.html");

?>

