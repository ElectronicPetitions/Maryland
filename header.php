  <?PHP include_once('/var/www/secure.php'); //outside webserver ?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<div class="container"><!--- Open Container -->
  
<ul class="nav nav-pills">
  <li role='presentation' <?PHP if($_SERVER['REQUEST_URI'] == 'intro.php'){ echo "class='active'"; } ?> ><a href="intro.php">Intro</a></li>
</ul>
