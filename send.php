<?php
header('Content-Type: application/json');
function errorValidate($data){
    echo json_encode([
        'error' => true,
        'msg' => $data['msg'],
        'field' => $data['field']
    ]);
    exit(200);
}
$name = (!empty($_POST['name']))? trim(strip_tags($_POST['name'])) : errorValidate([
    'msg' => "Name not must be empty",
    'field' => 'name',
]);
$mail = (filter_var($_POST['mail']))? trim(strip_tags($_POST['mail'])) : errorValidate([
    'msg' => "This value isn't correct email",
    'field' => 'mail',
]);
$message = trim(strip_tags($_POST['desc']));
if($_POST['sender'] == 2){
    $mail = mail("test-f867sni01@srv1.mail-tester.com", "Test work #25", "Name: $name \n Email: $mail \n Message: $message");
    if($mail){
        echo json_encode([
            'error' => false,
            'msg' => 'Sent successful. Send with mail',
        ]);
    }else{
        echo json_encode([
            'error' => true,
            'msg' => 'Mail not send. Error function mail',
        ]);
    }
}else{
    $title = "Test work #25 PHPMailer sended";
    $body = "Name: $name \n Email: $mail \n Message: $message";
    require_once 'mailer/Exception.php';
    require_once 'mailer/PHPMailer.php';
    require_once 'mailer/SMTP.php';
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['data']['debug'][] = $str;};
    $mail->Host       = 'smtp.gmail.com';
    $mail->Username   = 'webazex@gmail.com';
    $mail->Password   = 'password';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('webazex@gmail.com', 'Test work #25 PHPMailer sended');
    $mail->addAddress('test-f867sni01@srv1.mail-tester.com');
    $mail->addAddress('webazex@gmail.com');
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;
    if ($mail->send()){
        echo json_encode([
            'error' => false,
            'msg' => 'Sent successful. Send with mailer.',
        ]);
    }else{
        echo json_encode([
            'error' => true,
            'msg' => 'Mail not send. Error mailer',
        ]);
    }
}