<?php
require('inc/init.inc.php');
if(isset($_GET['page']) && $_GET['page'] == 'abonne') require('abonne.php');
if(isset($_GET['page']) && $_GET['page'] == 'livre') require('livre.php');
if(isset($_GET['page']) && $_GET['page'] == 'emprunt') require('emprunt.php');
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>TP Bibliotheque</title>
		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="css/style.css" rel="stylesheet" type="text/css">
		<link href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet" type="text/css">
		<script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script>  $(document).ready(function() {  $(".date").datepicker({ dateFormat: "yy/mm/dd" }).val()  });</script>
	</head>
	<body>
		<header>
			<nav class="navbar navbar-inverse navbar-fixed-top">
				  <div class="container">
					<div id="navbar" class="collapse navbar-collapse">
						<ul class="nav navbar-nav">
							<li><a href="?page=abonne">Abonné</a></li>
							<li><a href="?page=livre">Livre</a></li>
							<li><a href="?page=emprunt">Emprunt</a></li>
						</ul>
					</div>
				  </div>
			</nav>
		</header>
		<section>
			<div class="container">
				<?php echo $contenu; ?>
			</div>
		</section>
		<footer></footer>
	</body>
</html>