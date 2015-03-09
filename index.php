<?php
// env settings
date_default_timezone_set();
ini_set('display_errors',1);

// include the csv2vcf tools
include 'csv2vcf/Model.php';
include 'csv2vcf/FileHandler.php';

// include basic options
$options = array();
include 'options.php';

if(isset($_FILES['csvFile']['name']) && $_FILES['csvFile']['name']!='')
{
	// parsing delimiters
	$delimiter = (isset($_POST['delimiter']) && $_POST['delimiter']!='') ? $_POST['delimiter'] : ',';
	$delimiter = ($delimiter == '\t')	? "\t" : $delimiter;
	// line delimiter
	$lineDelimiter = (isset($_POST['lineDelimiter']) && $_POST['lineDelimiter']!='') ? $_POST['lineDelimiter']:"\n";
	$lineDelimiter  = ($lineDelimiter == '\n')	? PHP_EOL : $lineDelimiter;
	
	$ext = substr($_FILES['csvFile']['name'], -3);
	if(stripos($_FILES['csvFile']['name'], 'php') || strtolower($ext)!='csv')
	{
		echo '<pre/>';
		echo 'Error : Only CSV files are allowed';
		echo '<meta http-equiv="refresh" content="3">';
		exit('');
	}	
	
	
	// file handling 
	$name = md5(microtime(TRUE));
	$path = dirname(__FILE__);
	$inputFile = $path.'/uploads/'.$name.'.csv'; 
	$outputFile = $path.'/output/'.$name.'.vcf';
	
	move_uploaded_file($_FILES['csvFile']['tmp_name'] , $inputFile);
	$csvContent = file_get_contents($inputFile);
	
	$csv2vcf = new Csv2Vcf_Model();
	
	// delimiter errors 
	if(!$csv2vcf->isCsvValid())
	{
		echo '<pre/>';
		echo 'Error : None of the delimiters were found in your file';
		echo '<meta http-equiv="refresh" content="3">';
		exit('');
	}
	
	
	
	$contacts = Csv2Vcf_FileHandler::readCsv($csvContent, $delimiter, $lineDelimiter);
	$vcf = array();
	
	
	
	foreach($contacts as $contact)
	{
		#foreach($contact as $k => $v)
		#	$contact[$k] = trim($v,$lineDelimiter.$delimiter);
		
		$newVcf = $csv2vcf->convertArrayToVcf($contact,$options);
		$vcf[]  = $csv2vcf->generateVcf($newVcf, '2.1');
	}	
	
	Csv2Vcf_FileHandler::writeVcf($outputFile, $vcf);
	header('Content-Type: application/octet-stream');
	header('Content-Transfer-Encoding: Binary');
	header('Content-disposition: attachment; filename="contacts-export.vcf"');
	readfile($outputFile);
	exit;
}
else 
{
	$tpl = file_get_contents('template.tpl');
	$tpl = str_replace('{USER_AGENT}', $_SERVER['HTTP_USER_AGENT'] , $tpl);
	echo $tpl;
}