<?php
require_once('auth.php');
session_destroy();
header('location: index.php');


?>