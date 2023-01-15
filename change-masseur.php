<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require("Exception.php");
require("PHPMailer.php");
require("SMTP.php");
require("header.php");
$masseurs = DB::query("SELECT * FROM users WHERE company_id=%i", $user['company_id']);

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$update = DB::query("UPDATE reservations SET masseur_id=%i WHERE id=%i", $_POST['masseur'], $_POST['id']);
	header("Location: reservations.php");
	exit;
}
?>
            <div class="content">
                <div class="content-nav">
                    <a href="index.php" class="nav-item">Strona główna</a>
                    <a href="reservations.php" class="nav-item">Zmiana pracownika</a>
                </div>
                <div class="tiles">
                    <p class="title">
                        <i class="fas fa-cog"></i>
                        Zmiana pracownika
                    </p>
                </div>
                <div class="content-profile">
							<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
								<label for="date">
									Wybierz nowego pracownika dla tej rezerwacji:
									<select name="masseur">
									<?php
									foreach($masseurs as $m)
										echo "<option value='".$m['id']."'>".$m['name']." ".$m['surname']."</option>";
									?>
									</select>
								</label>
								<input type="hidden" name="id" value="<?=$_GET['id']?>">
								<button type="submit" class="button">Zmień pracownika</a>
							</form>
                </div>
            </div>
        </main>
        <div class="go-up"></div>
    </div>  

</body>

</html>