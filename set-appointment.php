<?php
require("header.php");
$cities = DB::query("SELECT DISTINCT name FROM cities ORDER by name");
$services = DB::query("SELECT DISTINCT category FROM services ORDER BY category");

if($_SERVER["REQUEST_METHOD"] == "POST"){
	/*
	if(isset($_POST['city']) && isset($_POST['servicetype']))
		$masseurs = [];
		$masseursids = DB::query("SELECT masseur_id FROM masseurcities WHERE city_id=%i", $_POST['city']);
		foreach($masseursids as $m)
			$masseurs = DB::queryFullColumns("SELECT * FROM users JOIN services ON users.id = services.masseur_id WHERE (role=%s or role=%s) and (city=%s and category=%s)", "Masażysta", "Kierownik", $_POST['city'], $_POST['servicetype']);
	*/
	if(isset($_POST['city'])){
		$masseurs = [];
		$masseurids = [];
		$city = DB::query("SELECT id FROM cities WHERE name=%s", $_POST['city']);
		foreach($city as $c){
			$mcities = DB::query("SELECT masseur_id FROM masseurcities WHERE city_id=%i", $c['id']);
			foreach($mcities as $m){
				if(!in_array($m['masseur_id'], $masseurids, true))
					$masseursids[] = $m['masseur_id'];
			}
		}
		foreach($masseursids as $m)
			$masseurs[] = DB::queryFirstRow("SELECT * FROM users WHERE id=%i", $m);
	}
	/*
	else if(isset($_POST['servicetype'])){
		$masseurs = [];
		$masseursids = DB::query("SELECT masseur_id FROM services WHERE category=%s", $_POST['category']);
		foreach($masseursids as $m)
			$masseurs = DB::queryFirstRow("SELECT * FROM users WHERE id=%i", $m['masseur_id']);
	}
	*/
}
?>
            <div class="content">
                <div class="content-nav">
                    <a href="index.php" class="nav-item">Strona główna</a>
                    <a href="set-appointment.php" class="nav-item">Umów wizytę</a>
                </div>
                <div class="greet">
                    <p class="greet-text">Umów wizytę</p>
                    <span style="width: 100%; height: 1px; margin-top: 20px; background-color: #ececec;">
                </div>
                <div class="set-appointment">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                            <div class="section">
                                <div class="header">
                                    <i class="fas fa-home"></i>
                                    <span class="location">Miasto</span>
                                </div>
                                <div class="input">
                                    <label for="location">
                                        <select type="text" id="location" name="city">
                                            <option disabled selected>Wybierz...</option>
											<?php
											foreach($cities as $c){
												echo "<option value='".$c['name']."'>".$c['name']."</option>";
											}
											?>
                                        </select>
                                    </label>
                                </div>
                            </div>
                            <div class="section">
                                <div class="header">
                                    <i class="fas fa-handshake"></i>
                                    <span class="location">Usługa</span>
                                </div>
                                <div class="input">
                                    <label for="location">
                                        <select type="text" id="location" name="servicetype">
                                            <option disabled selected>Wybierz...</option>
											<?php
											foreach($services as $s){
												echo "<option value='".$s['category']."'>".$s['category']."</option>";
											}
											?>
                                        </select>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="section">
                            <div class="header header-border">
								<!--
                                <i class="fas fa-user"></i>
                                <span class="location">Masażysta</span>
								-->
                                <div class="massage-search">
									<!--
                                    <div class="search-input">
                                        <input class="search-bar" placeholder="Szukaj masażystę..."> 
                                    </div>
									-->
                                    <input type="submit" class="button" style="border:none" name="search" value="Szukaj">
                                </div>
                            </div>
                            <div class="input input-tiles input-border">
                                <div class="tiles">
									<?php
									if(empty($masseurs))
										echo "Brak masażystów w twoim rejonie!<br />";									
									else {
										foreach($masseurs as $masseur){
											$rating = DB::queryFirstColumn("SELECT ROUND(AVG(rating), 2) FROM reservations WHERE masseur_id=%i AND rating > %i", $masseur["id"], 0);
											echo '<div class="tile">';
											echo '<div class="tile-avatar">';
											echo '<img src="assets/images/avatars/'.$masseur["avatar"].'" alt="avatar" />';
											echo '</div>';
											echo '<div class="tile-info">';
											if(!empty($masseur['company']))
												echo '<p class="name">'.$masseur["name"].' ('.$masseur["company"].')</p>';
											else
												echo '<p class="name">'.$masseur["name"].'</p>';
											echo '<p class="desc">'.$masseur["specializations"].'</p>';
											echo '<p class="desc">Średnia ocena: '.$rating[0].'/5</p>';
											echo '<a href="company-details.php?id='.$masseur["id"].'" class="select button">Wybierz</a>';
											echo '</div>';
											echo '</div>';											
										}
									}
									?>
                                </div>
                            </div>
                        </div>
						<!--
                        <div class="section">
                            <div class="header">
                                <i class="fas fa-user"></i>
                                <span class="location">Godzina spotkania</span>
                            </div>
                            <div class="input input-mobile">
                                <label for="location">
                                    <select type="text" class="input" id="location">
                                        <option disabled selected>Wybierz...</option>
                                        <option>10:00</option>
                                        <option>10:30</option>
                                        <option>11:00</option>
                                        <option>11:30</option>
                                        <option>12:00</option>
                                        <option>12:30</option>
                                        <option>13:00</option>
                                        <option>13:30</option>
                                        <option>14:00</option>
                                        <option>14:30</option>
                                        <option>15:00</option>
                                        <option>15:30</option>
                                        <option>16:00</option>
                                        <option>16:30</option>
                                        <option>17:00</option>
                                    </select>
                                </label>
                                <a href="index.html" class="button button-darker">Rezerwuj</a>
                            </div>
                        </div>
						-->
                    </form>
                </div>
            </div>
        </main>
    </div>  
</body>

</html>