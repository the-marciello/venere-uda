<?php
    session_start();

    if(isset($_SESSION['success'])){
        echo "<p>" . $_SESSION['success'] . " Accedi!";
        unset($_SESSION['success']);
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UDA Venere</title>
    <link rel="stylesheet" href="./src/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Style+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
    <body>
        <h1>LOGIN</h1>
        <p>Accedi per godere di tutti i servizi</p>
        <div>
            <form action="handler/login_handler.php" method="POST">
                <label for="mail_user">inserire username o email</label>
                <input type="text" name="mail_user" placeholder="..." required>
                <br>
                <label for="password">inserire la password</label>
                <input type="password" name="pw" placeholder="..." required>

                <button type="submit">ACCEDI</button>
            </form>
        <div>

        <?php
            if(isset($_SESSION['error'])){
                ?>
                <p><?= $_SESSION['error'] ?></p>
                <?php
                unset($_SESSION['error']);
            }
        ?>
            
        <script src="./src/main.js"></script>
        <script src="./src/stars.js"></script>
    </body>
</html>