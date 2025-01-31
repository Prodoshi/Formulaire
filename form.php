<html>
<head>
    <title>Formulaire</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <h2>Formulaire connexion</h2>
    <form action="form.php" method="post">
        <label for="nom">Identifiant :</label>
        <input type="text" id="pseudo" name="pseudo" required><br><br>

        <label for="pwd">Mot de passe :</label>
        <input type="password" id="pwd" name="pwd" required><br><br>

        <button type="submit">Envoyer</button>
    </form>
</body>

<?php
//Test pushgay
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["pseudo"]) || !isset($_POST["pwd"])) {
        die("Veuillez renseigner vos informations");
    }

    $pseudo = trim($_POST["pseudo"]);
    $pwd = password_hash(trim($_POST["pwd"]), PASSWORD_DEFAULT);

    try {

        $pdo = new PDO('mysql:host=database:3306;dbname=Form_BD', 'root', 'tiger', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $stmt = $pdo->prepare("INSERT INTO `Ic1` (`Id_ID`, `PWD`) VALUES (:pseudo, :pwd)");
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':pwd', $pwd);

        if ($stmt->execute()) {
            echo "<h2>Bonjour, $pseudo !</h2>";
            echo "<p>Votre compte a été enregistré avec succès.</p>";
        } else {
            echo "<p>Erreur lors de l'enregistrement.</p>";
        }
    } catch (PDOException $e) {
        die("Erreur de connexion ou d'insertion : " . $e->getMessage());
    }
} 
?>
</html>