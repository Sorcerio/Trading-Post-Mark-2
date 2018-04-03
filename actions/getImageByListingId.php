<?php
    // Class Function: Gets an image with the listing id

    // Includes the database connector if nothing else has
    include_once 'databaseConnector.php';

    // Builds the class extending the database connector
    class getImageByListingIdApi extends databaseConnector {

        // Gets top 5 most recent listings for use with PHP
        public function getImageByListingIdPHP($id) {
            // Connects to the database connector to retrieve query data
            parent::databaseConnector();

            // Return an array to use with further PHP programming
            return $this->getImageByListingId($id);
        }
    }

    // Creates the initial object
    // Use '$node->FUNCTION' to use this object and call it's methods
    $node = new getImageByListingIdApi();
?>