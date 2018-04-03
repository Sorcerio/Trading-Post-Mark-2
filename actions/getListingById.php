<?php
    // Class Function: Gets a listing by id

    // Includes the database connector if nothing else has
    include_once 'databaseConnector.php';

    // Builds the class extending the database connector
    class getListingByIdApi extends databaseConnector {

        // Gets the listing by id
        public function getListingByIdPHP($id) {
            // Connects to the database connector to retrieve query data
            parent::databaseConnector();

            // Return an array to use with further PHP programming
            return $this->getListingById($id);
        }
    }

    // Creates the initial object
    // Use '$node->FUNCTION' to use this object and call it's methods
    $node = new getListingByIdApi();
?>