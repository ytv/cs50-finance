<?php

    // configuration
    require("../includes/config.php"); 
    
    $positions = [];
    
    $rows = query("SELECT * FROM portfolio WHERE id = ?", $_SESSION["id"]);
    
    if(!empty($rows))
    {
        foreach ($rows as $row)
        {
            $stock = lookup($row["symbol"]);
            if ($stock !== false)
            {
                $positions[] = [
                    "name" => $stock["name"],
                    "price" => $stock["price"],
                    "shares" => $row["shares"],
                    "symbol" => $row["symbol"]
                ];
            }
        }
    }
    $balance = cash_balance();
    
    
    // render portfolio
    render("portfolio.php", ["positions" => $positions, "balance" => $balance, "title" => "Portfolio"]);

?>
