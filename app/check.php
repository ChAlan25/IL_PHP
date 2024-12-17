<?php
if (isset($_POST['id'])) {
    require '../db_conn.php'; // Ensure your database connection script is included
    $id = $_POST['id'];
    
    if (empty($id)) {
        echo 0; // ID is required
    } else {
        try {
            // Prepare a SELECT query to get the 'Checked' status
            $todos = $conn->prepare("SELECT ID, Checked FROM tasks WHERE ID = ?");
            $todos->execute([$id]);
            $todo = $todos->fetch(PDO::FETCH_ASSOC);

            // If the record exists, toggle the Checked status
            if ($todo) {
                $uChecked = $todo['Checked'] ? 0 : 1;

                // Update query with prepared statement
                $updateQuery = $conn->prepare("UPDATE tasks SET Checked = ? WHERE ID = ?");
                $res = $updateQuery->execute([$uChecked, $todo['ID']]);

                if ($res) {
                    echo $uChecked; // Return the new status (0 or 1)
                } else {
                    echo "error"; // Error updating record
                }
            } else {
                echo "error"; // Record not found
            }
        } catch (PDOException $e) {
            echo "error: " . $e->getMessage(); // Show error message (for debugging)
        } finally {
            $conn = null; // Close the database connection
        }
    }
    exit();
} else {
    // Redirect if accessed improperly
    header("Location: ../index.php?mess=error");
    exit();
}
?>
