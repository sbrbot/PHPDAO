<?php

session_start();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PHP Data Access Objects Builder">
    <meta name="author" content="Stjepan Brbot">
    <meta name="version" content="5">

    <title>PHP DAO Builder</title>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Bootstrap 4 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="dao.css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

<?php

$p = isset($_REQUEST['p']) ? $_REQUEST['p'] : 0; //GET or POST

$dao=[['<i class="fa fa-home"></i>','PHP Data Access Object Builder','HOME'],
      ['Database','Database Connection','connecting'],
      ['Entities','Mapping DB tables/views to Entities','loading tables/views'],
      ['Methods','Crating methods from columns','loading columns'],
      ['Builder','Building DAO Structure','building DAO layer'],
      ['Help','Help','help'],
      ['About','About','about']];

if($p==2) //Tables
{
  if(isset($_POST['DB_HOST']))
  {
    $_SESSION['DB_HOST']=$_POST['DB_HOST'];
    $_SESSION['DB_NAME']=$_POST['DB_NAME'];
    $_SESSION['DB_PORT']=$_POST['DB_PORT'];
    $_SESSION['DB_USER']=$_POST['DB_USER'];
    $_SESSION['DB_PASS']=$_POST['DB_PASS'];
    $_SESSION['DB_CHAR']=$_POST['DB_CHAR'];
  }
  else
  {
    
  }
  //connect to DB and fetch tables/views
}
elseif($p==3) //Columns
{
  if(isset($_POST['tvs']))
  {
    $_SESSION['tvs']=$_POST['tvs'];
    $_SESSION['tvtypes']=$_POST['tvtypes'];
    $_SESSION['tvobject']=$_POST['tvobject'];
    $_SESSION['tvobjects']=$_POST['tvobjects'];
  }
  else
  {
    
  }
}
elseif($p==4) //Build
{
  if(isset($_POST['p']))
  {
    $_SESSION['getters'] = isset($_POST['getters']) ? $_POST['getters'] : []; //2D array
    $_SESSION['setters'] = isset($_POST['setters']) ? $_POST['setters'] : []; //2D array
    $_SESSION['finders'] = isset($_POST['finders']) ? $_POST['finders'] : []; //2D array
    $_SESSION['constrs'] = isset($_POST['constrs']) ? $_POST['constrs'] : []; //2D array
    $_SESSION['methods'] = isset($_POST['methods']) ? $_POST['methods'] : []; //2D array
    if(isset($_POST['backup']))
    {
      $_SESSION['backup']=$_POST['backup']; //backup
    }
    else
    {
      unset($_SESSION['backup']);
    }
  }
}
?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav" role="menu">
<?php

for($i=0;$i<count($dao);$i++)
{
  if($i==5)
  {
    echo '          </ul>'.PHP_EOL;
    echo '          <ul class="nav navbar-nav ml-auto" role="menu">'.PHP_EOL;
  }
  $active = ($p==$i) ? ' active' : '';
  echo '            <li class="nav-item'.$active.'"><a class="nav-link" role="menuitem" href="index.php?p='.$i.'">'.$dao[$i][0].'</a></li>'.PHP_EOL;
}
?>
          </ul>
        </div>
      </div><!-- container -->
    </nav>

    <div class="container">

      <h1><?= $dao[$p][1] ?></h1>

      <hr>

      <div id="ajax">
        <div class="ajax text-center">
          <i class="fa fa-cog fa-spin fa-5x fa-fw"></i>
          <br><?= $dao[$p][2] ?><br>
          <span id="counter">0</span>
        </div>
      </div>

      <script type="text/javascript">
        var c=1,counter=setInterval(function(){$("#counter").text(c++);},1000);
        $.post('dao<?= $p ?>.php','',function(data){$("#ajax").html(data);clearInterval(counter);});
      </script>

      <hr>

      <!-- Footer -->
      <footer>
        <div class="row">
          <div class="col-sm-12 text-center">
            <small>PHP DAO Builder v5 &copy; 2022</small>
          </div>
        </div>
      </footer>

    </div><!-- .container -->

  </body>

</html>
