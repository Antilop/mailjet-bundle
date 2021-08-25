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
        array $templateConfiguration,
        array $toList,
        string $subject,
        array $vars
    )
    {
        $templateId = $templateConfiguration['id'];
        $templateFromEmail = $templateConfiguration['from_email'];
        $templateFromName = $templateConfiguration['from_name'];

        $tos = [];
        foreach ($toList as $to) {
            $tos[] = [
                'Email' => $to['email'],
                'Name' => $to['name'],
            ];
        }

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
                        'Email' => $templateFromEmail,
                        'Name' => $templateFromName
                    ],
                    'To' => $tos,
                    'TemplateID' => $templateId,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => $vars
                ]
            ]
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
