<?php

namespace Antilop\Bundle\MailjetBundle\Provider;

use Antilop\Bundle\MailjetBundle\Client\MailjetClient;
use Mailjet\Resources;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MailjetProvider
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function send(
        int $templateId,
        string $to,
        string $toName,
        string $subject,
        array $vars
    )
    {
        $client = new MailjetClient(
            $this->container->getParameter('mailjet.api_key'),
            $this->container->getParameter('mailjet.secret_key'),
            true,
            ['version' => 'v3.1']
        );

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => $this->container->getParameter('mailjet.from_email'),
                        'Name' => $this->container->getParameter('mailjet.from_name')
                    ],
                    'To' => [
                        [
                            'Email' => $to,
                            'Name' => $toName
                        ]
                    ],
                    'TemplateID' => $templateId,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => $vars
                ]
            ],
            'SandboxMode' => $this->container->getParameter('mailjet.sandbox')
        ];

        $response = $client->post(
            Resources::$Email,
            [
                'body' => $body
            ]
        );

        return $response->getData();
    }
}
