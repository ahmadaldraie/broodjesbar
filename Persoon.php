<?php
    declare(strict_types=1);

    require_once 'DBConfig.php';

    class Persoon {
        private int $id;
        private string $familienaam;
        private string $voornaam;
        private string $email;

        public function getId(): int { return $this->id; } 
        public function getFamilienaam(): string { return $this->familienaam; }
        public function getVoornaam(): string { return $this->voornaam; }
        public function getFullname(): string { return "$this->voornaam $this->familienaam"; }
        public function getEmail(): string { return $this->email; }

        public function zoekEenKlant($klant): bool {
            $sql = 'select * from klanten_broodjesbar where klantID = :klant or email = :klant';
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array('klant' => $klant));
            $dbh = null;
            $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($resultSet) > 0) {
                $this->id = (int) $resultSet[0]['klantID'];
                $this->voornaam = $resultSet[0]['voornaam'];
                $this->familienaam = $resultSet[0]['achternaam'];
                $this->email = $resultSet[0]['email'];
                return true;
            }
            else return false;
        }

        public function newKlant(string $voornaam, string $achternaam, string $email) {
            $sql = 'insert into klanten_broodjesbar (voornaam,achternaam,email) values (:voornaam,:achternaam,:email)';
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array('voornaam' => $voornaam, 'achternaam' => $achternaam, 'email' => $email));
            $dbh = null;
        }
    }
    
?>