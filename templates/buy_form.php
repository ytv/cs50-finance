<?php
    print("<h4>"."Your current cash balance is: $".number_format(cash_balance(),2)."</h4>");
    $rows = query("SELECT * FROM portfolio WHERE id = ?", $_SESSION["id"]);
?>

<form action="buy.php" method="post">
    <fieldset>
        <div class="form-group">
            <input autofocus class="form-control" name="symbol" placeholder="Symbol" type="text"/>
        </div>
        <div class="form-group">
            <input class="form-control" name="shares" placeholder="Shares" type="text"/>
        </div>        
        <div class="form-group">
            <button type="submit" class="btn btn-default">Buy</button>
        </div>
    </fieldset>
</form>
