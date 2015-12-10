<!DOCTYPE html>

<html>

    <head>
        <?php
            // css styling
            require("../includes/css.php");
        ?>       
        
        <?php if (isset($title)): ?>
            <title>C$50 Finance: <?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>C$50 Finance</title>
        <?php endif ?>

        <script src="/js/jquery-1.11.1.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/scripts.js"></script>

    </head>

    <body>

        <div class="container">

            <div id="top">
                <a href="/"><img alt="C$50 Finance" src="/img/logo.gif"/></a>
                
                <ul class = "nav">
                    <li><a href = "index.php">Portfolio</a></li>
                    <li><a href = "quote.php">Quote</a></li>
                    <li><a href = "buy.php">Buy</a></li>
                    <li><a href = "sell.php">Sell</a></li>
                    <li><a href = "history.php">History</a></li>
                    <li><a href = "settings.php">Account Settings</a></li>
                    
                    <?php 
                        if(!in_array($_SERVER["PHP_SELF"], ["/login.php", "/logout.php", "/register.php", "/forgotpw.php"]))
                        {
                            print("<li><a href = \"logout.php\">Log Out</a></li>");
                        }
                    ?>
                    <?php 
                        if(in_array($_SERVER["PHP_SELF"], ["/register.php", "/forgotpw.php"]))
                        {
                            print("<li><a href = \"login.php\">Log In</a></li>");
                        }
                    ?>
                    
                </ul>
            </div>

            <div id="middle">
