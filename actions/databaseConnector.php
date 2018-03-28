<?php
// Does Querys and returns the JSON
class databaseConnector {

    private $server = "localhost";  // Defaults for the server. It's public so it doesn't really matter.
    private $username = "supremeSnatcher";
    private $password = "snatch";
    private $database = "brody_mc_media";
    private $connection;

    public function databaseConnector(){

        $this->connection =  new mysqli( $this->server, $this->username, $this->password, $this->database );

        if($this->connection->connect_errno) {
            echo "Failed to connect to MySQL: " . $this->connection->connect_errno;
            $this->_isConnected = false;
        } else {
            $this->_isConnected = true;
			$this->connection->set_charset('utf8');
            $this->query("SET time_zone = 'America/New_York'" );
        }
    }

    private function query($query) {
        $rows = array();
        if(is_object($result = $this->connection->query($query))){
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }

            $result->free();
        }

        return $rows;
    }

    // ------------------------- Start Fetchable Functions ----------------------------------------------

    // public function getAllStoreItemTables($modifier){
    //     if($modifier == "All") {
    //         $query = "
    //             SELECT * FROM storeitems;
    //         ";
    //     } else if($modifier == "Premium") {
    //         $query = "
    //             SELECT * FROM storeitems;
    //             WHERE isPremium = '1';
    //         ";  
    //     } else {
    //         $query = "
    //             SELECT * FROM storeitems
    //             WHERE Category LIKE '%{$modifier}%';
    //         ";
    //     }

    //     return $this->query($query);
    // }

    public function getAllStoreItemTables($modifier) {
        $query = "
            SOME TEXT
        ";

        return $this->query($query);
    }
}
?>