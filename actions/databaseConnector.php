<?php
// Does Querys and returns the JSON
class databaseConnector {

    // Server connection parameters
    private $server = "localhost";  // Defaults for the server. This code is public, so it's *highly* recommended you change these.
    private $username = "tradingPostUser";
    private $password = "tradingPostUser";
    private $database = "trading_post";
    private $connection;

    // PHP 7 Compliant Constructor
    public function __construct() {
        // Connect to the MySQL server
        $this->connection = new mysqli($this->server, $this->username, $this->password, $this->database);

        // Check for a connection error
        if($this->connection->connect_errno) {
            // There was an error, Report it
            echo "Failed to connect to MySQL: ".$this->connection->connect_errno;

            // Label connection as failed
            $this->_isConnected = false;
        } else {
            // There was no error
            // Label connection as success
            $this->_isConnected = true;

            // Run initial time zone query
			$this->connection->set_charset('utf8');
            $this->query("SET time_zone = 'America/New_York'");
        }
    }

    // Constructor call for use by child classes
    public function databaseConnector() {
        // Call Constructor
        self::__construct();
    }

    // Calls a Query to the MySQL Server connected to this object
    private function query($query) {
        // Error catch
        try {
            // Creates empty array for returned data
            $rows = array();

            // Checks to see if an object was returned successfully
            if(is_object($result = $this->connection->query($query))) {
                // Move object parts to the data rows
                while ($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }

                // Release the results from memory
                $result->free();
            }

            // Return collected data rows
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
        // Build query
        $query = "
            SELECT * FROM trading_post.listings
            ORDER BY date DESC
            LIMIT 0,5;
        ";

        // Request and return data from query
        return $this->query($query);
    }
}
?>