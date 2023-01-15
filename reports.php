<?php
require("header.php");

$reservations = DB::query("SELECT * FROM reservations");

if(isset($_GET['report_pdf'])){
	require("tfpdf.php");
	
	$reservation = DB::queryFirstRow("SELECT * FROM reservations WHERE id=%i", $_GET['report_pdf']);
	$client = DB::queryFirstRow("SELECT name, surname FROM users WHERE id=%i", $reservation['client_id']);
	$masseur = DB::queryFirstRow("SELECT name, surname FROM users WHERE id=%i", $reservation['masseur_id']);
	ob_clean();
	$pdf = new tFPDF();
	$pdf->AddPage();
	$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
	$pdf->SetFont('DejaVu','',14);
	$pdf->Multicell(320,8,'ID: '.$reservation['id']);
	$pdf->Multicell(320,8,'Klient: '.$client['name']." ".$client['surname']);
	$pdf->Multicell(320,8,'Masażysta: '.$masseur['name']." ".$masseur['surname']);
	$pdf->Multicell(320,8,'Termin realizacji usługi: '.$reservation['date']);
	$pdf->Multicell(320,8,'Rodzaj usługi: '.$reservation['service_type']);
	$pdf->Multicell(320,8,'Cena usługi: '. $reservation['service_price'].'zł');
	$pdf->Multicell(320,8,'Rodzaj płatności: '.$reservation['payment']);
	$pdf->Multicell(320,8,'Ocena usługi: '.$reservation['rating'].'/5');
	$pdf->Multicell(320,8,'Opinia: '.$reservation['comment']);
	$pdf->Output($_GET['report_pdf'].'.pdf', 'D');
	ob_end_flush(); 
}

if(isset($_GET['report_xls'])){
	require("SimpleXLSXGen.php");
	
	$reservation = DB::queryFirstRow("SELECT * FROM reservations WHERE id=%i", $_GET['report_xls']);
	$client = DB::queryFirstRow("SELECT name, surname FROM users WHERE id=%i", $reservation['client_id']);
	$masseur = DB::queryFirstRow("SELECT name, surname FROM users WHERE id=%i", $reservation['masseur_id']);	
	$data = [
		['ID', "<left>".$reservation['id']."</left>"],
		['Klient', $client['name']." ".$client['surname']],
		['Masażysta', $masseur['name']." ".$masseur['surname']],
		['Termin realizacji usługi', "<left>".$reservation['date']."</left>"],
		['Rodzaj usługi', $reservation['service_type']],
		['Cena usługi', $reservation['service_price']."zł"],
		['Rodzaj płatności', $reservation['payment']],
		['Ocena usługi', $reservation['rating']."/5"],
		['Komentarz', $reservation['comment']]
	];
	SimpleXLSXGen::fromArray($data)->downloadAs($_GET['report_xls'].".xlsx");
}

if(isset($_POST['pdf'])){
	require("tfpdf.php");
	$date_start = DateTime::createFromFormat('Y-m-d H:i', $_POST['date_start']." 00:00");
	$date_stop = DateTime::createFromFormat('Y-m-d H:i', $_POST['date_stop']." 23:59");
	$reservations = DB::query("SELECT * FROM reservations WHERE date>=%t and date<=%t", $date_start->format('Y-m-d H:i'), $date_stop->format('Y-m-d H:i'));
	$pdf = new tFPDF();
	foreach($reservations as $reservation){
		ob_clean();
		$client = DB::queryFirstRow("SELECT name, surname FROM users WHERE id=%i", $reservation['client_id']);
		$masseur = DB::queryFirstRow("SELECT name, surname FROM users WHERE id=%i", $reservation['masseur_id']);	
		$pdf->AddPage();
		$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
		$pdf->SetFont('DejaVu','',14);
		$pdf->Multicell(320,8,'ID: '.$reservation['id']);
		$pdf->Multicell(320,8,'Klient: '.$client['name']." ".$client['surname']);
		$pdf->Multicell(320,8,'Masażysta: '.$masseur['name']." ".$masseur['surname']);
		$pdf->Multicell(320,8,'Termin realizacji usługi: '.$reservation['date']);
		$pdf->Multicell(320,8,'Rodzaj usługi: '.$reservation['service_type']);
		$pdf->Multicell(320,8,'Cena usługi: '. $reservation['service_price'].'zł');
		$pdf->Multicell(320,8,'Rodzaj płatności: '.$reservation['payment']);
		$pdf->Multicell(320,8,'Ocena usługi: '.$reservation['rating'].'/5');
		$pdf->Multicell(320,8,'Opinia: '.$reservation['comment']);
		ob_end_flush(); 
	}
	$pdf->Output('report.pdf', 'D');
	ob_end_flush(); 	
}

if(isset($_POST['xlsx'])){
	require("SimpleXLSXGen.php");
	$date_start = DateTime::createFromFormat('Y-m-d H:i', $_POST['date_start']." 00:00");
	$date_stop = DateTime::createFromFormat('Y-m-d H:i', $_POST['date_stop']." 23:59");
	$reservations = DB::query("SELECT * FROM reservations WHERE date>=%t and date<=%t", $date_start->format('Y-m-d H:i'), $date_stop->format('Y-m-d H:i'));
	$data = [['ID', 'Klient', 'Masażysta', 'Termin realizacji usługi', 'Rodzaj usługi', 'Cena usługi', 'Rodzaj płatności', 'Ocena usługi', 'Komentarz']];
	foreach($reservations as $reservation){
		$client = DB::queryFirstRow("SELECT name, surname FROM users WHERE id=%i", $reservation['client_id']);
		$masseur = DB::queryFirstRow("SELECT name, surname FROM users WHERE id=%i", $reservation['masseur_id']);	
		$data[] = ["<left>".$reservation['id']."</left>", $client['name']." ".$client['surname'], $masseur['name']." ".$masseur['surname'], "<left>".$reservation['date']."</left>", $reservation['service_type'], $reservation['service_price']."zł", $reservation['payment'], $reservation['rating']."/5", $reservation['comment']];
	}
	SimpleXLSXGen::fromArray($data)->downloadAs("report.xlsx");	
}
?>
            <div class="content">
                <div class="content-nav">
                    <a href="index.html" class="nav-item">Strona główna</a>
                    <a href="raports.html" class="nav-item">Raporty</a>
                </div>
                <div class="greet">
                    <p class="greet-text">Raporty</p>
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
                        </form>
                    </div>
						<div>
							<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
								<span>Data początkowa: <input type="date" name="date_start" value="<?=date('Y-m-d')?>" required></span>
								<span>Data końcowa: <input type="date" name="date_stop" value="<?=date('Y-m-d')?>" required></span>
								<button type="submit" class="button add-user" style="border:none; margin: .5rem 0" name="xlsx">RAPORT XLSX</button>
								<button type="submit" class="button add-user" style="border:none; margin: .5rem 0" name="pdf">RAPORT PDF</button>
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
									<th>Rodzaj usługi</th>
									<th>Cena usługi</th>
									<th>Płatność</th>
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
								echo "<td>".$r['service_type']."</td>";
								echo "<td>".$r['service_price']."zł</td>";
								echo "<td>".$r['payment']."</td>";
								echo "<td>".$r['rating']."</td>";
								echo "<td>".$r['status']."</td>";
								echo "<td style='width: 15%'><span style='padding: 1rem 0; display: flex; flex-direction: column; gap: 0.5rem; align-items: center;'><a href='?report_pdf=".$r['id']."' class='button edit-user'>Raport PDF</a><a href='?report_xls=".$r['id']."' class='button delete-user' style='margin-left: 5px;'>Raport XLSX</a>";
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