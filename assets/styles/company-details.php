<?php
require("header.php");

if(!isset($_GET['id']) && $_SERVER["REQUEST_METHOD"] != "POST"){
	header("Location: set-appointment.php");
	exit;
}

$masseur = DB::queryFirstRow("SELECT * FROM users WHERE id=%i", $_GET['id']);
$work = DB::queryFirstRow("SELECT * FROM availability WHERE masseur_id=%i", $_GET['id']);
$services = DB::query("SELECT * FROM services WHERE masseur_id=%i", $_GET['id']);
$rating = DB::queryFirstColumn("SELECT ROUND(AVG(rating), 2) FROM reservations WHERE masseur_id=%i AND rating > %i", $_GET['id'], 0);
?>
            <div class="content">
                <div class="content-nav">
                    <a href="index.php" class="nav-item">Strona główna</a>
                    <a href="company-details.php" class="nav-item">Umów wizytę</a>
                </div>
                <div class="greet">
                    <p class="greet-text">Umów wizytę</p>
                    <span style="width: 100%; height: 1px; margin-top: 20px; background-color: #ececec;">
                </div>
                <div class="content-profile">
                    <div class="card">
                        <img src="assets/images/avatars/<?=$masseur["avatar"]?>" alt="avatar" />
                        <div class="info">
							<div class="label">
								<div class="name"><?=$masseur["name"]?> (<?=$masseur["company"]?>)</div>
								<div class="desc"><?=$masseur["specializations"]?></div>
								<div class="desc"><?=$masseur["location"]?></div>
							</div>
                            <div class="label-row">
								<div class="label">
									<?php
									if($services){
										foreach($services as $s){
											echo "<div class='desc'>".$s["name"]." (".$s["price"]." PLN)</div>";
										}
									}
									?>
									<div class="desc">Sposób płatności: <?=$masseur["payment"]?></div>
									<div class="desc">Język: <?=$masseur["language"]?></div>
									<div class="desc">Średnia ocena: <?=$rating[0]?>/5</div>
								</div>
								<div class="label">
									<div class="desc">Dostępny w dniach:<br />
									<?php
										if($work['monday']) echo "poniedziałek (".date('G:i', strtotime($work['monday_start']))." - ".date('G:i', strtotime($work['monday_stop'])).")<br />";
										if($work['tuesday']) echo "wtorek (".date('G:i', strtotime($work['tuesday_start']))." - ".date('G:i', strtotime($work['tuesday_stop'])).")<br />";
										if($work['wednesday']) echo "środa (".date('G:i', strtotime($work['wednesday_start']))." - ".date('G:i', strtotime($work['wednesday_stop'])).")<br />";
										if($work['thursday']) echo "czwartek (".date('G:i', strtotime($work['thursday_start']))." - ".date('G:i', strtotime($work['thursday_stop'])).")<br />";
										if($work['friday']) echo "piątek (".date('G:i', strtotime($work['friday_start']))." - ".date('G:i', strtotime($work['friday_stop'])).")<br />";
										if($work['saturday']) echo "sobota (".date('G:i', strtotime($work['saturday_start']))." - ".date('G:i', strtotime($work['saturday_stop'])).")<br />";
										if($work['sunday']) echo "niedziela (".date('G:i', strtotime($work['sunday_start']))." - ".date('G:i', strtotime($work['sunday_stop'])).")<br />";					
									?>
									</div>
									<div class="desc"><a href="reviews.php?id=<?=$_GET['id']?>">Zobacz opinie o tym masażyście</a>
									</div>							
									<br /><br />
									<button class="button"><a href="reservation-add.php?id=<?=$_GET['id']?>">Umów wizytę</a></button>
								</div>		
							</div>	
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>  
</body>

</html>