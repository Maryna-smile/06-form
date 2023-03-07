<?php
if (isset ($_POST['contactFF'])) {
  $to = "maryna.naidych@gmail.com";
  $subject = "Заповнена контактная форма на сайті ".$_SERVER['HTTP_REFERER'];
  $message = "Им'я користувача: ".$_POST['nameFF']."\nEmail користувача ".$_POST['contactFF']."\nТелефон користувача ".$_POST['telFF']."\nСообщение: ".$_POST['projectFF']."\n\nАдрес сайта: ".$_SERVER['HTTP_REFERER'];
 
  $boundary = md5(date('r', time()));
  $filesize = '';
  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "From: " . $from . "\r\n";
  $headers .= "Reply-To: " . $from . "\r\n";
  $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
  $message="
Content-Type: multipart/mixed; boundary=\"$boundary\"
 
--$boundary
Content-Type: text/plain; charset=\"utf-8\"
Content-Transfer-Encoding: 7bit
 
$message";
     if(is_uploaded_file($_FILES['fileFF']['tmp_name'])) {
         $attachment = chunk_split(base64_encode(file_get_contents($_FILES['fileFF']['tmp_name'])));
         $filename = $_FILES['fileFF']['name'];
         $filetype = $_FILES['fileFF']['type'];
         $filesize = $_FILES['fileFF']['size'];
         $message.="
 
--$boundary
Content-Type: \"$filetype\"; name=\"$filename\"
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename=\"$filename\"
 
$attachment";
     }
   $message.="
--$boundary--";
 
  if ($filesize < 10000000) { // перевірка загального розміру усіх файлів, багато поштових сервісів не приймають вкладення бвльше 10 МБ
    mail($to, $subject, $message, $headers);
    echo $_POST['nameFF'].'Твоє повідомлення надіслано, дякую!';
  } else {
    echo 'На жаль, твоє повідомлення не надіслано, розмір усіх файлів перевищує 10 МБ.';
  }
}
?>
