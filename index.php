<?php
// دالة لجلب عنوان الـ IP الحقيقي مع مراعاة بروكسي Render
function getClientIP() {
    $ipaddress = '';
    
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // قد تحتوي هذه الترويسة على عدة عناوين مفصولة بفواصل، الأول هو IP الحقيقي للمستخدم
        $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ipaddress = trim($ipList[0]);
    } else if (isset($_SERVER['REMOTE_ADDR'])) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }
    return $ipaddress;
}

$user_ip = getClientIP();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>معرفة عنوان IP الخاص بك</title>
    <style>
        body {
            font-family: Tahoma, sans-serif;
            background: #0f172a;
            color: #f8fafc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            background: #1e293b;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h2 {
            margin-bottom: 20px;
            color: #38bdf8;
        }
        .ip-box {
            background: #0f172a;
            padding: 15px;
            border-radius: 8px;
            font-size: 24px;
            font-weight: bold;
            color: #4ade80;
            letter-spacing: 1px;
            margin: 20px 0;
            border: 1px dashed #334155;
        }
        p {
            color: #94a3b8;
            font-size: 14px;
        }mv dockerfile Dockerfile
    </style>
</head>
<body>cd path/to/your/project-folder
docker build -f path/to/Dockerfile .
<div class="card">cd path/to/your/project-folder
    <h2>🌐 عنوان IP الخاص بك</h2>
    <p>عنوان الـ IP الذي تتصل به حالياً هو:</p>
    
    <div class="ip-box">
        <?php echo htmlspecialchars($user_ip, ENT_QUOTES, 'UTF-8'); ?>
    </div>
    
    <p>مُستضاف على منصة Render</p>
</div>

</body>
</html>
