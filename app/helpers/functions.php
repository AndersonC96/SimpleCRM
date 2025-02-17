<?php
    /**
    * Sanitizes a string by trimming whitespace and removing any HTML or PHP tags.
    *
    * @param string $string The string to sanitize.
    * @return string The sanitized string.
    */
    function sanitizeString($string) {
        return filter_var(trim($string), FILTER_SANITIZE_STRING);
    }
    /**
    * Validates if a given date is in the format YYYY-MM-DD.
    *
    * @param string $date The date string to validate.
    * @return bool Returns true if the date is valid and in the correct format, false otherwise.
    */
    function validateDate($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return ($d && $d->format('Y-m-d') === $date);
    }
    /**
    * Validates if a given time is in the format HH:MM (24-hour format).
    *
    * @param string $time The time string to validate.
    * @return bool Returns true if the time is valid and in the correct format, false otherwise.
    */
    function validateTime($time) {
        $t = DateTime::createFromFormat('H:i', $time);
        return ($t && $t->format('H:i') === $time);
    }
    /**
    * Validates if an email address is in a proper format.
    *
    * @param string $email The email address to validate.
    * @return bool Returns true if the email is valid, false otherwise.
    */
    function validateEmail($email) {
        return filter_var(trim($email), FILTER_VALIDATE_EMAIL) !== false;
    }
    /**
    * Validates a phone number.
    * Assumes a valid phone number should start with an optional '+' followed by 7 to 15 digits.
    *
    * @param string $phone The phone number to validate.
    * @return bool Returns true if the phone number is valid, false otherwise.
    */
    function validatePhone($phone) {
        $phone = trim($phone);
        return (preg_match('/^\+?[0-9]{7,15}$/', $phone) === 1);
    }
    /**
    * Limits a string to a maximum number of characters.
    *
    * @param string $string The string to limit.
    * @param int $maxLength The maximum allowed length. Default is 500.
    * @return string The string limited to the maximum length.
    */
    function limitString($string, $maxLength = 500) {
        return substr(trim($string), 0, $maxLength);
    }
    /**
    * Escapes a string for safe output in HTML.
    *
    * @param string $string The string to escape.
    * @return string The escaped string.
    */
    function escapeHTML($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }