<?php
    // Checks to see if the page has actually been sent from the site
    function securityCheck($myFormURL = "") {
        // Config
        $debugThis = false;
        
        // Variables
        $status = true;
        
        // Check to make sure the form came from itself
        if ($myFormURL != "") {
            // Get the page the data came from
            $fromPage = htmlentities($_SERVER['HTTP_REFERER'], ENT_QUOTES, 'UTF-8');
            
            // Strip 'http' and 'https'
            $fromPage = preg_replace('#^https?:#', '', $fromPage);
            
            // Debug
            if ($debugThis) {
                print '<p>From: '.$fromPage.' should match your Url: '.$myFormURL;
            }

            // Check for status validation
            if ($fromPage != $myFormURL) {
                // Validation failed
                $status = false;
            }
        }

        // Return status boolean
        return $status;
    }
?>