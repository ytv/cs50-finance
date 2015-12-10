<?php
/*****
*
* register.php
*
* Allows new users to register
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
        render("register_form.php", ["title" => "Register"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if(empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["confirmation"]) || empty($_POST["email"]))
        {
            apologize("You must fill out all fields.");
        }
        else if($_POST["password"] !== $_POST["confirmation"])
        {
            apologize("Your passwords do not match.");
        }
        else
        {
            if(query("INSERT INTO users (username, hash, cash, email) VALUES(?, ?, 10000.00, ?)", $_POST["username"], crypt($_POST["password"]), $_POST["email"]) === false)
            {
                apologize("Username already exists.");
            }
            else
            {
                $rows = query("SELECT LAST_INSERT_ID() AS id");
                $id = $rows[0]["id"];
                
                // remember that user's now logged in by storing user's ID in session
                $_SESSION["id"] = $id;

                // redirect to portfolio
                redirect("index.php");
            }
        }
    }

?>
