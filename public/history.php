<?php
/*****
*
* history.php
*
* Displays the user's history of transactions
*
* ytv
*
*
**/
    $title = "History";
    
    // configuration
    require("../includes/config.php"); 
    
    // header
    require("../templates/header.php");

?>

<table class = "history">
    <?php
        
        print("<tr>");
        print("<th>"."TRANSACTION"."</th>");
        print("<th>"."SYMBOL"."</th>");
        print("<th>"."NAME"."</th>");
        print("<th>"."SHARES"."</th>");
        print("<th>"."PRICE PER SHARE"."</th>");
        print("<th>"."DATE/TIME"."</th>");
        print("</tr>");
        
        $rows = query("SELECT * FROM history WHERE id = ?", $_SESSION["id"]);
        
        if(!empty($rows))
        {
            foreach ($rows as $row)
            {
                $stock = lookup($row["symbol"]);
                
                print("<tr>");
                print("<td>".$row["transaction"]."</td>");
                print("<td>".$row["symbol"]."</td>");                
                print("<td>".$stock["name"]."</td>");
                print("<td>".$row["shares"]."</td>");
                print("<td>"."$ ".number_format($row["price"],2)."</td>");
                print("<td>".$row["date/time"]."</td>");
                print("</tr>");
            }
        }
    ?>
</table>

<?php

    // render footer
    require("../templates/footer.php");
?>
