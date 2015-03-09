<?php

/**
 * GabiSuciu.ro
* CSV 2 VCF Converter
*
* @category   csv2vcf
* @package    csv2vcf
* @copyright  Copyright (c) 2013 GabiSuciu.ro (http://www.gabisuciu.ro)
* @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
* @version    $Id$
*/

/**
 * CSV 2 VCF Writer - Related to File Operations needed in CSV 2 VCF
* @author     Gabi <contact@gabisuciu.ro>
*/
class Csv2Vcf_FileHandler
{

	/**
	 * Write vCards to file
	 *
	 * If $dumpToString is TRUE the function will return what should be written in the file
	 * @access public
	 * @static
	 * @param string $fileName
	 * @param string|array $vcf
	 * @param bool $dumpToString
	 * @return string $newVcf
	 */
	public static function writeVcf($fileName, $vcf, $dumpToString=FALSE)
	{
		if(is_array($vcf))
			$newVcf = implode(PHP_EOL, $vcf);
		if($dumpToString)
			return $newVcf;
		file_put_contents($fileName, $newVcf);
	}
	
	/**
	 * Read CSV entries from file
	 *
	 * If $dumpToString is TRUE the function will return what should be written in the file
	 * @access public
	 * @static
	 * @param string $fileName
	 * @param string|array $vcf
	 * @param bool $dumpToString
	 * @return string $newVcf
	 */
	public static function readCsv($csv, $delimiter=",", $lineDelimiter = "\n")
	{
		$linesArray = explode($lineDelimiter, $csv);
		$firstLine = explode($delimiter, array_shift($linesArray));
		$contacts = array();
		$i=0;
		foreach($linesArray as $contact)
		{
			$exploded = explode($delimiter, $contact);
			$imploded = implode('',$exploded);
			if(!empty($imploded))
				if(!empty($exploded))
				{
					foreach($exploded as $k => $v)			
						$contacts[$i][$firstLine[$k]] = $v;
					$i++;
				}	
		}
		return $contacts;
	}
	
	
}