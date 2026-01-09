<?php
include('db_config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jugyoin_id = $_POST['jugyoin_id'];

    if (!empty($jugyoin_id)) {
        // その従業員の「退勤時刻が空」である最新の1件を更新する
        $stmt = $pdo->prepare("UPDATE kiroku SET end_work = NOW() 
                               WHERE jugyoin_id = ? AND end_work IS NULL 
                               ORDER BY id DESC LIMIT 1");
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
    <title>退勤登録</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="checkout-page">
    <h1>退勤登録</h1>
    <form method="POST">
        <label>従業員IDを入力してください：</label><br>
        <input type="number" name="jugyoin_id" required>
        <button type="submit">退勤</button>
    </form>
    <br>
    <a href="index.php">一覧に戻る</a>
</body>
</html>