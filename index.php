<?php include('db_config.php'); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>勤務記録一覧</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="list-page">
    <h1>勤怠記録一覧</h1>
    <nav>
        <a href="checkin.php">出勤登録へ</a> | 
        <a href="checkout.php">退勤登録へ</a>
    </nav>
    <hr>
    <table border="1">
        <thead>
            <tr>
                <th>従業員ID</th>
                <th>出勤時刻</th>
                <th>退勤時刻</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 最新の記録から順に表示
            $stmt = $pdo->query("SELECT * FROM kiroku ORDER BY id DESC");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['jugyoin_id']) . "</td>";
                echo "<td>" . $row['start_work'] . "</td>";
                echo "<td>" . ($row['end_work'] ?? '勤務中') . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>