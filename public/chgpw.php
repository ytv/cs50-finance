<?php

/*****
*
* chgpw.php
*
* enables users to change their passwords
*
* ytv
*
*
**/

    // configuration
    require("../includes/config.php");
    
    // if user reached page via GET
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // render settings form
        render("chgpw_form.php", ["title" => "Change Password"]);
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // find current password
        $rows = query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]);
        
        // validate submission
        // make sure all fields are filled out
        if(empty($_POST["old_pw"]) || empty($_POST["new_pw"]) || empty(["confirm_new_pw"]))
        {
            apologize("Please fill in all fields.");
        }
        
        // check if current password is correct
        else if(crypt($_POST["old_pw"], $rows[0]["hash"]) != $rows[0]["hash"])
        {
            apologize("Current password is invalid.");
        }
        
        // check if new password matches the confirmation
        else if($_POST["new_pw"] != $_POST["confirm_new_pw"])
        {
            apologize("The new password does not match the confirmation.");
        }
        
        else
        {
            // update password
            query("UPDATE users SET hash = ? WHERE id = ?", crypt($_POST["new_pw"]), $_SESSION["id"]);
            
            // set change of password indicator in user table to "N"
            query("UPDATE users SET chg_pw = ? where id = ?", "N", $_SESSION["id"]);
            
            // render success page
            render("success.php", ["message" => "Password successfully updated!"]);
        }
    }

?>
