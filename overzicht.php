<?php
declare(strict_types=1);

session_start();

require_once 'Broodje.php';
require_once 'Persoon.php';
require_once 'Bestelling.php';

if (!isset($_SESSION['gebruiker']) && !isset($_GET['gebruiker'])) {
    $_SESSION['gebruiker'] = 'klant';
}
else if (isset($_GET['gebruiker'])) {
    $_SESSION['gebruiker'] = $_GET['gebruiker'];
}

$bestelling = new Bestelling();
if (isset($_GET['action']) && $_GET['action'] === 'bijwerkStatus') {
    $bestelling->bestellingBijwerken((int)$_GET['bestelId'], (int)$_GET['statusId']);
}

$bestellingen = $bestelling->getAlleBestellingen();
?>

<!DOCTYPE html>
<html lang="nl">
    <head>
        <meta charset="utf-8">
        <title>Broodjesbar overzicht</title>
        <link href="broodjesbar.css" rel="stylesheet">
    </head>
    <body>
        <header class="clearFix">
            <img src="img/logo.png" alt="Broodjesbar">
            <nav class="top_menu">
                <ul>
                    <li><a href="bestellen.php">Bestellen</a></li>
                    <li><a href="overzicht.php">Overzicht</a></li>
                    <?php if($_SESSION['gebruiker'] === 'klant') { ?>
                    <li>Surfen als <a href="overzicht.php?gebruiker=verkoper">Verkoper</a></li>
                    <?php } else { ?>
                    <li>Surfen als <a href="overzicht.php?gebruiker=klant">klant</a></li>
                    <?php } ?>
                </ul>
            </nav>
        </header>
        <div class="container">
            <table class="overzicht">
                <thead>
                    <tr>
                        <th>Klant naam</th>
                        <th>Broodje naam</th>
                        <th>Status</th>
                        <th>Status bijwerken</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($bestellingen as $item) { 
                    $klant = new Persoon();
                    $klant->zoekEenKlant((int) $item['klantId']);
                    $broodje = new Broodje();
                    $broodje->zoekEenBroodje((int) $item['broodjeId']);
                    ?>
                    <tr>
                        <td><?php echo $klant->getFullname(); ?></td>
                        <td><?php echo $broodje->getNaam(); ?></td>
                        <?php
                        switch ($item['statusId']) {
                            case 1 : print('<td>Besteld</td>'); break;
                            case 2 : print('<td>Afgemaakt</td>'); break;
                            case 3 : print('<td>Afgehaald</td>'); break;
                        }
                        if($_SESSION['gebruiker'] === 'verkoper') {
                            if($item['statusId'] == 1) {    
                        ?>
                            <td><a href="overzicht.php?action=bijwerkStatus&statusId=2&bestelId=<?php echo $item['bestelId']; ?>">Klaar</a></td>
                        <?php } else print('<td></td>'); }
                        else {
                            if($item['statusId'] == 2) { ?>
                                <td><a href="overzicht.php?action=bijwerkStatus&statusId=3&bestelId=<?php echo $item['bestelId']; ?>">Afhalen</a></td>
                            <?php }
                            else 
                                print('<td></td>');
                        }
                        ?>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <footer>
            <p>&copy; Copyright Broodjesbar</p>
        </footer>
    </body>
</html>