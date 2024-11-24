<?php

//index.php

//Include Configuration File
include('config.php');

$login_button = '';


if(isset($_GET["code"]))
{

 $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);


 if(!isset($token['error']))
 {
 
  $google_client->setAccessToken($token['access_token']);

 
  $_SESSION['access_token'] = $token['access_token'];


  $google_service = new Google_Service_Oauth2($google_client);

 
  $data = $google_service->userinfo->get();

 
  if(!empty($data['given_name']))
  {
   $_SESSION['user_first_name'] = $data['given_name'];
  }

  if(!empty($data['family_name']))
  {
   $_SESSION['user_last_name'] = $data['family_name'];
  }

  if(!empty($data['email']))
  {
   $_SESSION['user_email_address'] = $data['email'];
  }

  if(!empty($data['gender']))
  {
   $_SESSION['user_gender'] = $data['gender'];
  }

  if(!empty($data['picture']))
  {
   $_SESSION['user_image'] = $data['picture'];
  }
 }
}


if(!isset($_SESSION['access_token']))
{

 $login_button = '<a href="'.$google_client->createAuthUrl().'">Login con Google</a>';
}

?>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Login Google</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="./style.css">
 </head>
 <body>
 <div class="container">
      <div class="forms-container">
        <div class="form-control signup-form">
          <form action="#">
            <h2>Signup</h2>
            <input type="text" placeholder="Username" required />
            <input type="email" placeholder="Email" required />
            <input type="password" placeholder="Password" required />
            <input type="password" placeholder="Confirm password" required />
            <button>Signup</button>
          </form>
          <span>or signup with</span>
          <div class="socials">
            <i class="fab fa-facebook-f"></i>
            <i class="fab fa-google-plus-g"></i>
            <i class="fab fa-linkedin-in"></i>
          </div>
        </div>
        <div class="form-control signin-form">
          <form action="#">
            <h2>Inicio de sesion</h2>
            <button>

            <div class="panel panel-default">
   <?php
   $familyName = !empty($_SESSION['user_family_name']) ? $_SESSION['user_family_name'] : "" ;

//    echo "<pre>";
//    print_r($_SESSION);
   if($login_button == '')
   {
    echo '<div class="panel-heading">Welcome User</div><div class="panel-body">';
    echo '<img src="'.$_SESSION["user_image"].'" class="img-responsive img-circle img-thumbnail" />';
    echo '<h3><b>nombre: :</b> '.$_SESSION['user_first_name'].' '. $familyName .'</h3>';
    echo '<h3><b>email :</b> '.$_SESSION['user_email_address'].'</h3>';
    echo '<h3><a href="logout.php">Logout</h3></div>';
    include('connection.php');
    $nombre = $_SESSION['user_first_name'];
    $email = $_SESSION['user_email_address'];
    $getquery = "SELECT COUNT(*) FROM `usuarios` WHERE email = '$email'";
    $resultadoget = mysqli_query($conexion,$getquery);
      if($resultadoget == 0){
        $insert = "INSERT INTO `usuarios`(`id_user`, `nombre`, `email`) VALUES ('', '$nombre', '$email')";
        $resultadoInsert = mysqli_query($conexion,$insert);
      } else{
        echo '<h3><a href="gestor_tareas/index.html">Gestor</h3></div>';
      }
    }
   else
   {
    echo '<div align="center">'.$login_button . '</div>';
   }
   ?>

            </button>
          </form>
      
        </div>
      </div>
      <div class="intros-container">
        <div class="intro-control signin-intro">
          <div class="intro-control__inner">
            <h2>Inicia tu sesion!</h2>
            <p>
             Solo personal autorizado!
            </p>
           
          </div>
        </div>
      
        </div>
      </div>
    </div>
    
  </div>
 </body>
</html>