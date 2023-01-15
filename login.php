<?php
require("config.php");
session_start();

$error = "";

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("Location: index.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	
	if(!empty($email) && !empty($password)){
		$user = DB::queryFirstRow("SELECT id, email, name, surname, password FROM users WHERE email=%s", $email);
		if($user){
			if(password_verify($password, $user['password'])){
				session_start();
				$_SESSION['loggedin'] = true;
				$_SESSION['id'] = $user['id'];
				
				header("Location: index.php");
			} else {
				$error = "Podane hasło jest błędne!";
			}
		} else {
			$error = "Użytkownik o takim adresie e-mail nie istnieje!";
		}
	} else {
		$error = "Wprowadź wszystkie dane w formularzu!";
	}
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta name="description" content="Free Web tutorials" />
    <meta name="keywords" content="HTML, CSS, JavaScript" />
    <meta name="author" content="John Doe" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>MasujMnie</title>

    <link rel="stylesheet" href="assets/styles/components/register/register.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
</head>
<body>
    <div class="container">
        <div class="col col-image"></div>
        <div class="col col-content">
            <p class="title">Zaloguj się</p>
			<span style="color: red"><?=$error?></span>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form">
                <label for="email">
                    <span>Adres email</span><br />
                    <input class="input" type="email" id="email" name="email" required>
                </label>
                <label for="password">
                    <span>Hasło</span><br />
                    <input class="input" type="password" id="password" name="password" required>
                </label>
                <button type="submit" class="submit-btn">Zaloguj</button>
            </form>
            <div class="desc" style="text-align: center;">
                lub <a href="register.php">utwórz nowe konto</a>
            </div>
        </div>
    </div>

    <script src="index.js"></script>
</body>
</html>