<?php
    // Class Function: Gets the 5 most recent listings

    // Includes the database connector if nothing else has
    include_once 'databaseConnector.php';

    // Builds the class extending the database connector
    class getMostRecentListingsApi extends databaseConnector {

        // Gets top 5 most recent listings for use with PHP
        public function getMostRecentListingsPHP() {
            // Connects to the database connector to retrieve query data
            parent::databaseConnector();

            // Return an array to use with further PHP programming
            return $this->getMostRecentListings();
        }

        // // Gets top 5 most recent listings for use with HTML/JS/AJAX
        // public function getMostRecentListingsJS() {
        //     // Connects to the database connector to retrieve query data
        //     parent::databaseConnector();

        //     // Prints a json to use display in HTML or to use with JS and/or AJAX
        //     print(json_encode($this->getMostRecentListings()));
        // }
    }

    // Creates the initial object
    // Use '$node->FUNCTION' to use this object and call it's methods
    $node = new getMostRecentListingsApi();
?>