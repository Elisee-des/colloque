<?php

namespace App\Service;

/*
This call sends a message based on a template.
*/
require 'vendor/autoload.php';

use Mailjet\Client;
use \Mailjet\Resources;

class SenderMailService
{
    private $api_key = "c0d9f349bae53af4eca67c95b6d1e598";
    private $api_key_private = "bd632692f6ec5b5532884326095a6d19";

    public function send($email, $nom, $subject, $message)
    {
        $mj = new Client($this->api_key, $this->api_key_private, true, ['version' => 'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "yentemasabidani@gmail.com",
                        'Name' => "Yentema"
                    ],
                    'To' => [
                        [
                            'Email' => $email,
                            'Name' => $nom
                        ]
                    ],
                    'TemplateID' => 4578215,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'context' => $message
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && var_dump($response->getData());
    }

    public function sendFromAdmin($mailTo, $nom,  $subject, $message)
    {
        $mj = new Client($this->api_key, $this->api_key_private, true, ['version' => 'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "yentemasabidani@gmail.com",
                        'Name' => "Yentema"
                    ],
                    'To' => [
                        [
                            'Email' => $mailTo,
                            'Name' => $nom
                        ]
                    ],
                    'TemplateID' => 4046162,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'context' => $message
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && var_dump($response->getData());
    }

    public function sendMailToAdmin($subject, $message)
    {
        $mj = new Client($this->api_key, $this->api_key_private, true, ['version' => 'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "yentemasabidani@gmail.com",
                        'Name' => "Yentema"
                    ],
                    'To' => [
                        [
                            'Email' => 'yentemasabidani@gmail.com',
                            'Name' => 'Yentema'
                        ]
                    ],
                    'TemplateID' => 4046162,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'context' => $message
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && var_dump($response->getData());
    }
}
