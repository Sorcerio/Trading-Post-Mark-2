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
            // if(is_object($result = $this->connection->query($query))) {
            if(is_object($result = mysqli_query($this->connection,$query))) {
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
            print '<h1>Query Failed. Report this.</h1>';
            return NULL;
        }
    }

    // ------------------------- Start Fetchable Functions ----------------------------------------------
    public function getMostRecentListings() {
        // Build query
        $query = "
            SELECT * FROM trading_post.listing
            ORDER BY listingID DESC
            LIMIT 0,5;
        ";

        // Request and return data from query
        return $this->query($query);
    }

    public function createNewListing($title,$desc,$quantity,$price,$barter,$account) {
        // Pull date
        $date = date('Y-m-d');

        // Ensure barter has a value
        if($barter == NULL) {
            $barter = 0;
        }
        
        // Build query
        $query = "
            INSERT INTO trading_post.listing (accountID,date,title,description,quantity,price,barter)
            VALUES ($account,'$date','$title','$desc',$quantity,$price,$barter);
        ";

        // Execute the Query
        $this->query($query);

        // Request and return data from query
        return mysqli_insert_id($this->connection);
    }

    public function addImageToListing($id,$path) {
        // Build query
        $query = "
            INSERT INTO trading_post.image (listingID,path)
            VALUES ($id,'$path');
        ";

        // Execute query
        $this->query($query);
    }

    public function getImageByListingId($id) {
        // Build query
        $query = "
            SELECT * FROM trading_post.image
            WHERE listingID = $id;
        ";

        // Request and return data from query
        return $this->query($query);
    }

    public function getListingById($id) {
        // Build query
        $query = "
            SELECT * FROM trading_post.listing
            WHERE listingID = $id;
        ";

        // Request and return data from query
        return $this->query($query);
    }

    public function getAllListingData($page, $limit) {
        // Calculate offset
        $offset = (($page-1)*$limit);

        // Build query
        $query = "
            SELECT * FROM trading_post.listing
            ORDER BY listingID DESC
            LIMIT $offset,$limit;
        ";

        // Request and return data from query
        return $this->query($query);
    }

    public function getAllListingLinks($limit) {
        // Build query
        $query = "
            SELECT listingID FROM trading_post.listing
            ORDER BY listingID DESC;
        ";

        // Request and return data from query
        $data = $this->query($query);

        // Create Links
        $links = array();
        $totalPages = ceil(((count($data)-$limit)/$limit)+1);
        for($i = 0; $i < $totalPages; $i++) {
            // Create package
            $package = array();

            // Build Package
            $package['page'] = $i+1;
            $package['link'] = "browse.php?page=".($i+1)."&limit=".$limit;

            // Add Package to Links
            $links[$i] = $package;
        }

        // Return 
        return $links;
    }

    public function getAllListingData_Search($page, $limit, $search) {
        // Calculate offset
        $offset = (($page-1)*$limit);

        // Build query
        $query = "
            SELECT * FROM trading_post.listing
            WHERE title LIKE '%$search%'
                OR description LIKE '%$search%'
            ORDER BY listingID DESC
            LIMIT $offset,$limit;
        ";

        // Request and return data from query
        return $this->query($query);
    }

    public function getAllListingLinks_Search($limit, $search) {
        // Build query
        $query = "
            SELECT listingID FROM trading_post.listing
            WHERE title LIKE '%$search%'
                OR description LIKE '%$search%'
            ORDER BY listingID DESC;
        ";

        // Request and return data from query
        $data = $this->query($query);

        // Create Links
        $links = array();
        $totalPages = ceil(((count($data)-$limit)/$limit)+1);
        for($i = 0; $i < $totalPages; $i++) {
            // Create package
            $package = array();

            // Build Package
            $package['page'] = $i+1;
            $package['link'] = "browse.php?page=".($i+1)."&limit=".$limit;

            // Add Package to Links
            $links[$i] = $package;
        }

        // Return 
        return $links;
    }

    public function createAccount($name,$password,$email,$ip) {
        // Hash password
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Build query
        $query = "
            INSERT INTO trading_post.account (name,password,email,lastIPAddress)
            VALUES ('$name','$password','$email','$ip');
        ";

        // Retrun boolean
        return $this->query($query);
    }

    public function checkIfUserTaken($name) {
        // Build query
        $query = "
            SELECT name FROM trading_post.account
            WHERE name LIKE '$name';
        ";

        // Retrieve Query
        $data = $this->query($query);

        // Retrun boolean
        return !(empty($data));
    }

    public function tryLoginInfo($id,$password) {
        // Build query
        $query = "
            SELECT * FROM trading_post.account
            WHERE accountID = $id;
        ";

        // Ready Valid
        $isValid = false;

        // Give it a try
        try {
            // Retrieve Query
            $data = $this->query($query);

            // Get Password Info
            $info = password_get_info($data[0]['password']);

            // Check if account exists
            if(!empty($data[0])) {
                // If it's not empty
                // Check if Name and Password match
                if($info['algoName'] == "unknown") {
                    // Not a hashed password
                    if($data[0]['password'] == $password) {
                        $isValid = true;
                    }
                } else {
                    // A hashed password
                    if(password_verify($password, $data[0]['password'])) {
                        $isValid = true;
                    }
                }
            } // On fail, not valid
        } catch (Exception $e) {
            $isValid = false;
        }

        // Return boolean
        return $isValid;
    }

    public function getAccountIdByName($name) {
        // Build query
        $query = "
            SELECT accountID FROM trading_post.account
            WHERE name LIKE '$name';
        ";

        // Retrun boolean
        return $this->query($query)[0]['accountID'];
    }

    public function getAccountInfoFromId($id) {
        // Build query
        $query = "
            SELECT name,email FROM trading_post.account
            WHERE accountID = $id;
        ";

        // Retrun boolean
        return $this->query($query)[0];
    }

    public function getListingsByAccount($id) {
        // Build query
        $query = "
            SELECT * FROM trading_post.listing
            WHERE accountID = $id;
        ";

        // Retrun boolean
        return $this->query($query);
    }

    public function changeUserPassword($accountId,$oldPass,$newPass) {
        // Build compare password query
        $queryA = "
            SELECT password FROM trading_post.account
            WHERE accountID = $accountId;
        ";

        // Execute compare password query
        $compPass = $this->query($queryA)[0]['password'];

        // Check if passwords match
        $isValid = $this->tryLoginInfo($accountId,$oldPass);

        // Check if retrieved password and old password are the same
        $allSet = false;
        if($isValid) {
            // Toggle
            $allSet = true;

            // Hash new password
            $newPass = password_hash($newPass, PASSWORD_DEFAULT);

            // Build reassign password query
            $queryB = "
                UPDATE trading_post.account
                SET password = '$newPass'
                WHERE accountID = $accountId;
            ";

            // Execute reassign password query
            $this->query($queryB);
        }

        // Return boolean
        return $allSet;
    }

    public function deleteAccount($accountId,$password) {
        // Build compare password query
        $queryA = "
            SELECT password FROM trading_post.account
            WHERE accountID = $accountId;
        ";

        // Execute compare password query
        $compPass = $this->query($queryA)[0]['password'];

        // Check if passwords match
        $isValid = $this->tryLoginInfo($accountId,$password);

        // Check if retrieved password and old password are the same
        $allSet = false;
        if($isValid) {
            // Toggle
            $allSet = true;

            // Build reassign password query
            $queryB = "
                UPDATE trading_post.account
                SET name = 'DELETED', password = 'DELETED'
                WHERE accountID = $accountId;
            ";

            // Execute reassign password query
            $this->query($queryB);
        }

        // Return boolean
        return $allSet;
    }
}
?>