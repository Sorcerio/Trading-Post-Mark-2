<?php
// Does Querys and returns the JSON
class databaseConnector {

    private $server = "localhost";  // Defaults for the server. This code is public, so it's *highly* recommended you change these.
    private $username = "tradingPostUser";
    private $password = "tradingPostUser";
    private $database = "trading_post";
    private $connection;

    public function databaseConnector() {

        $this->connection = new mysqli($this->server, $this->username, $this->password, $this->database);

        if($this->connection->connect_errno) {
            echo "Failed to connect to MySQL: ".$this->connection->connect_errno;
            $this->_isConnected = false;
        } else {
            $this->_isConnected = true;
			$this->connection->set_charset('utf8');
            $this->query("SET time_zone = 'America/New_York'");
        }
    }

    private function query($query) {
        try {
            $rows = array();

            if(is_object($result = $this->connection->query($query))) {
                while ($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }

                $result->free();
            }

            return $rows;
        } catch (MyException $e) {
            // If the object query fails
            return NULL;
        }
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

    public function getMostRecentListings() {
        $query = "
            SELECT * FROM trading_post.listings
        ";

        // $query = "
        //     SELECT * FROM trading_post.listings
        //     ORDER BY date DESC
        //     LIMIT 0,5;
        // ";

        return $this->query($query);
    }
}
?>