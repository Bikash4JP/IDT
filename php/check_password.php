<?php
$password = 'itf123';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo "Hashed password: " . $hashedPassword;
?>
<!-- $2y$10$4CgFUOLCGzll71bOinlMM.KTg3LzU9hBeKdLQJQVxZnYXBO2xxn.C -->
<!-- $2y$10$C3m2/uZecSDQIsCD5h62Zu.VxwWE5UKziYjL1Glz220IkOjYyJi2O -->