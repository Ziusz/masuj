<?php
require("header.php");

function getStartAndEndDate($week, $year){
	$dto = new DateTime();
	$ret['week_start'] = $dto->setISODate($year, $week)->format('Y-m-d');
	$ret['week_end'] = $dto->modify('+6 days')->format('Y-m-d');
	return $ret;
}

$time = date("H:i", strtotime('0:00'));
$week = getStartAndEndDate(date('W'), date('Y'));
$dates = [];

if($user['role'] == "Masażysta" || $user['role'] == "Kierownik")
	$reservations = DB::query("SELECT * FROM reservations WHERE masseur_id=%i", $_SESSION['id']);
else
	$reservations = DB::query("SELECT * FROM reservations WHERE client_id=%i", $_SESSION['id']);
?>
            <div class="content">
                <div class="content-nav">
                    <a href="index.php" class="nav-item">Strona główna</a>
                    <a href="index.php" class="nav-item">Pulpit</a>
                </div>
                <div class="greet">
                    <p class="greet-text">Witaj, <?=$user['name']?> <?=$user['surname']?>!</p>
                    <a href="set-appointment.php" class="button">Rozpocznij rezerwację</a>
                    <span style="width: 100%; height: 1px; margin-top: 20px; background-color: #ececec;">
                </div>
                <div class="reservations">

                </div>
                <div class="tiles">
                    <p class="title">
                        <i class="fas fa-book"></i>
                        Twoje rezerwacje
                    </p>
					<script>
		
					  document.addEventListener('DOMContentLoaded', function() {
						var calendarEl = document.getElementById('calendar');
						var calendar = new FullCalendar.Calendar(calendarEl, {
						  initialView: 'dayGridMonth'
						});
						calendar.render();
					  });

					</script>
				<div id='calendar'></div>
				<br />	
                    <p class="title">
                        <i class="fas fa-tachometer-alt"></i>
                        Pulpit
                    </p>
                    <div class="grid-cards">
                        <a href="set-appointment.php" class="tile tile-dashboard">
                            <i class="fas fa-tachometer-alt"></i>
                            <span class="card-title">Umów wizytę</span>
                        </a>
                        <a href="#" class="tile tile-dashboard">
                            <i class="fas fa-clock"></i>
                            <span class="card-title">Twoje rezerwacje</span>
                        </a>
						<?php if($user['role'] == "Masażysta" || $user['role'] == "Kierownik"){ ?>
                        <a href="availability.php" class="tile tile-dashboard">
                            <i class="fas fa-calendar"></i>
                            <span class="card-title">Dostępność</span>
                        </a>
						<?php } ?>
                    </div>
                    <p class="title">
                        <i class="fas fa-user-cog"></i>
                        Zarządzaj
                    </p>
                    <div class="grid-cards">
						<?php if($user['role'] == "Administrator"){ ?>
                        <a href="users.php" class="tile tile-settings">
                            <i class="fas fa-tachometer-alt"></i>
                            <span class="card-title">Użytkownicy</span>
                        </a>
						<?php } ?>
						<?php if($user['role'] != "Klient"){ ?>
                        <a href="reservations.php" class="tile tile-settings">
                            <i class="fas fa-book"></i>
                            <span class="card-title">Zarządzaj rezerwacjami</span>
                        </a>
						<?php } ?>
						<?php if($user['role'] == "Kierownik"){ ?>
                        <a href="company.php" class="tile tile-settings">
                            <i class="fas fa-briefcase"></i>  
                            <span class="card-title">Zarządzaj firmą</span>
                        </a>
						<?php } ?>
						<?php if($user['role'] == "Administrator"){ ?>
                        <a href="reports.php" class="tile tile-settings">
                            <i class="fas fa-book-open"></i>  
                            <span class="card-title">Raporty</span>
                        </a>
						<?php } ?>
						<?php if($user['role'] != "Klient"){ ?>
                        <a href="settings.php" class="tile tile-settings">
                            <i class="fas fa-cogs"></i>  
                            <span class="card-title">Profil</span>
                        </a>
						<?php } ?>
						<?php if($user['role'] == "Masażysta" || $user['role'] == "Kierownik"){ ?>
                        <a href="company-profile.php" class="tile tile-settings">
                            <i class="fas fa-cogs"></i>  
                            <span class="card-title">Profil masażysty</span>
                        </a>
						<?php } ?>
                    </div>
                </div>
            </div>
        </main>
        <div class="go-up"></div>
    </div>  
</body>

</html>