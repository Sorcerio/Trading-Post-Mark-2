<?php
    // Class Function: Gets all listings using the account Id

    // Includes the database connector if nothing else has
    include_once 'databaseConnector.php';

    // Builds the class extending the database connector
    class getListingsByAccountIdApi extends databaseConnector {

        // Gets all listings using the account Id
        public function getListingsByAccountPHP($id) {
            // Connects to the database connector to retrieve query data
            parent::databaseConnector();

            // Return an array to use with further PHP programming
            return $this->getListingsByAccount($id);
        }
    }
    
    // Creates the initial object
    // Use '$node->FUNCTION' to use this object and call it's methods
    $node = new getListingsByAccountIdApi();
?>