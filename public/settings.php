<?php

    $title = "Settings";

    // configuration
    require("../includes/config.php");
    
    require("../templates/header.php");
    
?>

<ul class="settings">
    <li><a href = "chgpw.php">Change Password</a></li>
    <li><a href = "deposit.php">Deposit Additional Funds</a></li>
</ul>

<?php
    require("../templates/footer.php");
?>
