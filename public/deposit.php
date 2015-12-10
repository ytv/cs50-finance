<?php
/*****
*
* deposit.php
*
* Enables users to deposit additional funds into their account
*
* ytv
*
*
**/

    // configuration
    require("../includes/config.php");

    // if page was reached via GET
    if($_SERVER["REQUEST_METHOD"] == "GET")
    {
        render("deposit_form.php", ["title" => "Deposit Funds"]);
    }
    
    // if page was reached via POST
    else if ($_SERVER["REQUEST_METHOD"]== "POST")
    {
        // validate submission
        if(empty($_POST["deposit"]))
        {
            apologize("Please enter an amount of funds to deposit.");
        }
        
        else if(!(preg_match("/^\d+(\.\d+)$/", $_POST["deposit"]) || preg_match("/^\d+$/", $_POST["deposit"])))
        {
            apologize("Please enter a positive amount.");
        }
        
        else 
        {
            // update cash balance
            query("UPDATE users SET cash = cash + ? WHERE id = ?", $_POST["deposit"], $_SESSION["id"]);
            
            redirect("/");
        }
    }
?>
