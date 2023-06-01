<?php
// destroy
session_destroy();

// login page
header("Location: /");
exit();