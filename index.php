 <?php
 session_start();
 include 'connect.php';
 if(!isset($_POST["nick"])){

     echo '<h1>Welcome!</h1>'; ?>
     
     <form action="index.php" method="POST">
         <input type="text" name="nick" placeholder="nick"> <br>
         <input type="password" name="heslo" placeholder="heslo"> <br> 
         <input type="submit">
     </form>
     
     <?php
}else{
   $nick = filter_input(INPUT_POST, "nick");
    $heslo = filter_input(INPUT_POST, "heslo");
    $sql_dotaz = "SELECT * FROM `Users` WHERE `username`= '$nick' AND `password` = md5('$heslo')";
    $result = mysqli_query($db, $sql_dotaz) or die($sql_dotaz);
    if($result->num_rows== 1){
        $row = $result->fetch_assoc();
        $_SESSION["user_id"] = $row["ID"];
       
      header("Location: todo.php");  
      die();
    }else{
        echo"<p> Nespravna kombinace jmena a hesla. </p>";
    }
}