<?php
/*****
*
* forgotpw.php
*
* Sends an email with a temporary password to users who click the "Forgot Password" link
* and forces them to change their password the next time they log in
*
* ytv
*
*
**/
    
    // configuration
    require("../includes/config.php");
    
    // if page was reached via GET
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // render form
        render("forgotpw_form.php", ["title" => "Forgot Password"]);
    }
    
    // if page was reached via POST
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if(empty($_POST["email"]))
        {
            apologize("Please enter your email address");
        }
        
        else 
        {   
            $rows = query("SELECT * FROM users WHERE email = ?", $_POST["email"]);
            
            // validate email address
            if(empty($rows))
            {
                apologize("The email address you entered was not found in our database.");
            }
            
            else
            {
                // find user id
                $id = $rows[0]["id"];
                
                // create new password
                $newpw = randompw();
                
                // update password in user database
                query("UPDATE users SET hash = ? WHERE id = ?", crypt($newpw), $id);
                
                // indicate a change of password is necessary next time the user logs in
                query("UPDATE users SET chg_pw = ? where id = ?", "Y", $id);
                
                // template for the forgot password email
                $body = "<p>Your password has been changed to: "."$newpw".
                        "<p>Please login <a href = \"/pset7/login.php\">here</a> to reset your password.</p>
                         <p>Sincerely,<br>
                         Your dear friends @ C\$50</p>";
                    
                email($_POST["email"], "C\$50: Reset Your Password", $body);
                
                render("forgotpw_success.php", ["title"=>"Email sent"]);
            }
            
            
            
        }
    }
?>
