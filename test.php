<?php 
$hashed_password = password_hash('general123', PASSWORD_DEFAULT);
echo $hashed_password;
