<?php
    // Class Function: Creates a new listing with the applied information and returns the Listing Id

    // Includes the database connector if nothing else has
    include_once 'databaseConnector.php';

    // Builds the class extending the database connector
    class createAccountApi extends databaseConnector {

        // Creates a new listing with supplied information
        public function createAccountPHP($name,$password,$email,$ip) {
            // Connects to the database connector to retrieve query data
            parent::databaseConnector();

            // Hash Password
            // ...

            // Execute the submission query and return listing id
            return $this->createAccount($name,$password,$email,$ip);
        }

        // Checks to see if the username has already been put into the database
        // True = Taken, False = Not Taken
        public function checkIfUserTakenPHP($name) {
            // Connects to the database connector to retrieve query data
            parent::databaseConnector();

            // Execute the submission query and return listing id
            return $this->checkIfUserTaken($name);
        }
    }

    // Creates the initial object that methods can be called from
    $node = new createAccountApi();
?>