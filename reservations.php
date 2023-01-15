<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require("Exception.php");
require("PHPMailer.php");
require("SMTP.php");
require("header.php");


$reservations = DB::query("SELECT * FROM reservations");

if(isset($_GET['accept'])){
	$update = DB::query("UPDATE reservations SET status=%s WHERE id=%i", "Zaakceptowana", $_GET['accept']);
	$reservation = DB::queryFirstRow("SELECT * FROM reservations WHERE id=%i", $_GET['accept']);
	$client = DB::queryFirstRow("SELECT name, surname, tel, email FROM users WHERE id=%i", $reservation['client_id']);
	$masseur = DB::queryFirstRow("SELECT name, surname, tel, email FROM users WHERE id=%i", $reservation['masseur_id']);
	DB::insert('notifications', array(
		'user_id' => $reservation['client_id'],
		'content' => "Twoja rezerwacja została zaakceptowana.",
		'seen' => "0"
	));
	
	$mail = new PHPMailer;
	$mail->IsHTML(true);
	$mail->isSMTP();
	$mail->Host = 'mail.masujmnie.pl';
	$mail->SMTPAuth = true;
	$mail->Username = 'powiadomienie@masujmnie.pl';
	$mail->Password = '61,&,oUTLEpsO';
	$mail->SMTPSecure = 'tls';
	$mail->Port = 587;
	$mail->CharSet = 'UTF-8';

	$mail->From = 'powiadomienie@masujmnie.pl';
	$mail->FromName = 'Masujmnie.pl';
	$mail->addAddress($client['email']);
	$date = DateTime::createFromFormat('Y-m-d H:i:s', $reservation['date']);
	
	$message = file_get_contents('emails/notification.html');
	$message = str_replace('{reservation_info}', 'Twoja rezerwacja została właśnie potwierdzona przez masażystę!', $message);
	$message = str_replace('{reservation_fullname}', $client['name'].' '.$client['surname'], $message);
	$message = str_replace('{reservation_address}', $reservation['address'].', '.$reservation['city'], $message);
	$message = str_replace('{reservation_phonenumber}', $client['tel'], $message);
	$message = str_replace('{reservation_startdatetime}', $date->format('d.m.Y'), $message);
	$message = str_replace('{reservation_datetimehour}', $date->format('H:i'), $message);
	$message = str_replace('{reservation_employee}', $masseur['name'].' '.$masseur['surname'], $message);
	$message = str_replace('{reservation_service}', $reservation['service_type'], $message);
	$message = str_replace('{reservation_cost}', $reservation['service_price'], $message);
	$message = str_replace('{reservation_telephone}', $masseur['tel'], $message);
	$message = str_replace('{reservation_email}', $masseur['email'], $message);
	
	$mail->Subject = 'Twoja rezerwacja #'.$reservation['id'].' została potwierdzona';
	$mail->MsgHTML($message);
	$mail->send();
	header("Location: reservations.php");
	exit;
}

if(isset($_GET['cancel'])){
	$update = DB::query("UPDATE reservations SET status=%s WHERE id=%i", "Anulowana", $_GET['cancel']);
	$reservation = DB::queryFirstRow("SELECT * FROM reservations WHERE id=%i", $_GET['cancel']);
	$client = DB::queryFirstRow("SELECT email FROM users WHERE id=%i", $reservation['client_id']);
	$masseur = DB::queryFirstRow("SELECT tel, email FROM users WHERE id=%i", $reservation['masseur_id']);
	DB::insert('notifications', array(
		'user_id' => $reservation['client_id'],
		'content' => "Twoja rezerwacja została odrzucona.",
		'seen' => "0"
	));
	
	$mail = new PHPMailer;
	$mail->IsHTML(true);
	$mail->isSMTP();
	$mail->Host = 'mail.masujmnie.pl';
	$mail->SMTPAuth = true;
	$mail->Username = 'powiadomienie@masujmnie.pl';
	$mail->Password = '61,&,oUTLEpsO';
	$mail->SMTPSecure = 'tls';
	$mail->Port = 587;
	$mail->CharSet = 'UTF-8';

	$mail->From = 'powiadomienie@masujmnie.pl';
	$mail->FromName = 'Masujmnie.pl';
	$mail->addAddress($client['email']);
	
	$message = file_get_contents('emails/notification-cancel.html');
	$message = str_replace('{reservation_info}', 'Twoja rezerwacja została właśnie anulowana przez masażystę!', $message);
	$message = str_replace('{reservation_telephone}', $masseur['tel'], $message);
	$message = str_replace('{reservation_email}', $masseur['email'], $message);
	
	$mail->Subject = 'Twoja rezerwacja #'.$reservation['id'].' została anulowana';
	$mail->MsgHTML($message);
	$mail->send();
	header("Location: reservations.php");
	exit;
}

?>
            <div class="content">
                <div class="content-nav">
                    <a href="index.php" class="nav-item">Strona główna</a>
                    <a href="reservations.php" class="nav-item">Zarządzaj rezerwacjami</a>
                </div>
                <div class="greet">
                    <p class="greet-text">Zarządzaj rezerwacjami</p>
                    <span style="width: 100%; height: 1px; margin-top: 20px; background-color: #ececec;">
                </div>
                <div class="tiles">
                    <p class="title">
                        <i class="fas fa-cog"></i>
                        Opcje
                    </p>
                </div>
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
									<th>Klient</th>
									<th>Masażysta</th>
									<th>Data</th>
									<th>Adres</th>
									<th>Miasto</th>
									<th>Płatność</th>
									<th>Uwagi</th>
									<th>Ocena</th>
									<th>Status</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="reservations">
							<?php
							foreach($reservations as $r){
								$client = DB::queryFirstRow("SELECT name, surname FROM users WHERE id=%i", $r['client_id']);
								$masseur = DB::queryFirstRow("SELECT name, surname FROM users WHERE id=%i", $r['masseur_id']);
								echo "<tr>";
								echo "<td>".$r['id']."</td>";
								echo "<td>".$client['name']." ".$client['surname']." (".$r['client_id'].")</td>";
								echo "<td>".$masseur['name']." ".$masseur['surname']." (".$r['masseur_id'].")</td>";
								echo "<td>".$r['date']."</td>";
								echo "<td>".$r['address']."</td>";
								echo "<td>".$r['city']."</td>";
								echo "<td>".$r['payment']."</td>";
								echo "<td>".$r['notice']."</td>";
								echo "<td>".$r['rating']."</td>";
								echo "<td>".$r['status']."</td>";
								if($user['role'] == "Kierownik")
									echo "<td style='width: 29%'><span style='padding: 1rem 0;display:flex;flex-direction:column;align-items:center;gap:0.5rem;'><a href='?accept=".$r['id']."' class='button edit-user'>Akceptuj</a><a href='?cancel=".$r['id']."' class='button delete-user' style='margin-left: 5px;'>Odrzuć</a> <a href='change-masseur.php?id=".$r['id']."' class='button edit-user'>Zmień pracownika</a><a href='change-date.php?id=".$r['id']."' class='button delete-user' style='margin-left: 5px;'>Zmień termin</a>";
								else
									echo "<td style='width: 19%'><span style='padding: 1rem 0;display:flex;flex-direction:column;align-items:center;gap:0.5rem;'><a href='?accept=".$r['id']."' class='button edit-user'>Akceptuj</a><a href='?cancel=".$r['id']."' class='button delete-user' style='margin-left: 5px;'>Odrzuć</a><a href='change-date.php?id=".$r['id']."' class='button delete-user' style='margin-left: 5px;'>Zmień termin</a>";
								echo "</tr>";
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