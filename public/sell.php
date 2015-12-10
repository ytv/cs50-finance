<?php
/*****
*
* sell.php
*
* Enables users to sell stocks in their portfolio
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
        render("sell_form.php", ["title" => "Sell Stocks"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $stock = lookup($_POST["symbol"]);
        
        $rows = query("SELECT * FROM portfolio WHERE id = ? AND symbol = ?", $_SESSION["id"], $_POST["symbol"]);
    
        // checks if stock was found in the user's portfolio
        if(empty($rows))
        {
            apologize("Stock not found in your portfolio");
        }
        
        else if(empty($_POST["shares"]))
        {
            apologize("Please enter the number of shares.");
        }
        
        // checks if the shares entered is positive integer
        else if(!preg_match("/^\d+$/", $_POST["shares"]))
        {
            apologize("Number of shares should be a positive integer.");
        }
        
        // checks if the user has an adequate number of shares
        else if($_POST["shares"] > $rows[0]["shares"])
        {
            apologize("You do not have enough shares.");
        }
        
        else
        {
            // capitalize symbol        
            $_POST["symbol"] = strtoupper($_POST["symbol"]);
            
            // if user enters the exact amount of shares he/she has, delete stock from portfolio
            if($_POST["shares"] == $rows[0]["shares"])
            {
                query("DELETE FROM portfolio WHERE id = ? AND symbol = ?", $_SESSION["id"], $_POST["symbol"]);
            }
            
            else if($_POST["shares"] < $rows[0]["shares"])
            {
                query("UPDATE portfolio SET shares = ? WHERE id = ? AND symbol = ?", $rows[0]["shares"] - $_POST["shares"], $_SESSION["id"], $_POST["symbol"]);
            }
            
            // update cash balance
            query("UPDATE users SET cash = cash + ? WHERE id = ?", $stock["price"] * $_POST["shares"], $_SESSION["id"]);
            
            // update history
            query("INSERT INTO history (id, transaction, symbol, shares, price) VALUES (?,?,?,?,?)", 
                $_SESSION["id"], "SOLD", $_POST["symbol"], $_POST["shares"], $stock["price"]);
                
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
                    <p>You sold "."$shares"." share(s) of "."$stockname"." stock ("."$stocksymbol".") 
                    for $"."$stockprice"." per share. </p>
                    <p>Sincerely,
                    <br>Your dear friends @ C\$50</p>";
            
            email($to, $subject, $body);
        
            redirect("index.php");
        }
    }
    
    
?>
