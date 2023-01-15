<?php
require("header.php");
$name = '';

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['data_create'])){
	$name = $_POST['name'];
	if(isset($_POST['district'])){
		foreach($_POST['district'] as $k => $v){
			if($v == "on"){
				DB::insert('masseurcities', array(
					'masseur_id' => $_SESSION['id'],
					'city_id' => $k
				));
			}
		}
		header("Location: company-profile.php");
		exit;		
	}
	else if(!empty($name)){
		$cities = DB::query("SELECT * FROM cities WHERE name=%s", $name);
		if(empty($cities)){
			DB::insert('cities', array(
				'name' => $name
			));	
			DB::insert('masseurcities', array(
				'masseur_id' => $_SESSION['id'],
				'city_id' => DB::insertId()
			));	
			header("Location: company-profile.php");
			exit;			
		}
		else if(isset($_POST['fullrange'])){
			foreach($cities as $c){
				DB::insert('masseurcities', array(
					'masseur_id' => $_SESSION['id'],
					'city_id' => $c['id']
				));
			}
			header("Location: company-profile.php");
			exit;
		}
	} else {
		echo "Wprowadź wszystkie dane w formularzu!";
	}
}
?>
            <div class="content">
                <div class="content-nav">
                    <a href="index.php" class="nav-item">Strona główna</a>
                    <a href="company-profile.php" class="nav-item">Wybieranie miasta</a>
                </div>
                <div class="tiles">
                    <p class="title">
                        <i class="fas fa-cog"></i>
                        Miasto
                    </p>
                </div>
                <div class="content-profile">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form">						
						<?php
							if(!empty($name)){
								echo "Wybierz dzielnice: <br />";
								foreach($cities as $c){
									echo "<input type='checkbox' style='margin-top:.5rem' name='district[".$c['id']."]'> ".$c['district']."<br />";
								}
							} else {
								echo "<label for='name'>";
								echo "<span>Nazwa miasta</span><br />";
								echo "<input class='input' style='padding:.5rem;margin-top:.5rem;' type='text' id='name' name='name' placeholder='Warszawa' value='".$name."' required>";
								echo "</label>";
								
								echo "<br /><br /><input class='input' type='checkbox' id='fullrange' name='fullrange'>";
								echo "<label for='fullrange'> Chcę działać na terenie całego miasta</label>";
							}
						?>				
                        <br /><button type="submit" class="button" style="border:none; margin-top:1rem;" name="data_create">Dodaj miasto</button>
                    </form>
                </div>
            </div>
        </main>
        <div class="go-up"></div>
    </div>  

</body>

</html>