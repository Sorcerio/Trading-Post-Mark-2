<?php
    // Class Function: Creates a new listing with the applied information and returns the Listing Id

    // Includes the database connector if nothing else has
    include_once 'databaseConnector.php';

    // Builds the class extending the database connector
    class createListingApi extends databaseConnector {

        // Creates a new listing with supplied information
        public function createNewListingPHP($title,$desc,$quantity,$price,$barter,$account) {
            // Connects to the database connector to retrieve query data
            parent::databaseConnector();

            // Execute the submission query and return listing id
            return $this->createNewListing($title,$desc,$quantity,$price,$barter,$account);
        }
    }

    // Creates the initial object that methods can be called from
    $node = new createListingApi();
?>