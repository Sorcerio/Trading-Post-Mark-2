<?php
    // Class Function: Creates a new entry in the database connecting an image to a listing

    // Includes the database connector if nothing else has
    include_once 'databaseConnector.php';

    // Builds the class extending the database connector
    class addImageToListingApi extends databaseConnector {

        // Creates a new image entry
        public function addImageToListingPHP($id,$path) {
            // Connects to the database connector to retrieve query data
            parent::databaseConnector();

            // Execute the submission query and return listing id
            return $this->addImageToListing($id,$path);
        }
    }

    // Creates the initial object that methods can be called from
    $node = new addImageToListingApi();
?>