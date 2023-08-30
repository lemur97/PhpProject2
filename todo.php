<?php
session_start();
include 'connect.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    die("Nemas tu co delat. ");
}


$user_id = $_SESSION["user_id"];
$sql_dotaz = "SELECT * FROM `Users` WHERE `ID`= $user_id";
$result = mysqli_query($db, $sql_dotaz) or die($sql_dotaz);
$row = $result->fetch_assoc();

echo "Ahoj " . $row["username"];

if ($_POST["submit"] == "Odeslat") {
    $novy_ukol = $_POST["description"];
    if ($user_id == 3) {
        $target_id = $_POST["userID"];
        $sql_insert = "INSERT INTO `todos` VALUES (DEFAULT,$target_id,1,'$novy_ukol')";
    } else {
        $sql_insert = "INSERT INTO `todos` VALUES (DEFAULT,$user_id,1,'$novy_ukol')";
    }
    $resultinsert = mysqli_query($db, $sql_insert) or die($sql_insert);
} elseif ($_POST["complete"] == "true") {
    $todoID = $_POST["id"];
    $sql_complete = "UPDATE `todos` SET `statusID`= 2 WHERE `ID`= $todoID";
    $resultcomplete = mysqli_query($db, $sql_complete) or die($sql_complete);
} elseif ($_POST["delete"] == "true") {
    $todoID = $_POST["id"];
    $sql_delete = "DELETE FROM `todos` WHERE `ID`= $todoID";
    $resultdelete = mysqli_query($db, $sql_delete) or die($sql_delete);
}
if ($user_id == 3) {
    $sql_dotaz2 = "SELECT * FROM `todos` WHERE 1 ";
} else {
    $sql_dotaz2 = "SELECT * FROM `todos` WHERE `userID`= $user_id";
}
$result2 = mysqli_query($db, $sql_dotaz2) or die($sql_dotaz2);
?>

<form action="todo.php" method="POST">
    <input type="text" name="description" placeholder="pridej ukol"> 
    <?php
    if ($user_id == 3) {
        echo '<input type="text" name="userID" placeholder="komu">';
    }
    ?>
    <input type="submit" name="submit" value="Odeslat">
</form>

<table rules="all" frame="border"> 
    <thead><th> Úkoly pro dnešní den: </th><th></th><th></th></thead>
<tbody>

        <?php while ($row = $result2->fetch_assoc()) { ?>
        <tr> <?php
            if ($user_id == 3) {
                echo "<td>" . $row["userID"] . "</td>";
            }
            ?>
            <td>
                <?php echo $row["todo"]; ?>  
            </td>
            <td>
    <?php if ($row["statusID"] == 1) { ?>
                    <form action="todo.php" method="POST">
                        <button type="submit" name="complete">Hotovo</button>
                        <input type="hidden" name="id" value="<?= $row["ID"] ?>">
                        <input type="hidden" name="complete" value="true">

                    </form>  
                    <?php
                } else {
                    echo "Úkol splněn!";
                }
                ?>
            </td>
            <td>
                <form action="todo.php" method="POST">
                    <button type="submit" name="delete">Smazat</button>
                    <input type="hidden" name="id" value="<?= $row["ID"] ?>">
                    <input type="hidden" name="delete" value="true">

                </form>  
            </td>

        </tr>    
    <?php
}
?>
</tbody>
</table> 






