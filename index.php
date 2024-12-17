<?php require 'db_conn.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style1.css">
    <title>To-Do-List</title>
</head>

<body>
    <div class="main-section">
        <div class="add-section">
            <form action="app/add.php" method="post">
                <?php if (isset($_GET['mess']) && $_GET['mess'] == 'error') { ?>
                    <input type="text" name="task" class="error" placeholder="Enter your task">
                    <button>Add &nbsp;<span>&#43;</span></button>
                <?php } else { ?>
                    <input type="text" name="task" placeholder="Enter your task">
                    <button>Add &nbsp;<span>&#43;</span></button>
                <?php } ?>
            </form>
        </div>
        <?php $todos = $conn->query("SELECT * FROM tasks ORDER BY ID DESC"); ?>
        <div class="show-tasks-section">
            <?php while ($todo = $todos->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="task">
                    <span class="close-btn" id="<?php echo $todo['ID']; ?>">X</span>
                    <div class="checkbox-wrapper-15">
                        <input class="inp-cbx" id="<?php echo $todo['Task_Name']; ?>" type="checkbox" data-todo-id="<?php echo $todo['ID']; ?>" <?php if ($todo['Checked'] == 1) { ?>checked<?php } ?> style="display: none;" />
                        <label class="cbx" for="<?php echo $todo['Task_Name']; ?>">
                            <span>
                                <svg width="12px" height="9px" viewbox="0 0 12 9">
                                    <polyline points="1 5 4 8 11 1"></polyline>
                                </svg>
                            </span>
                            <span><?php echo $todo['Task_Name']; ?></span>
                        </label>
                    </div>
                    <small>Created at : <?php echo $todo['Date_Time']; ?></small>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
<script src="js/jquery-3.2.1.min.js"></script>
<script>
    $(document).ready(function () {
        $('.close-btn').click(function () {
            const id = $(this).attr('id');
            $.post("app/remove.php", {
                id: id
            },
                (data) => {
                    if (data) {
                        $(this).parent().hide(600);
                    }
                });
        })
        $('.check-box').click(function () {
            const id = $(this).attr('id');
            $.post("app/check.php", {
                id: id
            },
                (data) => {
                    if (data != 'error') {
                        if (data === '1') {
                            $(this).removeAttr('checked');
                        } else {
                            $(this).addAttr('checked');
                        }
                    }
                });
        })
    })
</script>

</html>