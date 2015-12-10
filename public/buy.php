<?php

/*****
*
* buy.php
*
* Controller for purchasing stocks
*
* ytv
*
*
**/

    // configuration
    require("../includes/config.php");
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("buy_form.php", ["title" => "Buy Stocks"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $stock = lookup($_POST["symbol"]);
        
        //validate submission
        if($stock === false || empty($stock))
        {
            apologize("Invalid symbol.");
        }
        else if(empty($_POST["shares"]))
        {
            apologize("Please enter the number of shares.");
        }
        else if(!preg_match("/^\d+$/", $_POST["shares"]))
        {
            apologize("Number of shares should be a positive integer.");
        }
        else if(cash_balance() < $stock["price"] * $_POST["shares"])
        {
            apologize("Inadequate funds.");
        }
        else
        {   
            // capitalize symbol        
            $_POST["symbol"] = strtoupper($_POST["symbol"]);
            
            // update portfolio
            query("INSERT INTO portfolio (id,symbol,shares) VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)", 
                $_SESSION["id"], $_POST["symbol"], $_POST["shares"]);
            
            // update history
            query("INSERT INTO history (id, transaction, symbol, shares, price) VALUES (?,?,?,?,?)", 
                $_SESSION["id"], "BOUGHT", $_POST["symbol"], $_POST["shares"], $stock["price"]);
                
            // update cash balance               
            query("UPDATE users SET cash = cash - ? WHERE id = ?", $stock["price"] * $_POST["shares"], $_SESSION["id"]);
            
            // email receipt
            $rows1 = query("SELECT * FROM history WHERE id = ?", $_SESSION["id"]);
            $rows2 = query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]);
            
            $datetime = $rows1[0]["date/time"]; 
            $stockname = $stock["name"];
            $stocksymbol = ($_POST["symbol"]);
            $shares = $_POST["shares"];
            $stockprice = number_format($stock["price"],2);
                       
            $to = $rows2[0]["email"];            
            $subject = "C$50: Receipt";
            $body = "<p>This is your receipt for your transaction on "."$datetime".": </p>
                    <p>You bought "."$shares"." share(s) of "."$stockname"." stock ("."$stocksymbol".") 
                    for $"."$stockprice"." per share. </p>
                    <p>Sincerely,
                    <br>Your dear friends @ C\$50</p>";
            
            email($to, $subject, $body);
                        
            redirect("index.php");
        }
    }    
?>
