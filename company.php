<?php
require("header.php");

$company = DB::queryFirstRow("SELECT * FROM companies WHERE owner_id=%i", $_SESSION['id']);
$users = DB::query("SELECT * FROM users WHERE company_id=%i", $company['id']);

if(isset($_GET['accept'])){
	$update = DB::query("UPDATE users SET confirmed_at=%t WHERE id=%i", DB::sqleval("NOW()"), $_GET['accept']);
	header("Location: company.php");
	exit;
}

if(isset($_GET['degrade'])){
	$update = DB::query("UPDATE users SET role=%s WHERE id=%i", "Masażysta", $_GET['degrade']);
	header("Location: company.php");
	exit;
}

if(isset($_GET['upgrade'])){
	$update = DB::query("UPDATE users SET role=%s WHERE id=%i", "Kierownik", $_GET['upgrade']);
	header("Location: company.php");
	exit;
}

if(isset($_GET['delete'])){
	$drop = DB::query("DELETE from users WHERE id=%i", $_GET['delete']);
	header("Location: company.php");
	exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delayForm'])){
	$update = DB::query("UPDATE companies SET cycle=%i, delay=%i WHERE id=%i", $_POST['cycle'], $_POST['delay'], $company['id']);
	header("Location: company.php");
	exit;
}
?>
            <div class="content">
                <div class="content-nav">
                    <a href="index.php" class="nav-item">Strona główna</a>
                    <a href="company.php" class="nav-item">Zarządzanie firmą</a>
                </div>
                <div class="greet">
                    <p class="greet-text">Zarządzanie firmą</p>
                    <span style="width: 100%; height: 1px; margin-top: 20px; background-color: #ececec;">
                </div>				
                <div class="tiles">
                    <p class="title">
                        <i class="fas fa-cog"></i>
                        Opcje
                    </p>
                </div>
				<span><b>Nazwa firmy:</b> <?=$company['name']?></span><br />
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form">
					Ustaw minimalny czas złożenia rezerwacji przed planowaną wizytą:
					<select name="delay" style="display:block;padding:.5rem;width:100%;margin-top:.5rem">
						<option value="3" <?php if($company['delay'] == "3") echo 'selected'?>>3 godziny</option>
						<option value="6" <?php if($company['delay'] == "6") echo 'selected'?>>6 godzin</option>
						<option value="12" <?php if($company['delay'] == "12") echo 'selected'?>>12 godzin</option>
						<option value="24" <?php if($company['delay'] == "24") echo 'selected'?>>24 godziny</option>
						<option value="48" <?php if($company['delay'] == "48") echo 'selected'?>>48 godzin</option>
					</select>
					<br />
					Ustaw czas odstępu pomiędzy usługami (w minutach):
					<input type="number" class="input" style="display:block;padding:.5rem;width:100%;margin-top:.5rem" name="cycle" value=<?=$company['cycle']?>>
					<br />
					<input type="submit" class="button" style="margin:1rem 0;border:none;" value="Wyślij" name="delayForm">
				</form>
                <div class="content-users">
                    <div class="search-bar">
                        <form>
                            <div class="search-input">
                                <input class="search-bar" id="search-bar" placeholder="Wyszukaj użytkownika..."> 
                                <i class="fas fa-search"></i>
                            </div>
                          
                        </form>
                    </div>
                    <div class="options">
                        <a href="user-add.php" class="button add-user">Dodaj</a>
                    </div>
                    <div class="table-content">
                        <table>
							<thead>
								<tr>
									<th>ID</th>
									<th>Imię</th>
									<th>Nazwisko</th>
									<th>Data urodzenia</th>
									<th>E-mail</th>
									<th>Numer telefonu</th>
									<th>Miasto</th>
									<th>Rola</th>
									<th></th>
								</tr>
							</thead>
							<tbody id="users">
							<?php
							foreach($users as $u){
								echo "<tr>";
								echo "<td>".$u['id']."</td>";
								echo "<td>".$u['name']."</td>";
								echo "<td>".$u['surname']."</td>";
								echo "<td>".$u['birth_date']."</td>";
								echo "<td>".$u['email']."</td>";
								echo "<td>".$u['tel']."</td>";
								echo "<td>".$u['city']."</td>";
								echo "<td>".$u['role']."</td>";
								echo "<td><span style='padding: 1rem 0;'><a href='user-edit.php?id=".$u['id']."' class='button edit-user'>Edytuj</a>";						
								echo "</span></td>";
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
    $("#users tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
</html>