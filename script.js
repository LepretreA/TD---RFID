// FORMULAIRE DE CONNEXION

      var login = document.getElementById("loginForm");
      var inscrire = document.getElementById("signinForm");
      document.getElementById('connexion').addEventListener("click", function(e){
        login.style.display = "block";
        inscrire.style.display = "none";
        this.style.opacity= "1";
        document.getElementById("inscrire").style.opacity= "0.5";

      });
      document.getElementById('inscrire').addEventListener("click", function(e){
        login.style.display = "none";
        inscrire.style.display = "block";
        this.style.opacity= "1";
        document.getElementById("connexion").style.opacity= "0.5";
      });

      