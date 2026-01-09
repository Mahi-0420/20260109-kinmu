<?php
include('db_config.php');

// SQLで名前の取得と給料計算を同時に行う
// 勤務時間は TIMESTAMPDIFF(SECOND, ...) で秒単位で出し、3600で割って時間に変換
$sql = "SELECT 
            j.name, 
            k.start_work, 
            k.end_work,
            j.hourly_rate,
            ROUND(TIMESTAMPDIFF(SECOND, k.start_work, k.end_work) / 3600 * j.hourly_rate) as salary
        FROM kiroku k
        JOIN jugyoin j ON k.jugyoin_id = j.id
        ORDER BY k.start_work DESC";

$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>勤怠記録一覧</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>勤怠記録一覧</h1>
        <div class="nav">
            <a href="checkin.php">出勤登録</a> | <a href="checkout.php">退勤登録</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>名前</th>
                    <th>出勤時刻</th>
                    <th>退勤時刻</th>
                    <th>時給</th>
                    <th>概算給料</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['start_work']) ?></td>
                    <td><?= htmlspecialchars($row['end_work'] ?? '勤務中...') ?></td>
                    <td><?= number_format($row['hourly_rate']) ?>円</td>
                    <td><?= $row['end_work'] ? number_format($row['salary']) . '円' : '-' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>