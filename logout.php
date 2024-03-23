<?php
session_start();
session_unset();
session_destroy();
ini_set("display_errors", "off");

header("Location: index.php");
exit();