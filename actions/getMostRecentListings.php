<?php
// Gets the provided number of most recent listings

    // Includes the database connector if nothing else has
    include_once 'databaseConnector.php';

    // Builds the class extending the database connector
    class getMostRecentListingsApi extends databaseConnector {

        // Creates a function that can be called by anything that includes this file
        // and returns a json encoded stream from the query
        public function getMostRecentListingsApi() {
            // Connects to the database connector to get it's methods
            parent::databaseConnector();

            // Prints the json to the HTML
            print(json_encode($this->getMostRecentListings()));

            // Returns the json to use with PHP data
            return json_encode($this->getMostRecentListings());
        }
    }

    // Creates the initial node which prints the php data to HTML
    $node = new getMostRecentListingsApi();
    
    // Saves json to a PHP accessable variable
    $data = $node->getMostRecentListingsApi();
?>