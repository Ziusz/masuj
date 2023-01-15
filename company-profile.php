<?php
require("header.php");
$lang = DB::queryFirstRow("SELECT * FROM languages WHERE masseur_id=%i", $_SESSION['id']);
$services = DB::query("SELECT * FROM services WHERE masseur_id=%i", $_SESSION['id']);
$masseurcities = DB::query("SELECT * FROM masseurcities WHERE masseur_id=%i", $_SESSION['id']);
$cities = [];
foreach($masseurcities as $mc){
	$getcity = DB::queryFirstRow("SELECT * FROM cities WHERE id=%i", $mc['city_id']);
	$city = ['id' => $getcity['id'], 'name' => $getcity['name'], 'district' => $getcity['district'], 'city_id' => $mc['city_id']];
	$cities[] = $city;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['avatar_upload'])){
	$filename = $_FILES['avatar']['name'];
	$tempname = $_FILES['avatar']['tmp_name'];
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	$filename = uniqid(rand(), true).".".$ext;
	$folder = "assets/images/avatars/";

	$update = DB::query("UPDATE users SET avatar=%s WHERE id=%i", $filename, $_SESSION['id']);
	move_uploaded_file($tempname, $folder.$filename);
	
	header("Location: company-profile.php");
	exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['avatar_remove'])){
	$update = DB::query("UPDATE users SET avatar=%s WHERE id=%i", "default.png", $_SESSION['id']);

	header("Location: company-profile.php");
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
	$companyname = trim($_POST['companyname']);
	if(isset($_POST['masseur']) && isset($_POST['phisio']))
		$specialization = "Masażysta i Fizjoterapeuta";
	else if(isset($_POST['masseur']))
		$specialization = "Masażysta";
	else if(isset($_POST['phisio']))
		$specialization = "Fizjoterapeuta";
	else
		$specialization = "";
	$experience = trim($_POST['experience']);
	$location = trim($_POST['location']);
	$servicetype = trim($_POST['servicetype']);
	$serviceprice = trim($_POST['serviceprice']);
	if(isset($_POST['card']) && isset($_POST['cash']))
		$payment = "Karta i gotówka";
	else if(isset($_POST['card']))
		$payment = "Karta";
	else if(isset($_POST['cash']))
		$payment = "Gotówka";
	else
		$payment = "";	
	
	$polish = $english = $german = $italian = $french = $ukrainian = $russian = 0;
	if(isset($_POST['polish'])) $polish = 1;
	if(isset($_POST['english'])) $english = 1;
	if(isset($_POST['german'])) $german = 1;
	if(isset($_POST['italian'])) $italian = 1;
	if(isset($_POST['french'])) $french = 1;
	if(isset($_POST['ukrainian'])) $ukrainian = 1;
	if(isset($_POST['russian'])) $russian = 1;
	
	$no = DB::queryFirstField("SELECT COUNT(*) FROM languages WHERE masseur_id=%i", $_SESSION['id']);
	
	
	if(!empty($firstname) && !empty($lastname) && !empty($birthdate) && !empty($email) && !empty($phone) && !empty($password)){
		$no = DB::queryFirstField("SELECT COUNT(*) FROM languages WHERE masseur_id=%i", $_SESSION['id']);
		if($no == 0){
			DB::insert('languages', array(
				'masseur_id' => $_SESSION['id'],
				'polish' => $polish,
				'english' => $english,
				'german' => $german,
				'italian' => $italian,
				'french' => $french,
				'ukrainian' => $ukrainian,
				'russian' => $russian
			));
		} 
		else
			$update = DB::query("UPDATE languages SET polish=%i, english=%i, german=%i, italian=%i, french=%i, ukrainian=%i, russian=%i WHERE masseur_id=%i", $polish, $english, $german, $italian, $french, $ukrainian, $russian, $_SESSION['id']);	
		if($password != "password")
			$update = DB::query("UPDATE users SET name=%s, surname=%s, email=%s, password=%s, tel=%s, birth_date=%t, gender=%s, street=%s, city=%s, company_id=%i, specializations=%s, experience=%s, location=%s, service_type=%s, service_price=%d, payment=%s, WHERE id=%i", $firstname, $lastname, $email, $password_hash, $phone, $birthdate, $gender, $street, $city, $companyname, $specialization, $experience, $location, $servicetype, $serviceprice, $payment, $_SESSION['id']);
		else
			$update = DB::query("UPDATE users SET name=%s, surname=%s, email=%s, tel=%s, birth_date=%t, gender=%s, street=%s, city=%s, company_id=%i, specializations=%s, experience=%s, location=%s, service_type=%s, service_price=%d, payment=%s WHERE id=%i", $firstname, $lastname, $email, $phone, $birthdate, $gender, $street, $city, $companyname, $specialization, $experience, $location, $servicetype, $serviceprice, $payment, $_SESSION['id']);
		header("Location: company-profile.php");
		exit;
	} else {
		echo "Wprowadź wszystkie wymagane dane w formularzu!";
	}
}

if(isset($_GET['delete_service'])){
	$drop = DB::query("DELETE from services WHERE id=%i", $_GET['delete_service']);
	header("Location: company-profile.php");
	exit;
}

if(isset($_GET['delete_city'])){
	$drop = DB::query("DELETE from masseurcities WHERE id=%i", $_GET['delete_city']);
	header("Location: company-profile.php");
	exit;
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
                    <a href="company-profile.php" class="nav-item">Profil masażysty</a>
                </div>
                <div class="greet">
                    <p class="greet-text">Profil masażysty</p>
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
                            <span>Adres wykonywania usług (ulica)</span><br />
                            <input class="input" type="text" id="street" name="street" value="<?=$user['street']?>">
                        </label>
                        <label for="zipcode">
                            <span>Adres wykonywania usług (kod pocztowy)</span><br />
                            <input class="input" type="text" id="zipcode" name="zipcode" value="<?=$user['zip_code']?>">
                        </label>	
                        <label for="city">
                            <span>Adres wykonywania usług (miasto)</span><br />
                            <input class="input" type="text" id="city" name="city" value="<?=$user['city']?>">
                        </label>
                        <label for="cities">
                            <span>Obszar świadczenia usług</span><br />
							<div class="options" style="margin-top:8px;">
								<a href="city-add.php" class="button add-user">Dodaj</a>
							</div>						
						<div class="content-users" style="margin-top: 1rem;">	
							<div class="table-content">
								<table>
									<?php
									if($cities){
									?>
										<thead>
											<tr>
												<th>Miasto</th>
												<th>Dzielnica</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
									<?php
										foreach($cities as $c){
											echo "<tr>";
											echo "<td>".$c['name']."</td>";
											echo "<td>".$c['district']."</td>";
											echo "<td><a href='?delete_city=".$c['city_id']."' class='button delete-user' style='margin-left: 5px;'>Usuń</a>";							
											echo "</span></td>";
											echo "</tr>";
										}
									}
									?>
									</tbody>
								</table>
							</div>
						</div>	
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
						<div class="tiles">
							<p class="title">
								<i class="fas fa-cog"></i>
								Dane firmowe
							</p>
						</div>
                            <label for="company_name">
                                <span>Nazwa firmy (opcjonalne)</span><br />
                                <input class="input" type="text" id="companyname" name="companyname" value="<?=$user['company']?>">
                            </label>
							<label for "inputs">
                                <span>Specjalizacja</span>
								<div class="inputs">
									<p class="day">
										<input type="checkbox" id="test1" name="masseur" <?php if($user['specializations'] == "Masażysta" || $user['specializations'] == "Masażysta i Fizjoterapeuta" ) echo 'checked'?> style="width: 30px;">
										<label for="test1">Masażysta</label>
									</p>
									<p class="day">
										<input type="checkbox" id="test2" name="phisio" <?php if($user['specializations'] == "Fizjoterapeuta" || $user['specializations'] == "Masażysta i Fizjoterapeuta" ) echo 'checked'?> style="width: 30px;">
										<label for="test2">Fizjoterapeuta</label>
									</p>
								</div>
							</label>
                        <label for="experience">
                            <span>O mnie</span><br />
							<textarea id="experience" name="experience" maxlength="1000" rows="7" cols="50" style="padding:.5rem;font-family:RobotoLight;width:100%;margin-top:.5rem;" required><?=$user['experience']?></textarea>
                        </label>
                        <label for="location">
                            <span>Lokalizacja</span><br />
                            <input class="input" type="text" id="location" name="location" value="<?=$user['location']?>" required>
                        </label>
                        <label for="service">
                            <span>Rodzaj wykonywanych usług</span><br />
							<div class="options" style="margin-top:8px;">
								<a href="service-add.php" class="button add-user">Dodaj</a>
							</div>
						<div class="content-users" style="margin-top: 1rem;">	
							<div class="table-content">
								<table>
									<?php
									if($services){
									?>
										<thead>
											<tr>
												<th>Kategoria</th>
												<th>Nazwa</th>
												<th>Cena (PLN)</th>
												<th>Czas trwania</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
									<?php
										foreach($services as $s){
											echo "<tr>";
											echo "<td>".$s['category']."</td>";
											echo "<td>".$s['name']."</td>";
											echo "<td>".$s['price']."</td>";
											echo "<td>".$s['duration']."</td>";
											echo "<td><a href='?delete_service=".$s['id']."' class='button delete-user' style='margin-left: 5px;'>Usuń</a>";							
											echo "</span></td>";
											echo "</tr>";
										}
									}
									?>
									</tbody>
								</table>
							</div>
						</div>
                        </label>
							<label for "inputs">
                                <span>Sposób płatności</span>
								<div class="inputs">
									<p class="day">
										<input type="checkbox" id="test1" name="card" <?php if($user['payment'] == "Karta" || $user['payment'] == "Karta i gotówka" ) echo 'checked'?> style="width: 30px;">
										<label for="test1">Karta</label>
									</p>
									<p class="day">
										<input type="checkbox" id="test2" name="cash" <?php if($user['payment'] == "Gotówka" || $user['payment'] == "Karta i gotówka" ) echo 'checked'?> style="width: 30px;">
										<label for="test2">Gotówka</label>
									</p>
								</div>
							</label>
							<label for "inputs">
                                <span>Język mówiony</span>
								<div class="inputs">
									<p class="day">
										<input type="checkbox" id="test1" name="polish" <?php if($lang['polish'] == 1) echo 'checked'?> style="width: 30px;">
										<label for="test1">Polski</label>
									</p>
									<p class="day">
										<input type="checkbox" id="test2" name="english" <?php if($lang['english'] == 1) echo 'checked'?> style="width: 30px;">
										<label for="test2">Angielski</label>
									</p>
									<p class="day">
										<input type="checkbox" id="test3" name="german" <?php if($lang['german'] == 1) echo 'checked'?> style="width: 30px;">
										<label for="test3">Niemiecki</label>
									</p>
									<p class="day">
										<input type="checkbox" id="test4" name="italian" <?php if($lang['italian'] == 1) echo 'checked'?> style="width: 30px;">
										<label for="test4">Włoski</label>
									</p>
									<p class="day">
										<input type="checkbox" id="test5" name="french" <?php if($lang['french'] == 1) echo 'checked'?> style="width: 30px;">
										<label for="test5">Francuski</label>
									</p>
									<p class="day">
										<input type="checkbox" id="test6" name="ukrainian" <?php if($lang['ukrainian'] == 1) echo 'checked'?> style="width: 30px;">
										<label for="test6">Ukraiński</label>
									</p>
									<p class="day">
										<input type="checkbox" id="test7" name="russian" <?php if($lang['russian'] == 1) echo 'checked'?> style="width: 30px;">
										<label for="test7">Rosyjski</label>
									</p>									
								</div>
							</label>
                        <button type="submit" class="btn" name="data_update">Aktualizuj dane</button>						
                    </form>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form">
						<button type="submit" name="data_remove" class="btn btn-alert delete-profile">Usuń profil</button>
					</form>		
                </div>							
            </div>
        </main>
        <div class="go-up"></div>
    </div>  

    <script src="index.js"></script>  
</body>
    <script>
		var n = 1;
        function addRowLogic() {
            const table = document.querySelector('.table-add');
            const row = document.createElement('tr');
            const col = document.createElement('td');
            const col2 = document.createElement('td');
            const col3 = document.createElement('td');
            const col4 = document.createElement('td');
            const input = document.createElement('input');
            const input2 = document.createElement('input');
            const input3 = document.createElement('input');
            const input4 = document.createElement('input');

            input.type = "text";
            input.placeholder = "Fizjoterapia";
			input.name = "service["+n+"][category]";
            input.classList.add('input');
            input2.type = "text";
            input2.placeholder = "Terapia mięśnia prostego";
			input2.name = "service["+n+"][name]";
            input2.classList.add('input');
            input3.type = "text";
            input3.placeholder = "39,99";
			input3.name = "service["+n+"][price]";
            input3.classList.add('input');
            input4.type = "text";
            input4.placeholder = "60 minut";
			input4.name = "service["+n+"][duration]";
            input4.classList.add('input');

            col.appendChild(input);
            col2.appendChild(input2);
            col3.appendChild(input3);
            col4.appendChild(input4);

            row.appendChild(col);
            row.appendChild(col2);
            row.appendChild(col3);
            row.appendChild(col4);

            table.appendChild(row)
        }
        
        const addRow = document.querySelector('.add-row-btn');
        
        addRow.addEventListener('click', () => {
            addRowLogic();
            // console.log(row);
        });
    </script>
</html>