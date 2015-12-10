<?php if(isset($stock))
    {
        print("<h4> Current ".$stock["name"]." stock price: $".money_format($stock["price"], 2)."<h4>");
    }
?>

<form action="quote.php" method="post">
    <fieldset>
        <div class="form-group">
            <input autofocus class="form-control" name="symbol" placeholder="Symbol" type="text"/>
            <button type="submit" class="btn btn-default">Get Quote</button>
        </div>
    </fieldset>
</form>
