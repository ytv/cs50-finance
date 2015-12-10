<?php
    $rows = query("SELECT * FROM portfolio WHERE id = ?", $_SESSION["id"]);
?>

<h4>Please select the stock and enter number of shares you'd like to sell.</h4>

<form action="sell.php" method="post">
    <fieldset>
        
        <div class="form-group">
            <select class="form-control" name="symbol">
                <?php
                    foreach ($rows as $row)
                    {
                        print("<option value='{$row["symbol"]}'>{$row["symbol"]}</option>\n");
                    }
                ?>
            </select>
            <input class = "form-control" name="shares" placeholder="Shares" type="text"/>
            <button type="submit" class="btn btn-default">Sell</button>
        </div>
    </fieldset>
</form>
