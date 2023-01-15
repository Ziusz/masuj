<?php
require("header.php");

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['data_create'])){
	$category = trim($_POST['category']);
	$name = trim($_POST['name']);
	$price = trim($_POST['price']);
	$duration = trim($_POST['duration']);
	
	if(!empty($category) && !empty($name) && !empty($price) && !empty($duration)){
		DB::insert('services', array(
			'masseur_id' => $_SESSION['id'],
			'category' => $category,
			'name' => $name,
			'price' => $price,
			'duration' => $duration
		));	
		header("Location: company-profile.php");
		exit;
	} else {
		echo "Wprowadź wszystkie dane w formularzu!";
	}
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
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form">						
                        <label for="category">
                            <span>Kategoria usługi</span><br />
                            <input class="input" type="text" id="category" name="category" placeholder="Fizjoterapia" required>
                        </label>
                        <label for="name">
                            <span>Nazwa usługi</span><br />
                            <input class="input" type="text" id="name" name="name" placeholder="Terapia mięśnia prostego" required>
                        </label>						
                        <label for="price">
                            <span>Cena usługi (PLN)</span><br />
                            <input class="input" type="number" id="price" name="price" placeholder="39,99" step="0.01" required>
                        </label>
                        <label for="duration">
                            <span>Czas trwania usługi (w minutach)</span><br />
                            <input class="input" type="text" id="duration" name="duration" placeholder="45" required>
                        </label>					
                        <button type="submit" class="btn" name="data_create">Stwórz usługę</button>
                    </form>
                </div>
            </div>
        </main>
        <div class="go-up"></div>
    </div>  

</body>

</html>