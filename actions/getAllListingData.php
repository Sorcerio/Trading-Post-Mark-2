<?php
    // Class Function: Gets listings that fall withing the specified page number

    // Includes the database connector if nothing else has
    include_once 'databaseConnector.php';

    // Builds the class extending the database connector
    class getAllListingDataApi extends databaseConnector {

        // Gets listings using the current page number and the limit
        public function getAllListingDataPHP($page,$limit) {
            // Connects to the database connector to retrieve query data
            parent::databaseConnector();

            // Return an array to use with further PHP programming
            return $this->getAllListingData($page,$limit);
        }
    }

    // Creates the initial object
    // Use '$node->FUNCTION' to use this object and call it's methods
    $node = new getAllListingDataApi();
?>