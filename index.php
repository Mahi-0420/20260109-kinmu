<?php
include('db_config.php');

// SQLで名前の取得と給料計算（時給1350円固定）を同時に行う
$sql = "SELECT 
            j.name, 
            k.start_work, 
            k.end_work,
            1350 as hourly_rate, -- 時給を1350円として定義
            ROUND(TIMESTAMPDIFF(SECOND, k.start_work, k.end_work) / 3600 * 1350) as salary
        FROM kiroku k
        JOIN jugyoin j ON k.jugyoin_id = j.id
        ORDER BY k.start_work DESC";

try {
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll();
} catch (PDOException $e) {
    die("エラーが発生しました: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>勤怠記録一覧</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="index-page">
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
                    <td>
                        <?php if ($row['end_work']): ?>
                            <?= number_format($row['salary']) ?>円
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>