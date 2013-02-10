<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <title>expand if_ready2go_complete</title>
  </head>
  <body>
<?PHP

function do_exec($s) {
	echo '<span style="border:1px solid #cccccc">'.$s.'</span><br /><pre>';
	$output=shell_exec($s);
	echo str_replace(array('<','>'),array('&lt;','&gt;'),$output);
	echo '</pre><hr />';
}


define('TYAMLVERSION','2.0.1');

       // check for correct permissions. try to create a testfile.
do_exec('echo test > testfile');
if (!file_exists('testfile')) {
       echo 'can\'t create file in current directory<br>missing permissions?<br>';
              // show user data
       do_exec('id');
              // show rights of current directory
       do_exec('ls -la');
} else {
              // remove testfile
	do_exec('rm testfile');

// backup localconf.php
	do_exec('cp typo3conf/localconf.php typo3conf/localconf_backup.php');	
// load if_ready2go_barebone if not existent	
	if (!file_exists('tyaml_'.TYAMLVERSION.'_barebone.tgz'))
		do_exec('wget http://download.if-20.com/tyaml/tyaml_'.TYAMLVERSION.'_barebone.tgz');
// extract if_ready2go_barebone
	do_exec('tar -zxvf tyaml_'.TYAMLVERSION.'_barebone.tgz'); 
// change access-rights ...
// .. for all directories
	do_exec('find . -type d -exec chmod 775 \'{}\' \;');
// .. for all files
	do_exec('find . -type f -exec chmod 664 \'{}\' \;');
// next step will be to use install-tool: so grant access:
	do_exec('touch typo3conf/ENABLE_INSTALL_TOOL');
// show current directory content
	do_exec('ls -la');

// show links to install-tool and 1-2-3-Install
	echo '<a href="typo3/install/index.php" >Install-Tool</a><br>';
	echo '<a href="typo3/install/index.php?mode=123&step=1&password=joh316">1-2-3-Install</a>';

}
?>
  </body>
</html>