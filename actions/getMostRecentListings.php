<?php
    // Gets the provided number of most recent listings
    include_once 'databaseConnector.php';

    class getMostRecentListings extends databaseConnector {

        public function getMostRecentListings(){
            parent::databaseConnector();

            $modifier = $_GET['number'];
            print(json_encode($this->getAllShopifyIds($modifier)));
        }
    }

    $derp = new getMostRecentListings($modifier);
?>