<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=9">
		<title>CSV 2 VCF</title>
		<meta name="keywords" content="csv, vcf, csv2vcf, csv to vcf" >
		<meta name="description" content="Convert a previously CSV-exported phonebook into a VCF file." >
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<link rel="stylesheet" type="text/css" href="css/style.css">

		<!--[if lt IE 9]>
			<script src="js/html5shim.js"></script>
		<![endif]-->
	</head>
	<body>
		<div id="wrapper">
			<header>
				<div id="header-content" class="clearfix">
					<h1><a href="#">CSV 2 VCF Converter</a></h1>
				</div>
			</header>

			<div id="content">
				<p class="intro">Use this tool to convert a previously CSV-exported phonebook into a VCF file which can be used for importing those contacts on an Android phone.</p>
				<ul class="indications clearfix">
					<li><p> Choose the csv file you want to convert then press the Convert button</p></li>
					<li><p> For default values leave the fields blank </p></li>
					<li><p> Use \n for new line and \t for tab character </p></li>
				</ul>
				<p class="notice">*Notice: The file will be automatically downloaded after pressing the button </p>

				<form action="" method="post" enctype="multipart/form-data">
					<ul class="convert_form">
						<li class="clearfix">
							<label>Delimiter</label>
							<input type="text" name="delimiter" />
						</li>
						<li class="clearfix">
							<label>Line Delimiter</label>
							<input type="text" name="lineDelimiter"/>
						</li>
						<li class="clearfix">
							<label>CSV File</label>
							<input type="file" name="csvFile" >
						</li>
						<li class="clearfix">
							<label>&nbsp;</label>
							<input class="button" type="submit" value="Convert"/>
						</li>
					</ul>
				</form>

				<br/>
				<br/>
				<br/>
				<br/>
				<p> Your user agent: {USER_AGENT}</p>
				<br/>
			</div>
			<div id="push"></div>
		</div>
		<footer>
			<div id="footer-content">
				<a href="https://github.com/gabisuciu" target="_blank">&copy; GabiDj 2015</a>
			</div>
		</footer>
	</body>
</html>