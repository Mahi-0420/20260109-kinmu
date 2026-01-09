<?php
include('db_config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jugyoin_id = $_POST['jugyoin_id'];

    if (!empty($jugyoin_id)) {
        // 現在時刻で新規レコードを作成
        $stmt = $pdo->prepare("INSERT INTO kiroku (jugyoin_id, start_work) VALUES (?, NOW())");
        $stmt->execute([$jugyoin_id]);
        header('Location: index.php'); // 一覧へ戻る
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
    <h1>出勤登録</h1>
    <form method="POST">
        <label>従業員IDを入力してください：</label><br>
        <input type="number" name="jugyoin_id" required>
        <button type="submit">出勤</button>
    </form>
    <br>
    <a href="index.php">一覧に戻る</a>
</body>
</html>