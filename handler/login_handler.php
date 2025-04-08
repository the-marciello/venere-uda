<?php
    session_start();
    
    require "conn.php";

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $mail_user = htmlentities(trim($_POST["mail_user"]));
        $password = $_POST["pw"];

        $hashed_pw = password_hash($password, PASSWORD_DEFAULT);

        if(filter_var($mail_user, FILTER_VALIDATE_EMAIL)){
            $query = "SELECT * FROM UTENTE WHERE EMAIL = ?";
        }else{
            $query = "SELECT * FROM UTENTE WHERE NOMEUTENTE = ?";
        }

        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $mail_user);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result===false){
            $_SESSION['error'] = "Errore nell'elaborazione della query di ricerca per l'autenticazione";
            header("Location: ../login.php");
        }
        else{
            if($result->num_rows===1){
                $user = $result->fetch_assoc();
                if(password_verify($hashed_pw, $user['PASSWORD'])){
                    $_SESSION['user']=$mail_user;

                    //TODO: header dashboard
                }
            }
            else{
                $_SESSION['error'] = "Credenziali errate";
                header("Location: ../login.php");
            }
        }
    }

?>