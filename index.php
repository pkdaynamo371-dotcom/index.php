FROM php:8.2-apache
COPY . /var/www/html/<?php
session_start();

// تهيئة نقاط اللعبة إذا لم تكن موجودة
if (!isset($_SESSION['player_hp'])) {
    $_SESSION['player_hp'] = 100;
    $_SESSION['enemy_hp'] = 100;
    $_SESSION['message'] = "بدأت المعركة! اختر هجومك.";
}

// معالجة الأزرار عند الضغط عليها
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'attack') {
        $player_damage = rand(10, 20);
        $enemy_damage = rand(5, 15);

        $_SESSION['enemy_hp'] -= $player_damage;
        $_SESSION['player_hp'] -= $enemy_damage;

        $_SESSION['message'] = "أطلقت نيران! سببت ضرر للعدو بقيمة $1 وإلحاق الضرر بك بقيمة $2.";
    } elseif ($_POST['action'] == 'reset') {
        $_SESSION['player_hp'] = 100;
        $_SESSION['enemy_hp'] = 100;
        $_SESSION['message'] = "تم إعادةเริ่ม المعركة من جديد!";
    }
}

// التحقق من نهاية اللعبة
$game_over = false;
if ($_SESSION['player_hp'] <= 0) {
    $_SESSION['message'] = "لقد خسرت المعركة! دمر العدو قاعدتك.";
    $game_over = true;
} elseif ($_SESSION['enemy_hp'] <= 0) {
    $_SESSION['message'] = "تهانينا! لقد انتصرت ودمرت قاعدة العدو!";
    $game_over = true;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لعبة الحرب بـ PHP</title>
    <style>
        body { background: #111; color: #fff; font-family: Tahoma; text-align: center; padding-top: 50px; }
        .box { background: #222; border: 2px solid #444; display: inline-block; padding: 20px; border-radius: 10px; width: 400px; }
        button { padding: 10px 20px; font-size: 16px; background: #d9534f; color: #fff; border: none; cursor: pointer; border-radius: 5px; }
        button:hover { background: #c9302c; }
    </style>
</head>
<body>
    <div class="box">
        <h2>لعبة الحرب التكتيكية</h2>
        <p><?php echo $_SESSION['message']; ?></p>
        <hr>
        <p><strong>صحتك:</strong> <?php echo max(0, $_SESSION['player_hp']); ?> / 100</p>
        <p><strong>صحة العدو:</strong> <?php echo max(0, $_SESSION['enemy_hp']); ?> / 100</p>

        <form method="POST">
            <?php if (!$game_over): ?>
                <button type="submit" name="action" value="attack">هجوم مدفعي</button>
            <?php else: ?>
                <button type="submit" name="action" value="reset">إعادة اللعب</button>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
