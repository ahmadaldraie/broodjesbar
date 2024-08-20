<?php
    declare(strict_types=1);

    require_once 'DBConfig.php';
    class Bestelling {
        private int $id;
        private int $broodjeId;
        private int $klantId;
        private string $afhalingsmoment;
        private int $statusId;

        public function getId(): int { return $this->id; } 
        public function getBroodjeId(): int { return $this->broodjeId; }
        public function getKlantId(): int { return $this->klantId; }
        public function getAfhalingsmoment(): string { return $this->afhalingsmoment; }
        public function getStatusId(): int { return $this->statusId; }

        public function setBroodjeId($broodjeId) { $this->broodjeId = $broodjeId; }
        public function setKlantId($klantId) { $this->klantId = $klantId; }
        public function setAfhalingsmoment(float $afhalingsmoment) { $this->afhalingsmoment = $afhalingsmoment; }
        public function setStatusId($statusId) { $this->statusId = $statusId; }

        public function newBestelling(int $broodjeId, int $klantId, string $afhalingsmoment) {
            $sql = 'insert into bestellingen_broodjesbar (broodjeID,klantID,afhalingsmoment,statusID) values (?, ?, ?, ?)';
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $stmt = $dbh->prepare($sql);
            $date = date("Y-m-d H:i:s", strtotime($afhalingsmoment));
            $stmt->execute(array($broodjeId, $klantId, $date, 1));
            $dbh = null;
        }

        public function getAlleBestellingen(): array {
            $bestellingen = array();
            $sql = 'select * from bestellingen_broodjesbar order by afhalingsmoment';
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $resultSet = $dbh->query($sql);
            $dbh = null;
            foreach ($resultSet as $rij) {
                array_push($bestellingen, array('bestelId' => $rij['bestelID'], 'klantId' => $rij['klantID'], 'broodjeId' => $rij['broodjeID'], 'statusId' => $rij['statusID']));
            }
            return $bestellingen;
        }

        public function bestellingBijwerken(int $bestelId, int $statusId) {
            $sql = 'update bestellingen_broodjesbar set statusID = :statusId where bestelID = :bestelId';
            $dbh = new PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array('statusId' => $statusId, 'bestelId' => $bestelId));
            $dbh = null;
        }

    }
?>