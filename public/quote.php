<?php
/*****
*
* quote.php
*
* Gives users stock price quotes
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
        render("quote_form.php", ["title" => "Get Quote"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $stock = lookup($_POST["symbol"]);
    
        if($stock === false)
        {
            apologize("Invalid symbol.");
        }
        else
        {
            //print("<h4>"."Price: $".money_format($stock["price"], 2)."<h4>");
            render("quote_form.php", ["title" => "Get Quote", "stock" => $stock]);
        }
    }
?>
