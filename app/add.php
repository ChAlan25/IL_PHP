<?php
if (isset($_POST['task'])) {
    require '../db_conn.php';
    $task = $_POST['task'];
    if (empty($task)) {
        header("Location: ../index.php?mess=error");
    } else {
        $stmt = $conn->prepare("INSERT INTO tasks(Task_Name) VALUES(?)");
        $res = $stmt->execute([$task]);
        if ($res) {
            header("Location: ../index.php?mess=success");
        } else {
            header("Location: ../index.php");
        }
        $conn = null;
        exit();
    }
} else {
    header("Location: ../index.php?mess=error");
}
?>