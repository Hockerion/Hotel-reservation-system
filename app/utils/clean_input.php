<?php
class CleanInput{
    /**
     * This method cleans up string data
     * for space and security purposes.
     */
    public static function clean_text($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}