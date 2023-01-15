<?php
require("header.php");

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['avatar_upload'])){
	$filename = $_FILES['avatar']['name'];
	$tempname = $_FILES['avatar']['tmp_name'];
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	$filename = uniqid(rand(), true).".".$ext;
	$folder = "assets/images/avatars/";

	$update = DB::query("UPDATE users SET avatar=%s WHERE id=%i", $filename, $_SESSION['id']);
	move_uploaded_file($tempname, $folder.$filename);
	
	header("Location: settings.php");
	exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['avatar_remove'])){
	$update = DB::query("UPDATE users SET avatar=%s WHERE id=%i", "default.png", $_SESSION['id']);

	header("Location: settings.php");
	exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['data_update'])){
	$firstname = trim($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	$birthdate = trim($_POST['birthdate']);
	$gender = trim($_POST['gender']);
	$street = trim($_POST['street']);
	$city = trim($_POST['city']);
	$email = trim($_POST['email']);
	$phone = trim($_POST['phone']);
	$password = trim($_POST['password']);
	$password_hash = password_hash($password, PASSWORD_DEFAULT);
	
	if(!empty($firstname) && !empty($lastname) && !empty($birthdate) && !empty($email) && !empty($phone) && !empty($password)){
		if($password != "password"){
			$update = DB::query("UPDATE users SET name=%s, surname=%s, email=%s, password=%s, tel=%s, birth_date=%t, gender=%s, street=%s, city=%s WHERE id=%i", $firstname, $lastname, $email, $password_hash, $phone, $birthdate, $gender, $street, $city, $_SESSION['id']);
		} else {
			$update = DB::query("UPDATE users SET name=%s, surname=%s, email=%s, tel=%s, birth_date=%t, gender=%s, street=%s, city=%s WHERE id=%i", $firstname, $lastname, $email, $phone, $birthdate, $gender, $street, $city, $_SESSION['id']);
		}
		header("Location: settings.php");
		exit;
	} else {
		echo "Wprowadź wszystkie wymagane dane w formularzu!";
	}
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['data_remove'])){
	$drop = DB::query("DELETE from users WHERE id=%i", $_SESSION['id']);
	header("Location: logout.php");
	exit;
}
?>
            <div class="content">
                <div class="content-nav">
                    <a href="index.php" class="nav-item">Strona główna</a>
                    <a href="settings.php" class="nav-item">Ustawienia profilu</a>
                </div>
                <div class="greet">
                    <p class="greet-text">Ustawienia profilu</p>
                    <span style="width: 100%; height: 1px; margin-top: 20px; background-color: #ececec;">
                </div>
                <div class="tiles">
                    <p class="title">
                        <i class="fas fa-cog"></i>
                        Avatar
                    </p>
                </div>
                <div class="avatar">
                    <div class="avatar-image">
                        <img src="assets/images/avatars/<?=$user['avatar']?>" alt="avatar">
                    </div>
                    <div class="avatar-options">
						<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
							<input class="input" type="file" name="avatar">
							<button class="btn btn-sm" type="submit" name="avatar_upload">
								<i class="fas fa-camera"></i>
								Aktualizuj avatar 
							</button>
						</form>
						<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
							<button class="btn btn-sm" type="submit" name="avatar_remove" style="margin:0;">
								Usuń avatar
							</button>
						</form>
                    </div>
                </div>
                <div class="tiles">
                    <p class="title">
                        <i class="fas fa-cog"></i>
                        Dane osobowe
                    </p>
                </div>
                <div class="content-profile">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form">
                        <div class="row">
                            <label for="firstname">
                                <span>Imię</span><br />
                                <input class="input" type="text" id="firstname" name="firstname" value="<?=$user['name']?>">
                            </label>
                            <label for="lastname">
                                <span>Nazwisko</span><br />
                                <input class="input" type="text" id="lastname" name="lastname" value="<?=$user['surname']?>">
                            </label>
                        </div>
                        <label for="gender">
                            <span>Płeć</span><br />
                            <select class="input_select" id="gender" name="gender">
								<option value="Brak" <?php if($user['gender'] == "Brak") echo 'selected'?>></option>
                                <option value="Mężczyzna" <?php if($user['gender'] == "Mężczyzna") echo 'selected'?>>Mężczyzna</option>
                                <option value="Kobieta" <?php if($user['gender'] == "Kobieta") echo 'selected'?>>Kobieta</option>
                                <option value="Inna" <?php if($user['gender'] == "Inna") echo 'selected'?>>Inna</option>
                            </select>
                        </label>
                        <label for="date">
                            <span>Data urodzenia</span><br />
                            <input class="input" type="date" id="date" name="birthdate" value="<?=$user['birth_date']?>">
                        </label>
                        <label for="street">
                            <span>Adres zamieszkania (ulica)</span><br />
                            <input class="input" type="text" id="street" name="street" value="<?=$user['street']?>">
                        </label>
                        <label for="city">
                            <span>Adres zamieszkania (miasto)</span><br />
                            <input class="input" type="text" id="city" name="city" value="<?=$user['city']?>">
                        </label>							
                        <label for="email">
                            <span>Adres email</span><br />
                            <input class="input" type="email" id="email" name="email" value="<?=$user['email']?>">
                        </label>
                        <label for="phone">
                            <span>Numer telefonu</span><br />
                            <input class="input" type="tel" id="phone" name="phone" value="<?=$user['tel']?>">
                        </label>
                        <label for="password">
                            <span>Hasło</span><br />
                            <input class="input" type="password" id="password" name="password" value="password">
                        </label>
                        <button type="submit" class="btn" name="data_update">Aktualizuj dane</button>
                    </form>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form">
						<button type="submit" name="data_remove" class="btn btn-alert delete-profile">Usuń profil</button>
					</form>
                </div>
            </div>
        </main>
		<!--
        <div class="modal modal-hidden delete-acc">
            <div class="modal-info">
                <i class="fas fa-exclamation-circle alert"></i>
                <div class="content">
                    <h2 class="modal-title">Czy jesteś pewien, że chcesz usunąć profil?</h2>
                    <p class="modal-desc">Uwaga! Ta czynność jest nieodwracalna.</p>
                </div>
            </div>
            
            <div class="options">
                <a href="#" class="option-btn decline">Nie</a>
                <a href="#" class="option-btn accept">Tak</a>
            </div>
        </div>
		-->
        <div class="go-up"></div>
    </div>  

</body>

</html>