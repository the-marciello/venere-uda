<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UDA Venere</title>
    <link rel="stylesheet" href="./src/plainstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">



    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ephesis&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> 
</head>
<body>

    <div class="container">
        
        <header>
            <h1><a href="./index.html">VenUS</a></h1>
            <div class="button">
                <a href="./login.php">Accedi</a>
                <a href="./signup.php">Registrati</a>
            </div>
        </header>
        <div class="spacer"></div>

        <div class="cards-wrapper">
            <div class="cards">

            <?php
                require "./handler/conn.php";

                $sql = "SELECT E.Titolo, E.DataEvento, E.OraEvento, E.Luogo, C.Nome as 'NomeCategoria', E.Descrizione, E.Immagine, A.Nome, A.Cognome FROM EVENTO as E, PARTECIPAZIONE as P, ARTISTA as A, CATEGORIAINTERESSE as C WHERE E.IDEvento = P.Evento AND A.IDArtista = P.Artista AND E.Categoria = C.IDCategoria";
                $result = $conn->query($sql);
                if ($result->num_rows > 0){
                    while($row = $result->fetch_assoc()):
                        $data = $row['DataEvento'];
                        $ora = $row['OraEvento'];

                        $dataFormattata = date('d/m/Y', strtotime($data));
                        $oraFormattata = date('H:i', strtotime($ora));

                        $data_ora = $dataFormattata . ", " . $oraFormattata;
                    ?>

                        <div class="card">
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

        <style>
            body {
    margin: 0;
    overflow-x: visible;
  }
  
  .container {
    max-width: 100vw;
    overflow-x: visible;
  }
  
  /* Wrapper per le card con scrolling orizzontale */
  .cards-wrapper {
    margin-top: 1rem;
    max-width: 100%;
    overflow-x: auto;
    padding: 1rem;
    box-sizing: border-box;
    scroll-behavior: smooth;
  }

  .cards {
    display: flex;
    flex-wrap: nowrap;
    gap: 2rem;
    width: max-content;
    margin: 0;
  }

  .card {
    flex-shrink: 0;
    background: #e0e0e0;
    border-radius: 30px;
    padding: 1.5rem;
    width: 360px;
    max-width: 90vw;
    font-family: 'Segoe UI', sans-serif;
    color: #333;
  }

  .card-image {
    width: 100%;
    border-radius: 15px;
    object-fit: cover;
    margin-bottom: 1rem;
  }

  .card-info {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
  }
  
  .card-title {
    color: #bf2a57;
    font-size: 1.4rem;
    font-weight: 800;
    text-transform: uppercase;
    margin-bottom: 1rem;
  }
        </style>

        <script src="./src/carosello.js"></script>
    </div> 
</body>
</html>