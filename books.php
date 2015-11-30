<?php

    if(isset($_GET['action']) && $_GET['action']=="add"){

        $id=intval($_GET['id']);

        if(isset($_SESSION['cart'][$id])){

            $_SESSION['cart'][$id]['quantity']++;

        }else{

            $sql_s="SELECT * FROM Books
                WHERE book_ref={$id}";
            $query_s=mysql_query($sql_s);
            if(mysql_num_rows($query_s)!=0){
                $row_s=mysql_fetch_array($query_s);

                $_SESSION['cart'][$row_s['book_ref']]=array(
                        "quantity" => 1,
                        "price" => $row_s['book_price']
                    );


            }else{

                $message="This book ref it's invalid!";

            }

        }

    }

?>
    <h1>Book List</h1>
    <?php
        if(isset($message)){
            echo "<h2>$message</h2>";
        }
    ?>
    <table>
        <tr>
            <th>Book Ref</th>
            <th>Book Title</th>
            <th>Book Price</th>
            <th>Book Format</th>
        </tr>

        <?php

            $sql="SELECT * FROM Books ORDER BY book_title ASC";
            $query=mysql_query($sql);

            while ($row=mysql_fetch_array($query)) {

        ?>
            <tr>
                <td><?php echo $row['book_ref'] ?></td>
                <td><?php echo $row['book_title'] ?></td>
                <td><?php echo $row['book_price'] ?>$</td>
                <td><?php echo $row['book_format'] ?>$</td>
                <td><a href="index.php?page=books&action=add&id=<?php echo $row['book_ref'] ?>">Add to cart</a></td>
            </tr>
        <?php

            }

        ?>

    </table>
