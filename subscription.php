<?php
if(isset($_GET['session'])){
	session_id($_GET['session']);
	session_start();
}

require("header.php");

$company = DB::queryFirstRow("SELECT * FROM companies WHERE owner_id=%i", $_SESSION['id']);

$dotpay = [
	"api_version" => "next",
	"id" => $dotpay_id,
	"amount" => "100.00",
	"currency" => "PLN",
	"description" => "Opłata miesięczna za konto firmowe w serwisie masujmnie.pl",
	"url" => "https://masujmnie.pl/app/subscription.php?session=".session_id(),
	"type" => "0",
	"control" => $dotpay_control,
	"buttontext" => "Wróć na platformę masujmnie.pl",
	"urlc" => "https://masujmnie.pl/app/dotpay-receiver.php",
	"firstname" => $user['name'],
	"lastname" => $user['surname'],
	"email" => $user['email'],
	"lang" => "pl",
];
ksort($dotpay);
$paramsList = implode(';', array_keys($dotpay));
$dotpay['paramsList'] = $paramsList;
ksort($dotpay);
$json = json_encode($dotpay, JSON_UNESCAPED_SLASHES);
$chk = hash_hmac('sha256', $json, $dotpay_pin, false);
$dotpay['chk'] = $chk;

$dotpay2 = [
	"api_version" => "next",
	"id" => $dotpay_id,
	"amount" => "300.00",
	"currency" => "PLN",
	"description" => "Opłata trzy miesięczna za konto firmowe w serwisie masujmnie.pl",
	"url" => "https://masujmnie.pl/app/subscription.php?session=".session_id(),
	"type" => "0",
	"control" => $dotpay_control,
	"buttontext" => "Wróć na platformę masujmnie.pl",
	"urlc" => "https://masujmnie.pl/app/dotpay-receiver.php",
	"firstname" => $user['name'],
	"lastname" => $user['surname'],
	"email" => $user['email'],
	"lang" => "pl",
];
ksort($dotpay2);
$paramsList = implode(';', array_keys($dotpay2));
$dotpay2['paramsList'] = $paramsList;
ksort($dotpay2);
$json = json_encode($dotpay2, JSON_UNESCAPED_SLASHES);
$chk = hash_hmac('sha256', $json, $dotpay_pin, false);
$dotpay2['chk'] = $chk;

$dotpay3 = [
	"api_version" => "next",
	"id" => $dotpay_id,
	"amount" => "1200.00",
	"currency" => "PLN",
	"description" => "Opłata roczna za konto firmowe w serwisie masujmnie.pl",
	"url" => "https://masujmnie.pl/app/subscription.php?session=".session_id(),
	"type" => "0",
	"control" => $dotpay_control,
	"buttontext" => "Wróć na platformę masujmnie.pl",
	"urlc" => "https://masujmnie.pl/app/dotpay-receiver.php",
	"firstname" => $user['name'],
	"lastname" => $user['surname'],
	"email" => $user['email'],
	"lang" => "pl",
];
ksort($dotpay3);
$paramsList = implode(';', array_keys($dotpay3));
$dotpay3['paramsList'] = $paramsList;
ksort($dotpay3);
$json = json_encode($dotpay3, JSON_UNESCAPED_SLASHES);
$chk = hash_hmac('sha256', $json, $dotpay_pin, false);
$dotpay3['chk'] = $chk;

?>
            <div class="content">
                <div class="content-nav">
                    <a href="index.php" class="nav-item">Strona główna</a>
                    <a href="subscription.php" class="nav-item">Abonament</a>
                </div>
                <div class="greet">
                    <p class="greet-text">Abonament</p>
                    <span style="width: 100%; height: 1px; margin-top: 20px; background-color: #ececec;">
                </div>				
                <div class="tiles">
                    <p class="title">
                        <i class="fas fa-cog"></i>
                        Opcje
                    </p>
                </div>
				<span><b>Konto aktywne do:</b> <?=$company['activated_to']?><br />
				<form method="POST" action="https://ssl.dotpay.pl/test_payment/">
					<input type="hidden" name="api_version" value="<?=$dotpay['api_version']?>">
					<input type="hidden" name="id" value="<?=$dotpay['id']?>">
					<input type="hidden" name="amount" value="<?=$dotpay['amount']?>">
					<input type="hidden" name="currency" value="<?=$dotpay['currency']?>">
					<input type="hidden" name="description" value="<?=$dotpay['description']?>">
					<input type="hidden" name="url" value="<?=$dotpay['url']?>">
					<input type="hidden" name="urlc" value="<?=$dotpay['urlc']?>">
					<input type="hidden" name="control" value="<?=$dotpay['control']?>">
					<input type="hidden" name="firstname" value="<?=$dotpay['firstname']?>">
					<input type="hidden" name="lastname" value="<?=$dotpay['lastname']?>">
					<input type="hidden" name="email" value="<?=$dotpay['email']?>">
					<input type="hidden" name="lang" value="<?=$dotpay['lang']?>">
					<input type="hidden" name="type" value="<?=$dotpay['type']?>">
					<input type="hidden" name="buttontext" value="<?=$dotpay['buttontext']?>">
					<input type="hidden" name="chk" value="<?=$dotpay['chk']?>">
					<input type="submit" class="button" style="border:none;margin:1rem 0" value="Przedłuż konto o miesiąc">
				</form>
				<form method="POST" action="https://ssl.dotpay.pl/test_payment/">
					<input type="hidden" name="api_version" value="<?=$dotpay2['api_version']?>">
					<input type="hidden" name="id" value="<?=$dotpay2['id']?>">
					<input type="hidden" name="amount" value="<?=$dotpay2['amount']?>">
					<input type="hidden" name="currency" value="<?=$dotpay2['currency']?>">
					<input type="hidden" name="description" value="<?=$dotpay2['description']?>">
					<input type="hidden" name="url" value="<?=$dotpay2['url']?>">
					<input type="hidden" name="urlc" value="<?=$dotpay2['urlc']?>">
					<input type="hidden" name="control" value="<?=$dotpay2['control']?>">
					<input type="hidden" name="firstname" value="<?=$dotpay2['firstname']?>">
					<input type="hidden" name="lastname" value="<?=$dotpay2['lastname']?>">
					<input type="hidden" name="email" value="<?=$dotpay2['email']?>">
					<input type="hidden" name="lang" value="<?=$dotpay2['lang']?>">
					<input type="hidden" name="type" value="<?=$dotpay2['type']?>">
					<input type="hidden" name="buttontext" value="<?=$dotpay2['buttontext']?>">
					<input type="hidden" name="chk" value="<?=$dotpay2['chk']?>">
					<input type="submit" class="button" style="border:none;margin-bottom:1rem" value="Przedłuż konto o 3 miesiące">
				</form>
				<form method="POST" action="https://ssl.dotpay.pl/test_payment/">
					<input type="hidden" name="api_version" value="<?=$dotpay3['api_version']?>">
					<input type="hidden" name="id" value="<?=$dotpay3['id']?>">
					<input type="hidden" name="amount" value="<?=$dotpay3['amount']?>">
					<input type="hidden" name="currency" value="<?=$dotpay3['currency']?>">
					<input type="hidden" name="description" value="<?=$dotpay3['description']?>">
					<input type="hidden" name="url" value="<?=$dotpay3['url']?>">
					<input type="hidden" name="urlc" value="<?=$dotpay3['urlc']?>">
					<input type="hidden" name="control" value="<?=$dotpay3['control']?>">
					<input type="hidden" name="firstname" value="<?=$dotpay3['firstname']?>">
					<input type="hidden" name="lastname" value="<?=$dotpay3['lastname']?>">
					<input type="hidden" name="email" value="<?=$dotpay3['email']?>">
					<input type="hidden" name="lang" value="<?=$dotpay3['lang']?>">
					<input type="hidden" name="type" value="<?=$dotpay3['type']?>">
					<input type="hidden" name="buttontext" value="<?=$dotpay3['buttontext']?>">
					<input type="hidden" name="chk" value="<?=$dotpay3['chk']?>">
					<input type="submit" class="button" style="border:none;margin-bottom:1rem" value="Przedłuż konto o rok">
				</form>				
				</span><br />