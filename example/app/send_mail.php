<?php
// composer require symfony/mailer
require_once "Config/database.php";
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Cấu hình Twig : composer require twig/twig
$loader = new FilesystemLoader(__DIR__ . '/Views/templates');
$twig = new Environment($loader);
// Dữ liệu cho email
$templateData = [
    'subject' => 'LẬP TRÌNH WEBSITE | HOANGUYENIT',
    'name' => 'Hoà Nguyễn Coder',
    'message' => 'Chuyên trang chia sẻ các kiến thức liên quan đến. 
    Lập Trình Website và Phát triển Website',
];
// Render nội dung email từ template
$htmlContent = $twig->render('email_template.html.twig', $templateData);

//Cài đặt email & password của gmail
$mail_from = "nguyen.thanh.hoa.ctec@gmail.com"; 
$pass = urlencode("password"); 
$mail_to = "example@example.com";

// Chúng ta có thể thêm mail cc vào một mảng
$mail_cc_array=array(
    "example12@example.com",
    "example23@example.com",
);
$transport = Transport::fromDsn("smtp://{$mail_from}:{$pass}@smtp.gmail.com:587?encryption=tls");
$mailer = new Mailer($transport); 
$email = (new Email())
    ->from($mail_from)
    ->to($mail_to)
    //->cc('cc@example.com')            
    ->attachFromPath(__DIR__ . "/Note.txt")
    ->priority(Email::PRIORITY_HIGH)
    ->subject($templateData['subject'])
    ->html($htmlContent); 

// Thêm từng email vào CC
foreach ($mail_cc_array as $ccEmail) {
    $email->addCc($ccEmail);
}
try {
    $mailer->send($email);
    echo "Email sent successfully!";
} catch (\Exception $e) {
    echo "Failed to send email: " . $e->getMessage();
}




