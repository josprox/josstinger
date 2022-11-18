<!-- JosSecurity está funcionando -->
<?php

if($_ENV['RECAPTCHA'] == 1){?>

<script src="https://www.google.com/recaptcha/api.js"></script>

<?php
  }
  include __DIR__ . "/../../../routes/head/head_admin.php";
?>