# CSV 2 VCF
CSV to VCF contacts converter



Welcome to the csv2vcf wiki!

How to use:

 * If the CSV file was exported by an Android App, no changes should be needed
 * If the CSV file was exported by other software you should modify options.php, and check the delimiters

    $options = array('mobileNumbers' => array('Phone 1 - Value','Phone 2 - Value') );

The keys of the array should not be changed, the values are the places to look for the data If the value is a string, the script will only search for one column in the csv, if the value is an array then the script will search for all the columns and keep the non-empty data.

Note: The script will return a large VCF file with all the contacts, NOT the contacts individually in more files.

Demo: http://gabisuciu.ro/csv2vcf/demo/ 

