<?php
require("header.php");

$users = DB::query("SELECT * FROM users");

if(isset($_GET['edit'])){
	
}

if(isset($_GET['accept'])){
	$update = DB::query("UPDATE users SET confirmed_at=%t WHERE id=%i", DB::sqleval("NOW()"), $_GET['accept']);
	header("Location: users.php");
	exit;
}

if(isset($_GET['degrade'])){
	$update = DB::query("UPDATE users SET role=%s WHERE id=%i", "Masażysta", $_GET['degrade']);
	header("Location: users.php");
	exit;
}

if(isset($_GET['upgrade'])){
	$update = DB::query("UPDATE users SET role=%s WHERE id=%i", "Kierownik", $_GET['upgrade']);
	header("Location: users.php");
	exit;
}

if(isset($_GET['ban'])){
	$update = DB::query("UPDATE users SET blocked=%i WHERE id=%i", 1, $_GET['ban']);
	header("Location: users.php");
	exit;
}

if(isset($_GET['unban'])){
	$update = DB::query("UPDATE users SET blocked=%i WHERE id=%i", 0, $_GET['unban']);
	header("Location: users.php");
	exit;
}

if(isset($_GET['delete'])){
	$drop = DB::query("DELETE from users WHERE id=%i", $_GET['delete']);
	header("Location: users.php");
	exit;
}
?>
            <div class="content">
                <div class="content-nav">
                    <a href="index.php" class="nav-item">Strona główna</a>
                    <a href="users.php" class="nav-item">Użytkownicy</a>
                </div>
                <div class="greet">
                    <p class="greet-text">Użytkownicy</p>
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
								if($u['role'] != "Administrator"){
									if($u['blocked'] == 0)
										echo "<a href='?ban=".$u['id']."' class='button delete-user' style='margin-left: 5px;'>Zbanuj</a>";
									elseif($u['blocked'] == 1)
										echo "<a href='?unban=".$u['id']."' class='button delete-user' style='margin-left: 5px;'>Odbanuj</a>";
									echo "<a href='?delete=".$u['id']."' class='button delete-user' style='margin-left: 5px;'>Usuń</a>";
									if($u['role'] == "Kierownik" && $u['confirmed_at'] == NULL)
										echo "<a href='?accept=".$u['id']."' class='button accept-user' style='margin-left: 5px;'>Akceptuj</a>";
									if($u['role'] == "Kierownik" && $u['confirmed_at'] != NULL)
										echo "<a href='?degrade=".$u['id']."' class='button accept-user' style='margin-left: 5px;'>Zdegraduj</a>";
									if($u['role'] == "Masażysta" && $u['confirmed_at'] != NULL)
										echo "<a href='?upgrade=".$u['id']."' class='button accept-user' style='margin-left: 5px;'>Awansuj</a>";
								}								
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