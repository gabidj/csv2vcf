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
 * CSV 2 VCF Converter Model
 * @author     Gabi <contact@gabisuciu.ro>
 */
class Csv2Vcf_Model
{
	
	protected $_vcfBegin = "BEGIN:VCARD \nVERSION:" ;
	protected $_vcfEnd = 'END:VCARD';
	protected $_version = '2.1';
	protected $_contacts;
	protected $_vcf;
	
	
	public function __construct()
	{
		
	}
	/**
	 * Create vCard (vCard file string) from array
	 * @access public
	 * @param string $version
	 * @param array $data
	 * @return string $vcf
	 */
	public function generateVcf($data, $version)
	{
		$vcf = '';
		switch($version)
		{
			default: case '' : 
				break;
			case '2.1':
				$vcf = $this->_vcfBegin.$version;
				// names parse
				$vcf .= PHP_EOL.'N:'.$data['lastName'].';'.$data['firstName'].';'.$data['midName'].';'.
						$data['namePrefix'].';'.$data['nameSuffix'];
				$vcf .= PHP_EOL.'FN:' . $data['namePrefix'].' '
										. $data['firstName'].' '
										. $data['midName'].' '
										. $data['lastName'].' '
										. $data['nameSuffix'].' ';
				// nickame parse
				if(!empty($data['nickname']))
				{
					$vcf .= PHP_EOL.'NICKNAME:'.$data['nickname'];
					$vcf .= PHP_EOL.'X-NICKNAME:'.$data['nickname'];
				}
				// phone numbers / fax / pager
				if(isset($data['mobileNumbers']))
					foreach($data['mobileNumbers'] as $number)
						if(!empty($number))
							$vcf .= PHP_EOL.'TEL;CELL:'.$number;		
				if(isset($data['homeNumbers']))
					foreach($data['homeNumbers'] as $number)
						if(!empty($number))
							$vcf .= PHP_EOL.'TEL;HOME;VOICE:'.$number;
				if(isset($data['workNumbers']))
					foreach($data['workNumbers'] as $number)
						if(!empty($number))
							$vcf .= PHP_EOL.'TEL;WORK;VOICE:'.$number;
				if(isset($data['pagerNumbers']))
					foreach($data['pagerNumbers'] as $number)
						if(!empty($number))
							$vcf .= PHP_EOL.'TEL;PAGER:'.$number;
				if(isset($data['workFaxNumbers']))
					foreach($data['workFaxNumbers'] as $number)
						if(!empty($number))
							$vcf .= PHP_EOL.'TEL;WORK;FAX:'.$number;
				if(isset($data['homeFaxNumbers']))
					foreach($data['homeFaxNumbers'] as $number)
						if(!empty($number))
							$vcf .= PHP_EOL.'TEL;HOME;FAX:'.$number;
				if(isset($data['customNumbers']))
					foreach($data['customNumbers'] as $number)
						if(!empty($number))
							$vcf .= PHP_EOL.'TEL;VOICE:'.$number;
				// emails
				if(isset($data['homeEmails']))
					foreach($data['homeEmails'] as $email)
						if(!empty($email))
							$vcf .= PHP_EOL.'EMAIL;HOME:'.$email;
				if(isset($data['workEmails']))
					foreach($data['workEmails'] as $email)
						if(!empty($email))
							$vcf .= PHP_EOL.'EMAIL;WORK:'.$email;
				// home postal address
				if(!empty($data['home']))
					$vcf .= PHP_EOL . 'ADR;HOME:;;' . $data['home']['street'] . ';' . $data['home']['city'] . ';' .
											 $data['home']['state'] . ';' . $data['home']['code'] . ';';
				// work postal address
				if(!empty($data['work']))
					$vcf .= PHP_EOL . 'ADR;WORK:;;' . $data['work']['street'] . ';' . $data['work']['city'] . ';' .
											 $data['work']['state'] . ';' . $data['work']['code'] . ';';
				if(isset($data['aim']))
					foreach($data['aim'] as $im)
					if(!empty($im))
						$vcf .= PHP_EOL.'X-AIM:'.$im;
				if(isset($data['yahoo']))
					foreach($data['yahoo'] as $im)
						if(!empty($im))
							$vcf .= PHP_EOL.'X-YAHOO:'.$im;
				if(isset($data['googleTalk']))
					foreach($data['googleTalk'] as $im)
						if(!empty($im))
							$vcf .= PHP_EOL.'X-GOOGLE-TALK:'.$im;
				if(isset($data['msn']))				
					foreach($data['msn'] as $im)
						if(!empty($im))
							$vcf .= PHP_EOL.'X-MSN:'.$im;
				if(isset($data['skype']))
					foreach($data['skype'] as $im)
						if(!empty($im))
							$vcf .= PHP_EOL.'X-SKYPE-USERNAME:'.$im;
				if(isset($data['qq']))
					foreach($data['qq'] as $im)
						if(!empty($im))
							$vcf .= PHP_EOL.'X-QQ:'.$im;
				if(isset($data['icq']))
					foreach($data['icq'] as $im)
						if(!empty($im))
							$vcf .= PHP_EOL.'X-ICQ:'.$im;
				if(isset($data['jabber']))
					foreach($data['jabber'] as $im)
						if(!empty($im))
							$vcf .= PHP_EOL.'X-JABBER:'.$im;
				if(isset($data['websites']))
					foreach($data['websites'] as $site)
						if(!empty($site))
							$vcf .= PHP_EOL.'URL:'.$site;
				
				if(!empty($data['orgName']))
					$vcf .= PHP_EOL.'ORG:'.$data['orgName'];
				if(!empty($data['orgPosition']))
					$vcf .= PHP_EOL.'TITLE:'.$data['orgPosition'];
				if(!empty($data['notes']))
					$vcf .= PHP_EOL.'NOTE:'.$data['notes'];
				
				$vcf .= PHP_EOL.$this->_vcfEnd;
				break;
		}
		return $vcf;
	}
	
	/**
	 * Convert the prepared array to a vCard File String (one contact only)
	 * @access public
	 * @param array $contact
	 * @param array $options
	 * @return string $vcf
	 */
	public function convertArrayToVcf($contact, $options = array())
	{
		$vcf = array();
		foreach($options as $vcfKey => $csvKey)
		{
			if(is_array($csvKey))
			{
				if(empty($csvKey))
				{
					$vcf[$vcfKey] = array();
				}
				elseif($vcfKey == 'home')
				{
					foreach($csvKey as $key => $value)
					{
						$vcf[$vcfKey][$key] = $value;
					}
				}
				else
				{
					foreach($csvKey as $key => $value)
					{
						if(isset($contact[$value]))
							$vcf[$vcfKey][] = $contact[$value];
					}
				}
			}
			else 
			{
				$vcf[$vcfKey] = (isset($contact[$csvKey]))? $contact[$csvKey] : '';
			}
		}
		return $vcf;
	}
	/**
	 * Check CSV 
	 * @param string $csvContent
	 * @param string $delimiter
	 * @param string $lineDelimiter
	 */
	public function isCsvValid($csvContent,$delimiter, $lineDelimiter)
	{
		return !(stripos($csvContent,$delimiter) == FALSE && !(stripos($csvContent, $lineDelimiter)==FALSE));
	}
}
