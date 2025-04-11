<?php
    function flash($message = null, $type = 'is-success') {
        if ($message) {
            $_SESSION['flash'] = compact('message', 'type');
        } elseif (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }