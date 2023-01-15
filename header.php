<?php
require("config.php");
ob_start();
if(!isset($_SESSION))
	session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: login.php");
    exit;
}

if(isset($_GET['remove_notification'])){
	$update = DB::query("UPDATE notifications SET seen=%i WHERE id=%i", 1, $_GET['remove_notification']);
}

$user = DB::queryFirstRow("SELECT * FROM users WHERE id=%i", $_SESSION['id']);
$notifications = DB::query("SELECT * FROM notifications WHERE user_id=%i and seen=%i", $_SESSION['id'], 0);

if($user['blocked'] == 1){
	$_SESSION = array();
	session_destroy();	
	echo "Twoje konto zostało zablokowane. Skontaktuj się z administratorem w celu wyjaśnienia sprawy.";
	echo "<br />Adres e-mail: biuro@masujmnie.pl";
	exit;
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta name="description" content="Serwis skupiający najlepszych masażystów w Polsce" />
    <meta name="author" content="Ksawery Piątek" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>MasujMnie</title>

    <link rel="stylesheet" href="assets/styles/global.css" />
    <?php
	if(basename($_SERVER['PHP_SELF']) == "settings.php" || basename($_SERVER['PHP_SELF']) == "user-edit.php" || basename($_SERVER['PHP_SELF']) == "user-add.php" || basename($_SERVER['PHP_SELF']) == "service-add.php" || basename($_SERVER['PHP_SELF']) == "company-profile.php" || basename($_SERVER['PHP_SELF']) == "company-details.php" || basename($_SERVER['PHP_SELF']) == "rate.php")
		echo '<link rel="stylesheet" href="assets/styles/components/settings/settings.css" />';
	//if(basename($_SERVER['PHP_SELF']) == "settings.php" || basename($_SERVER['PHP_SELF']) == "user-edit.php" || basename($_SERVER['PHP_SELF']) == "user-add.php" || basename($_SERVER['PHP_SELF']) == "service-add.php" || basename($_SERVER['PHP_SELF']) == "company-profile.php" || basename($_SERVER['PHP_SELF']) == "company-details.php" || basename($_SERVER['PHP_SELF']) == "reports.php")
		//echo '<link rel="stylesheet" href="assets/styles/components/modal/modal.css" />';
	if(basename($_SERVER['PHP_SELF']) == "users.php" || basename($_SERVER['PHP_SELF']) == "reservations.php" || basename($_SERVER['PHP_SELF']) == "your-reservations.php" || basename($_SERVER['PHP_SELF']) == "company-profile.php" || basename($_SERVER['PHP_SELF']) == "company.php" || basename($_SERVER['PHP_SELF']) == "reports.php" || basename($_SERVER['PHP_SELF']) == "rate.php")
		echo '<link rel="stylesheet" href="assets/styles/components/admin/admin.css" />';
	if(basename($_SERVER['PHP_SELF']) == "set-appointment.php")
		echo '<link rel="stylesheet" href="assets/styles/components/set-appointment/set-appointment.css" />';
	if(basename($_SERVER['PHP_SELF']) == "company-details.php")
		echo '<link rel="stylesheet" href="assets/styles/components/company-details/company-details.css" />';
	if(basename($_SERVER['PHP_SELF']) == "availability.php")
		echo '<link rel="stylesheet" href="assets/styles/components/availability/availability.css" />';
	if(basename($_SERVER['PHP_SELF']) == "rate.php")
		echo '<link rel="stylesheet" href="assets/styles/components/stars/stars.css" />';
	if(basename($_SERVER['PHP_SELF']) == "your-reservations.php")
		echo '<link rel="stylesheet" href="assets/styles/components/stars_old/stars.css" />';
	?>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.5/dist/fullcalendar.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
	<script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.5/dist/locale-all.min.js"></script>
</head>
<body>
    <div class="container">
        <nav class="nav">
            <i class="fas fa-times close-nav"></i>
            <div class="logo">
                <img src="assets/images/logo.png" alt="logo">
                <p class="company">Masuj Mnie</p>
            </div>
            <div class="profile">
                <div class="profile-logo">
                    <a href="settings.php">
                        <img src="assets/images/avatars/<?=$user['avatar']?>" alt="user image">
                    </a>
                </div>
                <div class="profile-user">
                    <p class="fullname"><?=$user['name']?> <?=$user['surname']?></p>
                    <p class="role">
                        <i class="fas fa-user-cog"></i>
                        <?=$user['role']?>
                    </p>
                </div>
            </div>
            <div class="routes">
                <p class="section-title">Strona główna</p>
                <a href="index.php" class="nav-link <!--nav-link--active -->" style="display: flex; align-items: center;">
                    <div class="icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    Pulpit
                </a>
                <a href="set-appointment.php" class="nav-link">
                    <div class="icon">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    Umów wizytę
                </a>
				<?php if($user['role'] == "Masażysta" || $user['role'] == "Kierownik"){ ?>
                <a href="availability.php" class="nav-link">
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    Dostępność
                </a>
				<?php } ?>
                <a href="your-reservations.php" class="nav-link">
                    <div class="icon">
                        <i class="fas fa-book"></i>
                    </div>
                    Rezerwacje
                </a>
               
				<?php if($user['role'] == "Administrator"){ ?>
                <p class="section-title">Zarządzanie</p>
                <a href="users.php" class="nav-link">
                    <div class="icon">
                        <i class="fas fa-users"></i>                        
                    </div>
                    Użytkownicy
                </a>
				<?php } ?>
				<?php if($user['role'] != "Klient"){ ?>
                <a href="reservations.php" class="nav-link">
                    <div class="icon">
                        <i class="fas fa-book"></i>                        
                    </div>
                    Zarządzaj rezerwacjami
                </a>
				<?php } ?>
				<?php if($user['role'] == "Kierownik"){ ?>
                <a href="company.php" class="nav-link">
                    <div class="icon">
                        <i class="fas fa-briefcase"></i>                        
                    </div>
                    Zarządzaj firmą
                </a>
                <a href="subscription.php" class="nav-link">
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>                        
                    </div>
                    Abonament
                </a>				
				<?php } ?>
				<?php if($user['role'] == "Administrator"){ ?>
                <a href="reports.php" class="nav-link">
                    <div class="icon">
                        <i class="fas fa-book-open"></i>                        
                    </div>
                    Raporty
                </a>
				<?php } ?>
                <p class="section-title">Ustawienia użytkownika</p>
				<?php if($user['role'] == "Klient"){ ?>
                <a href="settings.php" class="nav-link">
                    <div class="icon">
                        <i class="fas fa-cogs"></i>                        
                    </div>
                    Ustawienia profilu
                </a>
				<?php } ?>
				<?php if($user['role'] == "Masażysta" || $user['role'] == "Kierownik"){ ?>
                <a href="company-profile.php" class="nav-link">
                    <div class="icon">
                        <i class="fas fa-user-cog"></i>                      
                    </div>
                    Profil masażysty
                </a>
				<?php } ?>
                <a href="logout.php" class="nav-link">
                    <div class="icon">
                        <i class="fas fa-door-open"></i>                        
                    </div>
                    Wyloguj
                </a>
                <div class="copyright">
                    MasujMnie &copy; 2022
                </div>
            </div>
        </nav>
        <main class="main">
            <div class="search">
                <i class="fas fa-bars show-nav" style="opacity: 0; cursor: unset;"></i>
                <div class="notifications">
                    <i class="far fa-bell show-notifications" <?php if(!empty($notifications)) echo "style='color:red'" ?>></i>
                    <div class="modal modal-hidden modal-notifications" style="left: -295px; top: 43px;">
                        <p class="title">Powiadomienia</p>
						<?php
						if(empty($notifications))
							echo "Brak powiadomień";
						else
						foreach($notifications as $n){
							echo "<div class='notification'>";
							echo "<i class='fas fa-exclamation-circle'></i><a href='?remove_notification=".$n['id']."'><i class='fas fa-times hide-notification'></i></a>";
							echo "<p class='message'>".nl2br($n['content'])."</p>";
							echo "</div>";
						}
						?>
                    </div>
                </div>
            </div>