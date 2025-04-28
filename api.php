<?php
// קבלת הטקסט מהשלוחה
$text = $_GET['text'] ?? '';

if (empty($text)) {
    echo "לא נשלח טקסט לעיבוד.";
    exit;
}

// חיבור ל-API של דיפסיק
$apiKey = "sk-c142aa2c43134126a414e72581f3ba84";
$url = "https://api.deepsick.com/v1/process"; // שנה לפי ה-API הנכון

$data = [
    'text' => $text
];

$headers = [
    'Authorization: Bearer ' . $apiKey,
    'Content-Type: application/json'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "הייתה שגיאה בחיבור לשירות החיצוני.";
    exit;
}

curl_close($ch);

// עיבוד תגובה
$result = json_decode($response, true);

if (isset($result['error'])) {
    echo "שגיאה מהשירות: " . $result['error'];
} elseif (isset($result['response'])) {
    echo $result['response']; // החזרת תשובת דיפסיק
} else {
    echo "לא התקבלה תשובה תקינה מהשירות.";
}
?>
