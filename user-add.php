<?php
require("header.php");

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['data_create'])){
	$firstname = trim($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	$birthdate = trim($_POST['birthdate']);
	$email = trim($_POST['email']);
	$phone = trim($_POST['phone']);
	$password = trim($_POST['password']);
	$role = trim($_POST['role']);
	$company = NULL;
	
	if($user['role'] != "Administrator"){
		$role = "Masażysta";
		$company = $user['company_id'];
	}
	
	if(!empty($firstname) && !empty($lastname) && !empty($birthdate) && !empty($email) && !empty($phone) && !empty($password)){
	
		$no = DB::queryFirstField("SELECT COUNT(*) FROM users WHERE email=%s", $email);
			if($no == 0){
				$password_hash = password_hash($password, PASSWORD_DEFAULT);
				DB::insert('users', array(
					'name' => $firstname,
					'surname' => $lastname,
					'birth_date' => $birthdate,
					'role' => $role,
					'email' => $email,
					'company_id' => $company,
					'tel' => $phone,
					'password' => $password_hash,
					'created_at' => DB::sqleval("NOW()")
				));
				if($user['role'] == "Administrator")
					header("Location: users.php");
				else
					header("Location: company.php");
				exit;
			} else {
				echo "Konto z takim e-mailem jest już zarejestrowane w systemie!";
			}
	} else {
		echo "Wprowadź wszystkie dane w formularzu!";
	}
}
?>
            <div class="content">
                <div class="content-nav">
                    <a href="index.php" class="nav-item">Strona główna</a>
                    <a href="users.php" class="nav-item">Tworzenie użytkownika</a>
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
						<?php if($user['role'] == "Administrator"){ ?>
                        <label for="role">
                            <span>Rola</span><br />
                            <select class="input_select" id="role" name="role">
								<option value="Klient">Klient</option>
                                <option value="Masażysta">Masażysta</option>
                                <option value="Kierownik">Kierownik</option>
                                <option value="Administrator">Administrator</option>
                            </select>
                        </label>
						<?php } ?>
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
                        <button type="submit" class="btn" name="data_create">Stwórz użytkownika</button>
                    </form>
                </div>
            </div>
        </main>
        <div class="go-up"></div>
    </div>  

</body>

</html>