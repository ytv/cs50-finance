<table class = "portfolio">
    <?php
    
        if(isset($deposit))
        {
            print("<h4>". money_format($deposit,2). " has been deposited into your account. </h4>");
        }
        
        print("<tr>");
        print("<th>"."SYMBOL"."</th>");
        print("<th>"."NAME"."</th>");
        print("<th>"."SHARES"."</th>");
        print("<th>"."COST PER SHARE"."</th>");
        print("<th>"."CURRENT VALUE"."</th>");
        print("</tr>");
        
        $portfolio_bal = 0;
        
        foreach ($positions as $position)
        {
            $stock = lookup($position["symbol"]);
            
            print("<tr>");
            print("<td>".$position["symbol"]."</td>");
            print("<td>".$stock["name"]."</td>");
            print("<td>".$position["shares"]."</td>");
            print("<td>"."$ ".number_format($position["price"],2)."</td>");
            print("<td>"."$ ".number_format($position["price"] * $position["shares"],2)."</td>");
            print("</tr>");
            
            $portfolio_bal += $position["price"] * $position["shares"];
        }
        
        print("<tr>");
        print("<td>"."CASH"."</td>");
        print("<td>"."</td>"."<td>"."</td>"."<td>"."</td>");
        print("<td>"."$ ".number_format($balance,2)."</td>");
        print("</tr>");
        
        $portfolio_bal += $balance;
        
        print("<tr>");
        print("<th>"."TOTAL"."</th>");
        print("<th>"."</th>"."<th>"."</th>"."<th>"."</th>");
        print("<th>"."$ ".number_format($portfolio_bal,2)."</th>");
        print("</tr>");
    ?>
</table>
