<?php

  define('pagencours', $_SERVER['PHP_SELF'], true);
  $site = "/site/evalEprojet.fr/Exo6/";
  $active1 = (pagencours == $site.'index.php') ? "class='active'" : '';
  $active2 = (pagencours == $site.'emprunt.php') ? "class='active'" : '';
  $active3 = (pagencours == $site.'livre.php') ? "class='active'" : '';
  

?>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li <?= $active1; ?>><a href="index.php">abonne</a></li>
            <li <?= $active2; ?>><a href="emprunt.php">emprunt</a></li>
            <li <?= $active3; ?>><a href="livre.php">livre</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>