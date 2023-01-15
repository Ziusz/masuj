<?php
require("header.php");

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rate'])){
	if($_POST['rating'] != 0){
		$update = DB::query("UPDATE reservations SET rating=%i, comment=%s WHERE id=%i", $_POST['rating'], $_POST['comment'], $_POST['id']);
		header("Location: your-reservations.php");
		exit;
	}
	else
		echo "Wybierz ocenę przed wysłaniem opinii!";
}
?>
            <div class="content">
                <div class="content-nav">
                    <a href="index.php" class="nav-item">Strona główna</a>
                    <a href="#" class="nav-item">Oceń wizytę</a>
                </div>
                <div class="greet">
                    <p class="greet-text">Oceń wizytę!</p>
                    <span style="width: 100%; height: 1px; margin-top: 20px; background-color: #ececec;">
                </div>
                <div class="stars">
                    <div class="row">
                        <div class="stars-content">
						<span style="float:left;margin-top:3px;">Oceń usługę:</span>
						<form method="POST" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
                            <?php
									for($i=5;$i>0;$i--){
										if(isset($_GET['rate']) && $i <= $_GET['rate'])
											echo "<a href='?rate=".$i."&id=".$_GET['id']."'><i class='fas fa-star' style='color: #ffd700;'></i></a>";
										else
											echo "<a href='?rate=".$i."&id=".$_GET['id']."'><i class='fas fa-star'></i></a>";
									}					
							?>
                        </div>
						<input type="hidden" name="id" value="<?=$_GET['id']?>">
						<input type="hidden" name="rating" value="<?=$_GET['rate']?>">
						<br /><br /><textarea rows="8" cols="35" name="comment" style="resize:none;padding:0.5rem;font-family:Roboto;" placeholder="Dodaj komentarz"></textarea>
                        <br /><br /><button type="submit" class="button" style="border:none;" name="rate">Prześlij</button>
						<form>
                    </div>
                </div>
        </main>
    </div>  
</body>
</html>