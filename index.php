<?php
// بدء الجلسة لحفظ بيانات اللعبة
session_start();

// إعادة ضبط اللعبة إذا طلب المستخدم ذلك
if (isset($_POST['reset'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// توليد رقم عشوائي جديد إذا لم يكن موجوداً في الجلسة
if (!isset($_SESSION['target'])) {
    $_SESSION['target'] = rand(1, 100);
    $_SESSION['attempts'] = 0;
}

$message = "";
$game_won = false;

// معالجة إرسال التخمين
if (isset($_POST['guess'])) {
    $user_guess = intval($_POST['guess']);
    $_SESSION['attempts']++;
    
    if ($user_guess < 1 || $user_guess > 100) {
        $message = "⚠️ الرجاء إدخال رقم بين 1 و 100 فقط!";
    } elseif ($user_guess < $_SESSION['target']) {
        $message = "📈 الرقم صغير جداً! حاول برقم أكبر.";
    } elseif ($user_guess > $_SESSION['target']) {
        $message = "📉 الرقم كبير جداً! حاول برقم أصغر.";
    } else {
        $game_won = true;
        $message = "🎉 مبروك! لقد عرفت الرقم الصحيح ({$_SESSION['target']}) في خلال {$_SESSION['attempts']} محاولات!";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لعبة تخمين الرقم</title>
    <style>
        body {
            font-family: Tahoma, sans-serif;
            background-color: #f4f7f6;
            text-align: center;
            padding-top: 50px;
        }
        .game-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            display: inline-block;
            max-width: 400px;
            width: 100%;
        }
        input[type="number"] {
            padding: 10px;
            font-size: 16px;
            width: 60%;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .reset-btn {
            background-color: #dc3545;
            margin-top: 10px;
        }
        .reset-btn:hover {
            background-color: #c82333;
        }
        .message {
            font-size: 18px;
            margin: 15px 0;
            color: #333;
        }
    </style>
</head>
<body>

<div class="game-container">
    <h2>🎮 لعبة تخمين الرقم</h2>
    <p>أنا أفكّر في رقم بين <strong>1 و 100</strong>. هل يمكنك تخمينه؟</p>

    <?php if (!empty($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <?php if (!$game_won): ?>
        <form method="POST">
            <input type="number" name="guess" min="1" max="100" required autocomplete="off" autofocus>
            <br>
            <button type="submit">تخمين</button>
        </form>
    <?php else: ?>
        <form method="POST">
            <button type="submit" name="reset" class="reset-btn">لعب مرة أخرى 🔄</button>
        </form>
    <?php endif; ?>

    <?php if (!$game_won && isset($_SESSION['attempts']) && $_SESSION['attempts'] > 0): ?>
        <p>عدد المحاولات الحالية: <?php echo $_SESSION['attempts']; ?></p>
    <?php endif; ?>
</div>

</body>
</html>
