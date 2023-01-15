<?php
require("config.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$firstname = trim($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	$birthdate = trim($_POST['birthdate']);
	$email = trim($_POST['email']);
	$phone = trim($_POST['phone']);
	$password = trim($_POST['password']);
	$confirmpassword = trim($_POST['confirmpassword']);
	
	if(!empty($firstname) && !empty($lastname) && !empty($birthdate) && !empty($email) && !empty($phone) && !empty($password) && !empty($confirmpassword)){
	
		$no = DB::queryFirstField("SELECT COUNT(*) FROM users WHERE email=%s", $email);
		if($no == 0){
			if($password == $confirmpassword){
				$password_hash = password_hash($password, PASSWORD_DEFAULT);
				DB::insert('users', array(
					'name' => $firstname,
					'surname' => $lastname,
					'birth_date' => $birthdate,
					'email' => $email,
					'tel' => $phone,
					'password' => $password_hash,
					'created_at' => DB::sqleval("NOW()")
				));
				
				session_start();
				$_SESSION['loggedin'] = true;
				$_SESSION['id'] = DB::insertId();		
				
				header("Location: index.php");
				exit;
			} else {
				echo "Hasła się od siebie różnią!";
			}
		} else {
			echo "Konto z takim e-mailem jest już zarejestrowane w systemie!";
		}
	} else {
		echo "Wprowadź wszystkie dane w formularzu!";
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
            <p class="title">Zarejestruj się</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form" method="POST">
                <div class="row">
                    <label for="firstname">
                        <span>Imię</span><br />
                        <input class="input" type="text" id="firstname" name="firstname" required>
                    </label>
                    <label for="lastname">
                        <span>Nazwisko</span><br />
                        <input class="input" type="text" id="lastname" name="lastname" required>
                    </label>
                </div>
                <label for="date">
                    <span>Data urodzenia</span><br />
                    <input class="input" type="date" id="date" name="birthdate" required>
                </label>
                <label for="email">
                    <span>Adres email</span><br />
                    <input class="input" type="email" id="email" name="email" required>
                </label>
                <label for="phone">
                    <span>Numer telefonu</span><br />
                    <input class="input" type="tel" id="phone" name="phone" required>
                </label>
                <label for="password">
                    <span>Hasło</span><br />
                    <input class="input" type="password" id="password" name="password" required>
                </label>
                <label for="repeat_password">
                    <span>Powtórz hasło</span><br />
                    <input class="input" type="password" id="repeat_password" name="confirmpassword" required>
                </label>
                <label for="company-profile" class="with-checkbox">
                    <input class="input" type="checkbox" id="company-profile">
                    <span>Załóż profil firmowy</span>
                </label>
                <button type="submit" class="submit-btn">Zarejestruj konto</button>
            </form>
            <div class="desc">
                Klikając przycisk Zarejestruj się, akceptujesz nasz <a href="#">regulamin</a>. Zasady dotyczące danych informują, w jaki sposób gromadzimy, użytkujemy i udostępniamy dane użytkowników, a <a href="#">zasady dotyczące plików cookie</a> informują jak korzystamy z plików cookie i podobnych technologii.
            </div>
            <a href="login.php" class="go-back">Wróć</a>
        </div>
    </div>

    <script src="index.js"></script>
</body>
</html>