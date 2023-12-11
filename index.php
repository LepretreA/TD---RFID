
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GPS</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    
<div class="logForm center-form">
  <div class="logForm">
      <div class="chooseForm">
          <a id="connexion">CONNEXION</a>
          <a id="inscrire">S'INSCRIRE</a>
      </div>
      <div class="loginForm" id="loginForm">
          <form class="formBloc" method="POST" action="connexion.php">
              <label for="logemail"><i class="fas fa-envelope"></i> E-mail</label>
              <input class="logemail inputText" type="email" name="logemail">
              <label for="logpass"><i class="fas fa-lock"></i> Mot de passe</label>
              <input class="logpass inputText" type="password" name="logpass">
              <input class="submit" type="submit" name="connexion" value="SE CONNECTER">
          </form>
          <a href="#">Mot de passe oublié ?</a>
      </div>

      <div class="signinForm" id="signinForm">
          <form class="formBloc" method="POST" action="inscription.php">
              <label for="logname"><i class="fas fa-user"></i> Pseudo</label>
              <input class="logname inputText" type="text" name="logname">
              <label for="logemail"><i class="fas fa-envelope"></i> E-mail</label>
              <input class="logemail inputText" type="email" name="logemail">
              <label for="logpass"><i class="fas fa-lock"></i> Mot de passe</label>
              <input class="logpass inputText" type="password" name="logpass">
              <input class="submit" type="submit" name="inscription" value="S'INSCRIRE">
          </form>
      </div>
  </div>
</div>
<script  src="./script.js"></script>
</body>
</html>
