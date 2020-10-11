<?php
require_once '../_connec.php';

$pdo = new \PDO(DSN, USER, PASS);

$lastname = trim($_POST['lastname']);
$firstname = trim($_POST['firstname']);
$errors = [];
if (empty($lastname))
    $errors['lastname'] = 'Required';
if(strlen($lastname) > 45)
    $errors['lastname'] = 'Lastname too long';
if (empty($firstname))
    $errors['firstname'] = 'Required';
if(strlen($lastname) > 45)
    $errors['firstname'] = 'Firstname too long';

if (!empty($_POST['lastname']) && !empty($_POST['firstname']) && isset($_POST['btnSend'])) {
    $query = "INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)";
    $statement=$pdo->prepare($query);
    $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
    $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
    $statement->execute();
    header("Location: index.php");
}
$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll();

foreach($friends as $friend) {
    echo "<li>{$friend['firstname']}  {$friend['lastname']}</li>";
}
?>
<br/>
<form action="index.php" method="POST">
    <label for="firstname"></label>
    <input required type="text" id="firstname" name="firstname" placeholder="Firstname">
    <?php if (isset($errors['firstname'])): ?>
        <span><?= $errors['firstname'] ?></span>
    <?php endif; ?>
    <label for="lastname"></label>
    <input required type="text" id="lastname" name="lastname" placeholder="Lastname">
    <?php if (isset($errors['lastname'])): ?>
        <span><?= $errors['lastname'] ?></span>
    <?php endif; ?>
    <button type="submit"  name="btnSend">Send</button>
</form>
