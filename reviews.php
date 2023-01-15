<?php
require("header.php");

if(!isset($_GET['id'])){
	header("Location: set-appointment.php");
	exit;
}

$comments = DB::query("SELECT name, service_type, rating, date, comment FROM reservations JOIN users ON reservations.client_id = users.id WHERE masseur_id=%i AND rating > %i", $_GET['id'], 0);
?>
            <div class="content">
                <div class="content-nav">
                    <a href="index.php" class="nav-item">Strona główna</a>
                    <a href="set-appointment.php" class="nav-item">Opinie</a>
                </div>
                <div class="greet">
                    <p class="greet-text">Opinie</p>
                    <span style="width: 100%; height: 1px; margin-top: 20px; background-color: #ececec;">
                </div>
                <div class="content-profile">
                    <div class="card">
                        <div class="info">
							<div class="desc">Komentarze:
							<?php
								foreach($comments as $c){
									echo "<br><br><b>Ocena:</b> ".$c['rating']."/5";
									if(empty($c['comment']))
										echo "<br>Brak komentarza";
									else
										echo "<br>".$c['comment'];
									echo "<br><b>Usługa:</b> ".$c['service_type'];
									echo "<br><b>Napisane przez:</b> ".$c['name']." dnia ".date('d.m.Y G:i', strtotime($c['date']));
								}			
							?>
							</div>							
                            <br /><br />
							<button class="button" style="border:none"><a style="color:#fff" href="reservation-add.php?id=<?=$_GET['id']?>">Umów wizytę</a></button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>  
</body>

</html>