<?php
include('db_config.php');

// 1. プルダウン用の従業員リストを取得する
$stmt_emp = $pdo->query("SELECT id, name FROM jugyoin ORDER BY id ASC");
$employees = $stmt_emp->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jugyoin_id = $_POST['jugyoin_id'];

    if (!empty($jugyoin_id)) {
        // 現在時刻で新規レコードを作成
        $stmt = $pdo->prepare("INSERT INTO kiroku (jugyoin_id, start_work) VALUES (?, NOW())");
        $stmt->execute([$jugyoin_id]);
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>出勤登録</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="checkin-page">
    <div class="container">
        <h1>出勤登録</h1>
        <form method="POST">
            <label for="jugyoin_id">従業員名を選択してください：</label><br>
            <select name="jugyoin_id" id="jugyoin_id" required>
                <option value="">-- 選択してください --</option>
                <?php foreach ($employees as $emp): ?>
                    <option value="<?= htmlspecialchars($emp['id']) ?>">
                        <?= htmlspecialchars($emp['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br><br>
            <button type="submit">出勤する</button>
        </form>
        <br>
        <a href="index.php">一覧に戻る</a>
    </div>
</body>
</html>