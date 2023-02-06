<?php 

namespace App\Service;

use Mailjet\Client;
use Mailjet\Resources;

class MailService {

    public function send($to_email, $subject, $content)
    {
        $mj = new Client($_ENV['MAILJET_APIKEY'], $_ENV['MAILJET_APISECRET'], true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
            [
                'From' => [
                'Email' => "no-reply@moon-factory.fr",
                'Name' => "Marketplace"
                ],
                'To' => [
                [
                    'Email' => $to_email,
                    'Name' => $to_email
                ]
                ],
                'Subject' => $subject,
                'HTMLPart' => $content,
                // 'Variables' => [
                //     'content' => $content
                // ]
            ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}