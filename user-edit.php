<?php
require("header.php");

if(isset($_GET['id'])){
	$u = DB::queryFirstRow("SELECT * FROM users WHERE id=%i", $_GET['id']);
}
else {
	header("Location: users.php");
	exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['avatar_upload'])){
	$filename = $_FILES['avatar']['name'];
	$tempname = $_FILES['avatar']['tmp_name'];
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	$filename = uniqid(rand(), true).".".$ext;
	$folder = "assets/images/avatars/";

	$update = DB::query("UPDATE users SET avatar=%s WHERE id=%i", $filename, $_POST['id']);
	move_uploaded_file($tempname, $folder.$filename);
	
	header("Location: user-edit.php?id=".$_POST['id']);
	exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['avatar_remove'])){
	$update = DB::query("UPDATE users SET avatar=%s WHERE id=%i", "default.png", $_POST['id']);

	header("Location: user-edit.php?id=".$_POST['id']);
	exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['data_update'])){
	$firstname = trim($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	$birthdate = trim($_POST['birthdate']);
	$role = trim($_POST['role']);
	$gender = trim($_POST['gender']);
	$street = trim($_POST['street']);
	$city = trim($_POST['city']);
	$email = trim($_POST['email']);
	$phone = trim($_POST['phone']);
	$password = trim($_POST['password']);
	$password_hash = password_hash($password, PASSWORD_DEFAULT);
	
	if($user['role'] != "Administrator"){
		$role = "Masażysta";
	}
	
	if(!empty($firstname) && !empty($lastname) && !empty($birthdate) && !empty($email) && !empty($phone) && !empty($password)){
		if($password != "password"){
			$update = DB::query("UPDATE users SET name=%s, surname=%s, email=%s, role=%s, password=%s, tel=%s, birth_date=%t, gender=%s, street=%s, city=%s WHERE id=%i", $firstname, $lastname, $email, $role, $password_hash, $phone, $birthdate, $gender, $street, $city, $_POST['id']);
		} else {
			$update = DB::query("UPDATE users SET name=%s, surname=%s, email=%s, role=%s, tel=%s, birth_date=%t, gender=%s, street=%s, city=%s WHERE id=%i", $firstname, $lastname, $email, $role, $phone, $birthdate, $gender, $street, $city, $_POST['id']);
		}
		header("Location: user-edit.php?id=".$_POST['id']);
		exit;
	} else {
		echo "Wprowadź wszystkie wymagane dane w formularzu!";
	}
}
?>
            <div class="content">
                <div class="content-nav">
                    <a href="index.php" class="nav-item">Strona główna</a>
                    <a href="users.php" class="nav-item">Edytowanie użytkownika</a>
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
                        <img src="assets/images/avatars/<?=$u['avatar']?>" alt="avatar">
                    </div>
                    <div class="avatar-options">
						<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$_GET['id']; ?>" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?=$_GET['id']?>">
							<input class="input" type="file" name="avatar">
							<button class="btn btn-sm" type="submit" name="avatar_upload">
								<i class="fas fa-camera"></i>
								Aktualizuj avatar 
							</button>
						</form>
						<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$_GET['id']; ?>">
							<input type="hidden" name="id" value="<?=$_GET['id']?>">
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
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$_GET['id']; ?>" method="POST" class="form">
                        <div class="row">
                            <label for="firstname">
                                <span>Imię</span><br />
                                <input class="input" type="text" id="firstname" name="firstname" value="<?=$u['name']?>">
                            </label>
                            <label for="lastname">
                                <span>Nazwisko</span><br />
                                <input class="input" type="text" id="lastname" name="lastname" value="<?=$u['surname']?>">
                            </label>
                        </div>
                        <label for="gender">
                            <span>Płeć</span><br />
                            <select class="input_select" id="gender" name="gender">
								<option value="Brak" <?php if($u['gender'] == "Brak") echo 'selected'?>></option>
                                <option value="Mężczyzna" <?php if($u['gender'] == "Mężczyzna") echo 'selected'?>>Mężczyzna</option>
                                <option value="Kobieta" <?php if($u['gender'] == "Kobieta") echo 'selected'?>>Kobieta</option>
                                <option value="Inna" <?php if($u['gender'] == "Inna") echo 'selected'?>>Inna</option>
                            </select>
                        </label>
                        <label for="date">
                            <span>Data urodzenia</span><br />
                            <input class="input" type="date" id="date" name="birthdate" value="<?=$u['birth_date']?>">
                        </label>
						<?php if($user['role'] == "Administrator"){ ?>
                        <label for="role">
                            <span>Rola</span><br />
                            <select class="input_select" id="role" name="role">
								<option value="Klient" <?php if($u['role'] == "Klient") echo 'selected'?>>Klient</option>
                                <option value="Masażysta" <?php if($u['role'] == "Masażysta") echo 'selected'?>>Masażysta</option>
                                <option value="Kierownik" <?php if($u['role'] == "Kierownik") echo 'selected'?>>Kierownik</option>
                                <option value="Administrator" <?php if($u['role'] == "Administrator") echo 'selected'?>>Administrator</option>
                            </select>
                        </label>
						<?php } ?>						
                        <label for="street">
                            <span>Adres zamieszkania (ulica)</span><br />
                            <input class="input" type="text" id="street" name="street" value="<?=$u['street']?>">
                        </label>
                        <label for="city">
                            <span>Adres zamieszkania (miasto)</span><br />
                            <input class="input" type="text" id="city" name="city" value="<?=$u['city']?>">
                        </label>							
                        <label for="email">
                            <span>Adres email</span><br />
                            <input class="input" type="email" id="email" name="email" value="<?=$u['email']?>">
                        </label>
                        <label for="phone">
                            <span>Numer telefonu</span><br />
                            <input class="input" type="tel" id="phone" name="phone" value="<?=$u['tel']?>">
                        </label>
                        <label for="password">
                            <span>Hasło</span><br />
                            <input class="input" type="password" id="password" name="password" value="password">
                        </label>
						<input type="hidden" name="id" value="<?=$_GET['id']?>">
                        <button type="submit" class="btn" name="data_update">Aktualizuj dane</button>
                    </form>
                </div>
            </div>
        </main>
        <div class="go-up"></div>
    </div>  

</body>

</html>