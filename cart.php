<?php

 if(isset($_POST['submit'])){

     foreach($_POST['quantity'] as $key => $val) {
         if($val==0) {
             unset($_SESSION['cart'][$key]);
         }else{
             $_SESSION['cart'][$key]['quantity']=$val;
         }
     }

 }

?>

<h1>View cart</h1>
<a href="index.php?page=books">Go back to the Books page.</a>
<form method="post" action="index.php?page=cart">

  <table>
      <tr>
          <th>Book Ref</th>
          <th>Book Title</th>
          <th>Book Price</th>
          <th>Book Format</th>
      </tr>

     <?php

         $sql="SELECT * FROM Books WHERE book_ref IN (";

                 foreach($_SESSION['cart'] as $id => $value) {
                     $sql.=$id.",";
                 }

                 $sql=substr($sql, 0, -1).") ORDER BY name ASC";
                 $query=mysql_query($sql);
                 $totalprice=0;
                 while($row=mysql_fetch_array($query)){
                     $subtotal=$_SESSION['cart'][$row['book_ref']]['quantity']*$row['book_price'];
                     $totalprice+=$subtotal;
                 ?>
                     <tr>
                         <td><?php echo $row['book_title'] ?></td>
                         <td><input type="text" name="quantity[<?php echo $row['book_ref'] ?>]" size="5" value="<?php echo $_SESSION['cart'][$row['book_ref']]['quantity'] ?>" /></td>
                         <td><?php echo $row['price'] ?>$</td>
                         <td><?php echo $_SESSION['cart'][$row['book_ref']]['quantity']*$row['book_price'] ?>$</td>
                     </tr>
                 <?php

                 }
     ?>
                 <tr>
                     <td colspan="4">Total Price: <?php echo $totalprice ?></td>
                 </tr>

 </table>
 <br />
 <button type="submit" name="submit">Update Cart</button>
</form>
<br />
<p>To remove an item set its quantity to 0. </p>
