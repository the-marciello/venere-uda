<?php
    session_start();

    require "./handler/conn.php";   

    if(isset($_SESSION['user'])){
        $auth = $_SESSION['user'];
        $user = $auth;

        if (filter_var($auth, FILTER_VALIDATE_EMAIL)) {
            $query = "SELECT NomeUtente FROM UTENTE WHERE Email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $auth);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($user);
            $stmt->fetch();
        }

        $mostra = false;
        $loggato = true;

        $query = "SELECT TipoUtente FROM UTENTE WHERE NomeUtente = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($tipo);
        $stmt->fetch();

        if($tipo === 'MOD'){
            $mod = true;
        }else{
            $mod = false;
        }
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UDA Venere</title>
    <link rel="stylesheet" href="./src/plainstyle.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">



    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ephesis&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> 
</head>
<body>

    <div class="container">
        
        <header>
            <h1><a href="./index.html">VenUS</a></h1>
            <div class="button" style="display: <?= $mostra ? 'block' : 'none' ?> ">
                <a href="./login.php">Accedi</a>
                <a href="./signup.php">Registrati</a>
            </div>
            <div class="button user" style="display: <?= $loggato ? 'block' : 'none' ?> ">
                <span>Benvenuto <?= $user ?></span>
            </div>
        </header>

        <div class="spacer"></div>

        <nav style="display: <?= $loggato ? 'block' : 'none' ?> ">
            <div class="btn-container">
                <button class="btn-nav btn-dash focus">
                    <a href="./dashboard.php">
                        <i class="fa-solid fa-list-ul fa-2xl" style="background-color: transparent;"></i>
                    </a>
                </button>
                <div class="btn-else">
                    <button class="btn-nav btn-tickets">
                        <a href="./eventi_personali.php">
                            <i class="fa-solid fa-ticket fa-2xl"></i>
                        </a>
                    </button>
                    <button class="btn-nav btn-personal">
                        <a href="./area_personale.php">
                            <i class="fa-solid fa-user fa-2xl"></i>
                        </a>
                    </button>
                    <button class="btn-nav btn-users" style="display: <?= $mod ? 'block' : 'none' ?>;">
                        <a href="./gestione_utenti">
                            <i class="fa-solid fa-user-gear fa-2xl"></i>
                        </a>
                    </button>
                </div>
            </div>
        </nav>


        <div class="cards-wrapper">
            <div class="cards">

            <?php
                require "./handler/conn.php";

                $sql = "SELECT E.IDEvento, E.Titolo, E.DataEvento, E.OraEvento, E.Luogo, C.Nome as 'NomeCategoria', E.Descrizione, E.Immagine, A.Nome, A.Cognome FROM EVENTO as E, PARTECIPAZIONE as P, ARTISTA as A, CATEGORIAINTERESSE as C WHERE E.IDEvento = P.Evento AND A.IDArtista = P.Artista AND E.Categoria = C.IDCategoria ORDER BY 1";
                $result = $conn->query($sql);
                if ($result->num_rows > 0){
                    while($row = $result->fetch_assoc()):
                        $data = $row['DataEvento'];
                        $ora = $row['OraEvento'];

                        $dataFormattata = date('d/m/Y', strtotime($data));
                        $oraFormattata = date('H:i', strtotime($ora));

                        $data_ora = $dataFormattata . ", " . $oraFormattata;
                    ?>

                        <div class="card" id="<?= $row['IDEvento'] ?>">
                            <h2 class="card-title"><?= $row['Titolo'] ?></h2>
                            <div class="img-contenitore">
                                <img src="<?= $row['Immagine'] ?>" alt="immagine" class="card-image">
                            </div>
                            <div class="card-info">
                                <div class="riga">
                                    <i class="fa-solid fa-user fa-lg"></i><span><?= $row['Nome'] ?> <?= $row['Cognome'] ?></span><br>
                                </div>
                                <div class="riga">
                                    <i class="fa-solid fa-location-dot fa-lg"></i><span><?= $row['Luogo'] ?></span><br>
                                </div>
                                <div class="riga">
                                    <i class="fa-solid fa-clock fa-lg"></i><span><?= $data_ora ?></span><br>
                                </div>
                                <div class="riga">
                                    <i class="fa-solid fa-align-left fa-lg"></i><span><?= $row['Descrizione'] ?></span><br>
                                </div>
                                <br><span class="riga-categoria"><?= $row['NomeCategoria'] ?></span>
                            </div>
                        </div>

                <?php
                    endwhile;
                }
            ?>
            </div>

        <footer>

        </footer>


        <script src="./src/carosello.js"></script>
    </div> 
</body>
</html>