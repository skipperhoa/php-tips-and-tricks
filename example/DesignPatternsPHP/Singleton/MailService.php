<?php 
    // Chúng ta có thể cấu hình namespace cho ok hơn, vì mình test nên để require_once đến thư viện
    require_once "../../../vendor/autoload.php";
    use Symfony\Component\Mailer\Transport;
    use Symfony\Component\Mailer\Mailer;
    use Symfony\Component\Mime\Email;
    use Twig\Environment;
    use Twig\Loader\FilesystemLoader;
    class MailService{
        private static $instance = null;
        private $transport = null;
        private $mail_from = ""; // nhập mail parent
        private $pass = ""; // password mail parent
        private $mailer = null;
        private function __construct(){
            try { 
                $this->transport =Transport::fromDsn("smtp://{$this->mail_from}:{$this->pass}@smtp.gmail.com:587?encryption=tls");
            
                $this->mailer = new Mailer($this->transport);
            } catch (\PDOException $e) {
                throw new Exception($e->getMessage());
            }
        }

        public static function getInstance(){   
            if(self::$instance === null){
                // Đang khởi tạo instance duy nhất
                self::$instance = new MailService();
            }
            // Đối tượng đã được tạo
            return self::$instance;

        }
        
        public function sendEmail(Array $data) : Array{
            try {
                $email = new Email();
                $email->from($this->mail_from);
                $email->to($data['email']);
                $email->subject($data['subject']);
                $email->text($data['message']);
                if($data['file'] != null){
                    $email->attachFromPath($data['file']);
                }
                $this->mailer->send($email);
                $data['status'] = 'success';
                return json_decode(json_encode($data), true, 512, JSON_THROW_ON_ERROR);
            }
            catch (\Exception $e) {
                $data['status'] = 'error';
                $data['message'] = $e->getMessage();
                return json_decode(json_encode($data), true, 512, JSON_THROW_ON_ERROR);
            }
           
        }

    }

$mail = MailService::getInstance();
$mail2 = MailService::getInstance();

var_dump($mail === $mail2); //true

$mail->sendEmail([
    'subject' => 'LẬP TRÌNH WEBSITE | HOANGUYENIT',
    'email' => 'nguyen.thanh.hoa.ctec@gmail.com',
    'message' => 'Chuyên trang chia sẻ các kiến thức liên quan đến. Lập Trình Website và Phát triển Website',
    'file' => null
])

?>