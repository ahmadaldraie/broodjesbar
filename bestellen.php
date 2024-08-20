<?php
declare(strict_types=1);

require_once 'Broodje.php';
require_once 'Persoon.php';
require_once 'Bestelling.php';

$broodje = new Broodje();
$klant = new Persoon();
$menu = $broodje->getHetMenu();
$besteld = false;

if(isset($_GET['action']) && $_GET['action'] == 'nieuweBestelling') {
    $bestelling = new Bestelling();
    $broodje->zoekEenBroodje($_POST['keuze']);
    if(!$klant->zoekEenKlant($_POST['email'])) {
        $klant->newKlant($_POST['voornaam'], $_POST['familienaam'], $_POST['email']);
        $klant->zoekEenKlant($_POST['email']);
    }
    $bestelling->newBestelling((int) $broodje->getId(),(int) $klant->getId(), $_POST['afhalingsmoment']);
    $besteld = true;
}
?>
<!DOCTYPE html>
<html lang="nl">
    <head>
        <meta charset="utf-8">
        <title>Broodjesbar</title>
        <link href="broodjesbar.css" rel="stylesheet">
    </head>
    <body>
        <header class="clearFix">
            <img src="img/logo.png" alt="Broodjesbar">
            <nav class="top_menu">
                <ul>
                    <li><a href="bestellen.php">Bestellen</a></li>
                    <li><a href="overzicht.php">Overzicht</a></li>
                </ul>
            </nav>
        </header>
        <div class="container">
            <section class="broodjesMenu">
                <div class="top_broodjesMenu">
                    <div class="driehoek_top"></div>
                    <img src="img/broodje1.jpg" alt="broodje foto">
                    <img src="img/broodje2.jpg" alt="broodje foto">
                    <h1>Het menu</h1>
                </div>
                <div class="menuInhoud">
                    <dl>
                        <?php
                        foreach ($menu as $item) { ?>
                        <dt><?php echo $item['naam'] ?></dt>
                        <dd><span class="omschrijving"><?php echo $item['omschrijving'] ?> </span><span class="prijs"><?php echo $item['prijs'] ?> &euro;</span></dd>
                        <?php } ?>
                    </dl>
                </div>
            </section>
            <section class="bestellenForm">
                <h1>Bestel een broodje:</h1>
                <form action="bestellen.php?action=nieuweBestelling" method="post">
                    <label>Uw Keuze: 
                        <select id="keuze" name="keuze">
                            <option value="" selected>Kies een broodje</option>
                            <?php foreach($menu as $item) { ?>
                            <option><?php echo $item['naam'] ?></option>
                            <?php } ?>
                        </select>
                    </label>
                    <div id="persoonsgegevens" hidden>
                        <label>Familienaam: 
                            <input type="text" name="familienaam" placeholder="Uw familienaam" required>
                        </label>
                        <label>Voornaam: 
                            <input type="text" name="voornaam" placeholder="Uw voornaam" required>
                        </label>
                        <label>email: 
                            <input type="email" name="email" placeholder="Uw email" required>
                        </label>
                        <label>Afhalingsmoment: 
                            <input type="datetime-local" name="afhalingsmoment" value="<?php echo date('Y-m-d\TH:i'); ?>" min="<?php echo date('Y-m-d\TH:i', strtotime('+30 minutes')); ?>" required>
                        </label>
                        <input type="submit" value="Bestellen">
                    </div>
                    <script>
                        persoonsgegevens = document.getElementById('persoonsgegevens');
                        keuze = document.getElementById('keuze');
                        keuze.onchange = function () {
                            if (keuze.value != '') {
                                persoonsgegevens.hidden = false;
                            }
                            else persoonsgegevens.hidden = true;
                        }
                    </script>
                </form>
                <?php if ($besteld) {
                    print('<p class="feedback">Uw bestelling wordt verwerkt! Bekijk de status van uw bestelling in de overzicht pagina</p>');
                }
                ?>
            </section>
            <div class="driehoek_bottom"></div>
        </div>
        <footer>
        Disclaimer: Deze website is gemaakt als een opdracht voor de opleiding Full-Stack developer van VDAB
            <p>&copy; Copyright Broodjesbar</p>
        </footer>
    </body>
</html>