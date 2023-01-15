<?php
require("header.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$monday = $tuesday = $wednesday = $thursday = $friday = $saturday = $sunday = 0;
	if(isset($_POST['monday'])) $monday = 1;
	if(isset($_POST['tuesday'])) $tuesday = 1;
	if(isset($_POST['wednesday'])) $wednesday = 1;
	if(isset($_POST['thursday'])) $thursday = 1;
	if(isset($_POST['friday'])) $friday = 1;
	if(isset($_POST['saturday'])) $saturday = 1;
	if(isset($_POST['sunday'])) $sunday = 1;
	
	$no = DB::queryFirstField("SELECT COUNT(*) FROM availability WHERE masseur_id=%i", $_SESSION['id']);
	if($no == 0){
		DB::insert('availability', array(
			'masseur_id' => $_SESSION['id'],
			'monday' => $monday,
			'tuesday' => $tuesday,
			'wednesday' => $wednesday,
			'thursday' => $thursday,
			'friday' => $friday,
			'saturday' => $saturday,
			'sunday' => $sunday,
			'monday_start' => $_POST['monday_start'],
			'monday_stop' => $_POST['monday_stop'],
			'tuesday_start' => $_POST['tuesday_start'],
			'tuesday_stop' => $_POST['tuesday_stop'],
			'wednesday_start' => $_POST['wednesday_start'],
			'wednesday_stop' => $_POST['wednesday_stop'],
			'thursday_start' => $_POST['thursday_start'],
			'thursday_stop' => $_POST['thursday_stop'],
			'friday_start' => $_POST['friday_start'],
			'friday_stop' => $_POST['friday_stop'],
			'saturday_start' => $_POST['saturday_start'],
			'saturday_stop' => $_POST['saturday_stop'],
			'sunday_start' => $_POST['sunday_start'],
			'sunday_stop' => $_POST['sunday_stop']			
		));
		header("Location: availability.php");
		exit;
	} else {
		$update = DB::query("UPDATE availability SET monday=%i, tuesday=%i, wednesday=%i, thursday=%i, friday=%i, saturday=%i, sunday=%i, monday_start=%t, monday_stop=%t, tuesday_start=%t, tuesday_stop=%t, wednesday_start=%t, wednesday_stop=%t, thursday_start=%t, thursday_stop=%t, friday_start=%t, friday_stop=%t, saturday_start=%t, saturday_stop=%t, sunday_start=%t, sunday_stop=%t WHERE masseur_id=%i", $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday, $_POST['monday_start'], $_POST['monday_stop'], $_POST['tuesday_start'], $_POST['tuesday_stop'], $_POST['wednesday_start'], $_POST['wednesday_stop'], $_POST['thursday_start'], $_POST['thursday_stop'], $_POST['friday_start'], $_POST['friday_stop'], $_POST['saturday_start'], $_POST['saturday_stop'], $_POST['sunday_start'], $_POST['sunday_stop'], $_SESSION['id']);	
		header("Location: availability.php");
		exit;
	}
}

$masseur = DB::queryFirstRow("SELECT * FROM availability WHERE masseur_id=%i", $_SESSION['id']);
?>
            <div class="content">
                <div class="content-nav">
                    <a href="index.php" class="nav-item">Strona główna</a>
                    <a href="availability.php" class="nav-item">Dostępność</a>
                </div>
                <div class="greet">
                    <p class="greet-text">Dostępność</p>
                    <span style="width: 100%; height: 1px; margin-top: 20px; background-color: #ececec;">
                </div>
				<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
					<div class="availability">
						<div class="section">
							<i class="far fa-calendar"></i>
							<span class="title">Dostępne dni</span>
							<div class="inputs">
								<p class="day">
									<input type="checkbox" id="test1" name="monday" <?php if($masseur['monday'] == 1) echo 'checked'?>>
									<label for="test1">Poniedziałek</label>
								</p>
								<p class="day">
									<input type="checkbox" id="test2" name="tuesday" <?php if($masseur['tuesday'] == 1) echo 'checked'?>>
									<label for="test2">Wtorek</label>
								</p>
								<p class="day">
									<input type="checkbox" id="test3" name="wednesday" <?php if($masseur['wednesday'] == 1) echo 'checked'?>>
									<label for="test3">Środa</label>
								</p>
								<p class="day">
									<input type="checkbox" id="test4" name="thursday" <?php if($masseur['thursday'] == 1) echo 'checked'?>>
									<label for="test4">Czwartek</label>
								</p>
								<p class="day">
									<input type="checkbox" id="test5" name="friday" <?php if($masseur['friday'] == 1) echo 'checked'?>>
									<label for="test5">Piątek</label>
								</p>
								<p class="day">
									<input type="checkbox" id="test6" name="saturday" <?php if($masseur['saturday'] == 1) echo 'checked'?>>
									<label for="test6">Sobota</label>
								</p>
								<p class="day">
									<input type="checkbox" id="test7" name="sunday" <?php if($masseur['sunday'] == 1) echo 'checked'?>>
									<label for="test7">Niedziela</label>
								</p>
							</div>        
						</div>
						<div class="section">
							<i class="far fa-clock"></i> 
							<span class="title">Godziny pracy</span>    
							<div class="time">
								<input type="time" id="from" name="monday_start" value="<?=$masseur['monday_start']?>"> - <input type="time" id="to" name="monday_stop" value="<?=$masseur['monday_stop']?>"> Poniedziałek
							</div> 
							<div class="time">
								<input type="time" id="from" name="tuesday_start" value="<?=$masseur['tuesday_start']?>"> - <input type="time" id="to" name="tuesday_stop" value="<?=$masseur['tuesday_stop']?>"> Wtorek
							</div> 
							<div class="time">
								<input type="time" id="from" name="wednesday_start" value="<?=$masseur['wednesday_start']?>"> - <input type="time" id="to" name="wednesday_stop" value="<?=$masseur['wednesday_stop']?>"> Środa
							</div> 
							<div class="time">
								<input type="time" id="from" name="thursday_start" value="<?=$masseur['thursday_start']?>"> - <input type="time" id="to" name="thursday_stop" value="<?=$masseur['thursday_stop']?>"> Czwartek
							</div> 
							<div class="time">
								<input type="time" id="from" name="friday_start" value="<?=$masseur['friday_start']?>"> - <input type="time" id="to" name="friday_stop" value="<?=$masseur['friday_stop']?>"> Piątek
							</div> 
							<div class="time">
								<input type="time" id="from" name="saturday_start" value="<?=$masseur['saturday_start']?>"> - <input type="time" id="to" name="saturday_stop" value="<?=$masseur['saturday_stop']?>"> Sobota
							</div> 
							<div class="time">
								<input type="time" id="from" name="sunday_start" value="<?=$masseur['sunday_start']?>"> - <input type="time" id="to" name="sunday_stop" value="<?=$masseur['sunday_stop']?>"> Niedziela
							</div> 							
							<button type="submit" class="button" style="border:none">Zapisz zmiany</button>
						</div>
					</div>
				</form>
            </div>
        </main>
    </div> 
</body>

</html>