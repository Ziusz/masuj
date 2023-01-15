<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require("Exception.php");
require("PHPMailer.php");
require("SMTP.php");
require("header.php");

if(!isset($_GET['id']) && $_SERVER["REQUEST_METHOD"] != "POST"){
	header("Location: set-appointment.php");
	exit;
}

if(isset($_GET['id'])){
	$masseur = DB::queryFirstRow("SELECT * FROM users WHERE id=%i", $_GET['id']);
	$work = DB::queryFirstRow("SELECT * FROM availability WHERE masseur_id=%i", $_GET['id']);
	$services = DB::query("SELECT * FROM services WHERE masseur_id=%i", $_GET['id']);
}

if(isset($_GET['day']) && isset($_GET['month']) && isset($_GET['year'])){
	$date = DateTime::createFromFormat('Ymd', $_GET['year'].$_GET['month'].$_GET['day']);
	$start = $work[strtolower($date->format('l')).'_start'];
	$stop = DateTime::createFromFormat('H:i:s', $work[strtolower($date->format('l')).'_stop']);
	$time = DateTime::createFromFormat('H:i:s', $start);
	$cycle = DB::queryFirstField("SELECT cycle FROM companies JOIN users ON users.company_id=companies.id WHERE users.id=%i", $_GET['id']);
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reserve'])){
	$service = DB::queryFirstRow("SELECT * FROM services WHERE id=%i", $_POST['service']);
	$date = DateTime::createFromFormat('Y-m-d H:i', $_POST['date'].$_POST['time']);
	$masseur = DB::queryFirstRow("SELECT name, surname, tel, email FROM users WHERE id=%i", $_POST['id']);
	DB::insert('reservations', array(
		'client_id' => $_SESSION['id'],
		'masseur_id' => $_POST['id'],
		'date' => $date->format('Y-m-d H:i'),
		'address' => $user['street'],
		'city' => $user['city'],
		'service_type' => $service['category']." / ".$service['name'],
		'service_price' => $service['price'],
		'payment' => $_POST['payment'],
		'notice' => $_POST['notice'],
		'rating' => 0,
		'created_at' => DB::sqleval("NOW()")
	));
	$id = DB::insertId();
	DB::insert('notifications', array(
		'user_id' => $_SESSION['id'],
		'content' => "Dziękujemy za złożenie rezerwacji! Otrzymasz powiadomienie, gdy masażysta potwierdzi twoją wizytę.",
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
	$mail->addAddress($user['email']);
	
	$message = file_get_contents('emails/notification.html');
	$message = str_replace('{reservation_info}', 'Utworzyłeś właśnie nową rezerwację! Poczekaj na potwierdzenie jej przyjęcia przez firmę wykonującą usługę.', $message);
	$message = str_replace('{reservation_fullname}', $user['name'].' '.$user['surname'], $message);
	$message = str_replace('{reservation_address}', $user['street'].', '.$user['city'], $message);
	$message = str_replace('{reservation_phonenumber}', $user['tel'], $message);
	$message = str_replace('{reservation_startdatetime}', $date->format('d.m.Y'), $message);
	$message = str_replace('{reservation_datetimehour}', $date->format('H:i'), $message);
	$message = str_replace('{reservation_employee}', $masseur['name'].' '.$masseur['surname'], $message);
	$message = str_replace('{reservation_service}', $service['category'].' / '.$service['name'], $message);
	$message = str_replace('{reservation_cost}', $service['price'], $message);
	$message = str_replace('{reservation_telephone}', $masseur['tel'], $message);
	$message = str_replace('{reservation_email}', $masseur['email'], $message);
	
	$mail->Subject = 'Utworzyłeś rezerwację #'.$id;
	$mail->MsgHTML($message);
	$mail->send();

	DB::insert('notifications', array(
		'user_id' => $_POST['id'],
		'content' => "Masz nową rezerwację!\nData i godzina: ".$date->format('Y-m-d H:i')."\nImię i nazwisko: ".$user['name']." ".$user['surname']."\nAdres: ".$user['street'].", ".$user['city']."\nNumer telefonu: ".$user['tel']."\nAdres e-mail: ".$user['email'],
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
	$mail->addAddress($masseur['email']);
	
	$message = file_get_contents('emails/admin-notification.html');
	$message = str_replace('{reservation_fullname}', $user['name'].' '.$user['surname'], $message);
	$message = str_replace('{reservation_address}', $user['street'].', '.$user['city'], $message);
	$message = str_replace('{reservation_phonenumber}', $user['tel'], $message);
	$message = str_replace('{reservation_startdatetime}', $date->format('d.m.Y'), $message);
	$message = str_replace('{reservation_datetimehour}', $date->format('H:i'), $message);
	$message = str_replace('{reservation_employee}', $masseur['name'].' '.$masseur['surname'], $message);
	$message = str_replace('{reservation_service}', $service['category'].' / '.$service['name'], $message);
	$message = str_replace('{reservation_cost}', $service['price'], $message);
	
	$mail->Subject = 'Nowa rezerwacja #'.$id;
	$mail->MsgHTML($message);
	$mail->send();	
	header("Location: index.php");
	exit;
}

function build_calendar($month, $year, $work) {
    $daysOfWeek = array('PN','WT','ŚR','CZ','PT','SO','ND');
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $numberDays = date('t',$firstDayOfMonth);
    $dateComponents = getdate($firstDayOfMonth);
	$monthsNames = ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'];
    $monthName = $monthsNames[$dateComponents['mon'] - 1];	
    $dayOfWeek = $dateComponents['wday'] - 1;
	if ($dayOfWeek < 0) {
		$dayOfWeek = 6;
	}	
    $calendar = "<table class='calendar'>";
    $calendar .= "<caption>$monthName $year</caption>";
    $calendar .= "<tr>";
	foreach($daysOfWeek as $day){
        $calendar .= "<th class='header'>$day</th>";
    } 
	$currentDay = 1;
	$calendar .= "</tr><tr>";
	if ($dayOfWeek > 0) { 
        $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>"; 
    }   
    $month = str_pad($month, 2, "0", STR_PAD_LEFT);
    while ($currentDay <= $numberDays) {
        if ($dayOfWeek == 7) {
            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";
        }
        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $date = "$year-$month-$currentDayRel";
		if(!$work[strtolower(jddayofweek($dayOfWeek, 1))] || ($month == date('n') && $currentDay < date('j')))
			$calendar .= "<td class='day' rel='$date' style='background: red;color:#FFF'>$currentDay</td>";
		else
			$calendar .= "<td class='day' rel='$date' style='background: green;color:#FFF'><a style='color:#fff' href='reservation-add.php?id=".$_GET['id']."&day=$currentDay&month=$month&year=$year'>$currentDay</a></td>";
        $currentDay++;
        $dayOfWeek++;

    }
	if ($dayOfWeek != 7) { 
        $remainingDays = 7 - $dayOfWeek;
        $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>"; 
    }
    $calendar .= "</tr>";
    $calendar .= "</table>";
    return $calendar;
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
									Wybierz datę wizyty:
									<?php
									$dateComponents = getdate();
									$month = $dateComponents['mon']; 			     
									$year = $dateComponents['year'];
									echo build_calendar($month, $year, $work);
									if($month != 12)
										$month = $dateComponents['mon']+1; 			     
									else {
										$month = 1;
										$year = $year = $dateComponents['year']+1;
									}
									echo build_calendar($month, $year, $work);									 
									?>
								<br /><br />
								<?php if(isset($_GET['day']) && isset($_GET['month']) && isset($_GET['year'])){ ?>
								<label for="date">
									Wybrana data:
									<input type="date" name="date" id="date" value="<?=$date->format('Y-m-d')?>" readonly>
								</label>
								<br />
								<label for="time">
									Wybierz godzinę:
									<select id="time" name="time">
									<?php
										while($time < $stop){
											echo "<option value='".$time->format('H:i')."'>".$time->format('H:i')."</option>";
											$time->add(new DateInterval('PT'.$cycle.'M'));
										}
									?>
									</select>
								</label>
								<br />
								<label for="service">
									Wybierz usługę:
									<select type="text" id="service" name="service">
										<option disabled selected>Wybierz...</option>
										<?php
										if($services){
											foreach($services as $s){
												echo "<option value='".$s["id"]."'>".$s["name"]." (".$s["price"]." PLN)</option>";
											}
										}
										?>
									</select>
								</label>
								<br />
								<label for="payment">
									Wybierz metodę płatności:
									<select type="text" id="payment" name="payment">
										<option disabled selected>Wybierz...</option>
										<?php
										if($masseur['payment'] != "Karta i gotówka")
											echo "<option value='".$masseur['payment']."'>".$masseur['payment']."</option>";
										else {
											echo "<option value='Karta'>Karta</option>";
											echo "<option value='Gotówka'>Gotówka</option>";
										}
										?>
									</select>
								</label>									
								<br />
								<br />Uwagi:<br />
									<textarea name="notice" cols="30" rows="5" style="padding: 5px"></textarea>	
								<br />
								<input type="hidden" name="id" value="<?=$_GET['id']?>" readonly>
								<button class="button" type="submit" name="reserve">Zarezerwuj termin</button>
								<?php } ?>
							</form>
							
                </div>
            </div>
        </main>
        <div class="go-up"></div>
    </div>  

</body>

</html>