<?php
require("header.php");

$reservations = DB::query("SELECT * FROM reservations WHERE client_id=%i", $_SESSION['id']);

if(isset($_GET['cancel'])){
	$update = DB::query("UPDATE reservations SET status=%s WHERE id=%i", "Anulowana", $_GET['cancel']);
	header("Location: your-reservations.php");
	exit;
}

if(isset($_GET['rate'])){
	$update = DB::query("UPDATE reservations SET rating=%i WHERE id=%i", $_GET['rate'], $_GET['id']);
	header("Location: your-reservations.php");
	exit;	
}
?>
            <div class="content">
                <div class="content-nav">
                    <a href="index.php" class="nav-item">Strona główna</a>
                    <a href="your-reservations.php" class="nav-item">Twoje rezerwacje</a>
                </div>
                <div class="greet">
                    <p class="greet-text">Twoje rezerwacje</p>
                    <span style="width: 100%; height: 1px; margin-top: 20px; background-color: #ececec;">
                </div>
                <div class="reservations">

                </div>
                <div class="tiles">
                    <p class="title">
                        <i class="fas fa-book"></i>
                        Twoje rezerwacje
                    </p>
                    <div class="grid-reservations">
						<?php
						if(empty($reservations))
							echo "Nie posiadasz obecnie rezerwacji!";
						else {
							foreach($reservations as $r){
								$masseur = DB::queryFirstRow("SELECT * FROM users WHERE id=%i", $r['masseur_id']);
								echo "<div class='tile tile-reservation'>";
								echo "<div class='company'>";
								echo "<img src='assets/images/avatars/".$masseur['avatar']."'>";
								echo "<div class='company-info'>";
								echo "<p class='fullname'>".$masseur['name']."</p>";
								echo "<p class='role'>";
								echo "<i class='fas fa-user-cog'></i> ".$masseur['specializations']."</p>";
								echo "<a href='company-details.php?id=".$r['masseur_id']."' class='profile'>Zobacz profil</a>";
								echo "</div></div>";
								echo "<div class='information'>";
								echo "<div class='info'><div class='icon'><i class='fas fa-globe-europe'></i></div>";
								echo "<p class='info-label'>Lokalizacja: <span class='info-details'>".$r['address'].", ".$r['city']."</span></p></div>";
								echo "<div class='info'><div class='icon'><i class='fas fa-hand-paper'></i></div>";
								echo "<p class='info-label'>Rodzaj usługi: <span class='info-details'>".$r['service_type']."</span></p></div>";
								echo "<div class='info'><div class='icon'><i class='fas fa-flag'></i></div>";
								echo "<p class='info-label'>Język mówiony: <span class='info-details'>".$masseur['language']."</span></p></div>";								
								echo "<div class='info'><div class='icon'><i class='fas fa-clock'></i></div>";
								echo "<p class='info-label'>Data i godzina: <span class='info-details'>".date('d.m.Y G:i', strtotime($r['date']))."</span></p></div>";
								echo "<div class='info'><a href='your-reservations.php' class='settings'>Zarządzaj rezerwacją</a><a href='your-reservations.php' class='settings'>Odwołaj</a></div></div></div>";
							}
						}
						?>
					</div>
                    <p class="title">
                        <i class="fas fa-tachometer-alt"></i>
                        Historia rezerwacji
                    </p>
                    <div class="content-users">
						<div class="search-bar">
							<form>
								<div class="search-input">
									<input class="search-bar" id="search-bar" placeholder="Wyszukaj rezerwację..."> 
									<i class="fas fa-search"></i>
								</div>
								<div class="search-input">
									<select class="search-bar">
										<option disabled selected>Szukaj po...</option>
										<option>Dzisiaj</option>
										<option>W tym tygodniu</option>
										<option>W tym miesiącu</option>
									</select>
								</div>
							</form>
						</div>
                    <div class="table-content">
                        <table>
							<thead>
								<tr>
									<th>ID</th>
									<th>Masażysta</th>
									<th>Data</th>
									<th>Rodzaj usługi</th>
									<th>Cena usługi</th>
									<th>Ocena</th>
									<th>Status</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="reservations">
							<?php
							if(empty($reservations))
								echo "Nie posiadasz obecnie rezerwacji!";
							else {
								foreach($reservations as $r){
									$client = DB::queryFirstRow("SELECT name, surname FROM users WHERE id=%i", $r['client_id']);
									$masseur = DB::queryFirstRow("SELECT name, surname FROM users WHERE id=%i", $r['masseur_id']);
									echo "<tr>";
									echo "<td>".$r['id']."</td>";
									echo "<td>".$masseur['name']." ".$masseur['surname']." (".$r['masseur_id'].")</td>";
									echo "<td>".$r['date']."</td>";
									echo "<td>".$r['service_type']."</td>";
									echo "<td>".$r['service_price']."zł</td>";
									echo "<td style='width:15%;'>";
									if($r['rating'] != 0){									
										echo "<div class='stars'><div class='stars-content'>";
											for($i=5;$i>0;$i--){
												if($i <= $r['rating'])
													echo "<i class='fas fa-star' style='color: #ffd700;'></i>";
												else
													echo "<i class='fas fa-star'></i>";
											}
										echo "</div></div>";
									}									
									else
										echo "<a href='rate.php?id=".$r['id']."' class='button delete-user' style='margin-left: 5px;'>Oceń zamówienie</a>";
									echo "</td>";
									echo "<td>".$r['status']."</td>";
									echo "<td style='width: 15%;'><span style='padding: 1rem 0;display:flex;flex-direction:column;align-items:center;gap:0.5rem;'><a href='?cancel=".$r['id']."' class='button delete-user' style='margin-left: 5px;'>Anuluj</a><a href='change-date.php?id=".$r['id']."' class='button delete-user' style='margin-left: 5px;'>Zmień termin</a>";
									echo "</tr>";
								}
							}
							?>
							</tbody>
                        </table>
                    </div>
						<!--
                        <div class="pages">
                            <div class="page">1</div>
                            <div class="page">2</div>
                            <div class="page">3</div>
                        </div>
						-->
                    </div>
                </div>
            </div>
        </main>
    </div>  
</body>
<script>
$(document).ready(function(){
  $("#search-bar").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#reservations tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
</html>