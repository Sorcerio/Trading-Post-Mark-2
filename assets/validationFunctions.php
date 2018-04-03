<?php
    // Functions to help validate data. Each function returns boolean.

    // Check for letters, numbers and dash, period, space and single quote only. Added & ; and # as a single quote sanitized with html entities will have this in it bob's will be come bob&#039;s
    function verifyAlphaNum($testString) {
        return (preg_match ("/^([[:alnum:]]|-|\.| |\'|&|;|#)+$/", $testString));
    }

    // Check for a valid email address 
    // For Filters: http://www.php.net/manual/en/filter.examples.validation.php
    function verifyEmail($testString) {    
        return filter_var($testString, FILTER_VALIDATE_EMAIL);
    }

    // Check for numbers and period.
    function verifyNumeric($testString) {
        return (is_numeric($testString));
    }

    // Check for usa phone number. 
    // Note for Testers: Area codes do not and cannot start with '1'
    // For explination: http://www.php.net/manual/en/function.preg-match.php
    function verifyPhone($testString) {
        $regex = '/^(?:1(?:[. -])?)?(?:\((?=\d{3}\)))?([2-9]\d{2})(?:(?<=\(\d{3})\))? ?(?:(?<=\d{3})[.-])?([2-9]\d{2})[. -]?(\d{4})(?: (?i:ext)\.? ?(\d{1,5}))?$/';
        return (preg_match($regex, $testString));
    }

    // Checks to see if an image passes full validation
    function verifyImage() {
        
    }
?>