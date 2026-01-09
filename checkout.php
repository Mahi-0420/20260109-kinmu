<?php
include('db_config.php');

// 現在「出勤中」の従業員のみ取得する
$sql_active = "SELECT k.id as kiroku_id, j.name 
               FROM kiroku k 
               JOIN jugyoin j ON k.jugyoin_id = j.id 
               WHERE k.end_work IS NULL";
$stmt_active = $pdo->query($sql_active);
$active_workers = $stmt_active->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kiroku_id = $_POST['kiroku_id'];

    if (!empty($kiroku_id)) {
        // 対象レコードの end_work を現在時刻に更新
        $stmt = $pdo->prepare("UPDATE kiroku SET end_work = NOW() WHERE id = ?");
        $stmt->execute([$kiroku_id]);
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>退勤登録</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="checkout-page">
    <div class="container">
        <h1>退勤登録</h1>
        <form method="POST">
            <label>退勤する従業員を選択してください：</label><br>
            <select name="kiroku_id" required>
                <option value="">-- 選択してください --</option>
                <?php foreach ($active_workers as $worker): ?>
                    <option value="<?= $worker['kiroku_id'] ?>">
                        <?= htmlspecialchars($worker['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br><br>
            <button type="submit" class="btn-checkout">退勤</button>
        </form>
        <br>
        <a href="index.php">戻る</a>
    </div>
</body>
</html>