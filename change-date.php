<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require("Exception.php");
require("PHPMailer.php");
require("SMTP.php");
require("header.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$update = DB::query("UPDATE reservations SET date=%t WHERE id=%i", $_POST['date'], $_POST['id']);
	$reservation = DB::queryFirstRow("SELECT * FROM reservations WHERE id=%i", $_POST['id']);
	$client = DB::queryFirstRow("SELECT name, surname, tel, email FROM users WHERE id=%i", $reservation['client_id']);
	$masseur = DB::queryFirstRow("SELECT name, surname, tel, email FROM users WHERE id=%i", $reservation['masseur_id']);
	$date = DateTime::createFromFormat('Y-m-d H:i', str_replace('T', ' ', $_POST['date']));
	DB::insert('notifications', array(
		'user_id' => $reservation['client_id'],
		'content' => "Zmieniono termin rezerwacji z ".date('d.m.Y H:i', strtotime($reservation['date']))." na ".$date->format('d.m.Y H:i'),
		'seen' => "0"
	));
	DB::insert('notifications', array(
		'user_id' => $reservation['masseur_id'],
		'content' => "Zmieniono termin rezerwacji z ".date('d.m.Y H:i', strtotime($reservation['date']))." na ".$date->format('d.m.Y H:i'),
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
	$mail->addAddress($masseur['email']);
	
	$message = file_get_contents('emails/notification.html');
	$message = str_replace('{reservation_info}', 'Zmieniono datę rezerwacji #'.$reservation['id'].'. Poczekaj na akceptację zmiany przez drugą stronę.', $message);
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
	
	$mail->Subject = 'Zmieniono datę rezerwacji #'.$reservation['id'];
	$mail->MsgHTML($message);
	$mail->send();		
	header("Location: index.php");
	exit;
}
?>
            <div class="content">
                <div class="content-nav">
                    <a href="index.php" class="nav-item">Strona główna</a>
                    <a href="company-profile.php" class="nav-item">Tworzenie usługi</a>
                </div>
                <div class="tiles">
                    <p class="title">
                        <i class="fas fa-cog"></i>
                        Usługa
                    </p>
                </div>
                <div class="content-profile">
							<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
								<label for="date">
									Nowa data i godzina wizyty:
									<input type="datetime-local" id="date" name="date" value=<?php echo date('Y-m-d\TH:i'); ?>>
								</label>
								<input type="hidden" name="id" value="<?=$_GET['id']?>">
								<button type="submit" class="button" style="border:none">Zmień datę</a>
							</form>
                </div>
            </div>
        </main>
        <div class="go-up"></div>
    </div>  

</body>

</html>