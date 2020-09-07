<?php
include('database_connection.php');

/*Primo controllo di sicurezza, assicuriamoci che la pagina elogin sia stata richiamata da login.html tramite il metodo post e non 
direttamente da browser. Per farlo ci serviamo dell'array $_SERVER e della sua chiave request method (variabile),
che contiene proprio il metodo con la quale la pagina è stata richiamata. Se fosse stata richiamata direttamente
da browser avrebbe REQUEST_METHOD === "" */
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  
  /********** ACCESSO ADMIN ***************/
    $username = $_POST['username'];
    $psw = $_POST['password'];

	//3 comando SQL
	$comandoSQL = "	SELECT username, password
                  FROM admin
                  WHERE username = '" . $username . "' ";
  
  $RisultatoRicercaAdmin = @mysqli_query($conn, $comandoSQL);
  
  if($RisultatoRicercaAdmin){
        
        //riga = array associativo con 1 riga e tante colonne quanti gli attributi proiezione query
        $riga = mysqli_fetch_assoc($RisultatoRicercaAdmin);
        
        //operatore ternario per controllo password
        $autenticato = ($psw === $riga['password']) ? true : false;
        
        if($autenticato){
          //prima del redirect salvo l'IDADMIN nell'array associativo di sessione _SESSION
          $_SESSION['admin'] = $riga['username'];
          
          header("Location: pannello_admin.php");
        }
        
        else{ //autenticazione fallita, password sbagliata o fetch_assoc non ha trovato corrispondenza email
          echo "ID-Admin o Password errati, riprovare.";
          die;
        }
        
      }//chiude RisultatoRicercaAdmin
}

?>