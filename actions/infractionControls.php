<?php
    // Class Function: Provides access to infraction control functions
    // NOTE: '$node' standard is not used for this. Use '$infractionNode' instead.

    // Includes the database connector if nothing else has
    include_once 'databaseConnector.php';

    // Builds the class extending the database connector
    class infractionControlApi extends databaseConnector {

        // Sends an infraction to the database
        public function logInfractionPHP($message) {
            // Connects to the database connector to retrieve query data
            parent::databaseConnector();

            // Ready message string
            $message .= ". ";

            // Check for logged in user
            if(isset($_SESSION['login'])) {
                $message .= "User Id: ".$_SESSION['login'].". ";
            }

            // // Attempt to trace IP
            // if($_SERVER['HTTP_X_FORWARDED_FOR'] != "") {
            //     // There's a proxy in play
            //     $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            //     $message .= "Possible proxy detected. REMOTE_ADDR was '".$_SERVER['REMOTE_ADDR'].". ";
            // } else {
            //     $ip = $_SERVER['REMOTE_ADDR'];
            // }
            
            // Set Ip
            $ip = $_SERVER['REMOTE_ADDR'];

            // Check for Querys
            if($_SERVER['QUERY_STRING'] != "") {
                $message .= "Query detected: (".$_SERVER['REQUEST_METHOD'].") ".$_SERVER['QUERY_STRING'].". ";
            }

            // Add basic information to message
            $message .= "Referer was ".$_SERVER['HTTP_REFERER'].". ";
            $message .= "User Agent was ".$_SERVER['HTTP_USER_AGENT'].". ";

            // Return an array to use with further PHP programming
            return $this->logInfraction($ip,$message);
        }
    }
    
    // Creates the initial object
    // Use '$infractionNode->FUNCTION' to use this object and call it's methods
    $infractionNode = new infractionControlApi();
?>