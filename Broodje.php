<?php
    declare(strict_types=1);

    require_once 'DBConfig.php';

    class Broodje {
        private int $id;
        private string $naam;
        private string $omschrijving;
        private float $prijs;


        public function getId(): int { return $this->id; } 
        public function getNaam(): string { return $this->naam; }
        public function getOmschrijving(): string { return $this->omschrijving; }
        public function getPrijs(): float { return $this->prijs; }

        public function setNaam($naam) { $this->naam = $naam; }
        public function setOmschrijving($omschrijving) { $this->omschrijving = $omschrijving; }
        public function setPrijs(float $prijs) { $this->prijs = $prijs; }

        public function getHetMenu(): array {
            $menu = array();
            $sql = "select * from broodjes_broodjesbar order by prijs";
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $resultSet = $dbh->query($sql);
            foreach ($resultSet as $rij) {
                array_push($menu, array('id' => $rij['ID'], 'naam' => $rij['Naam'], 'omschrijving' => $rij['Omschrijving'], 'prijs' => $rij['Prijs']));
            }
    
            return $menu;
        }

        public function zoekEenBroodje($broodje) {
            $sql = 'select * from broodjes_broodjesbar where ID = :broodje or Naam = :broodje';
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array('broodje' => $broodje));
            $dbh = null;
            $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->id = (int) $resultSet[0]['ID'];
            $this->naam = $resultSet[0]['Naam'];
            $this->omschrijving = $resultSet[0]['Omschrijving'];
            $this->prijs = (float) $resultSet[0]['Prijs'];
        }
    }
?>