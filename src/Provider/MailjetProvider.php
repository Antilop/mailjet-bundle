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

    private function getClient($version = '3') {
        return new MailjetClient(
            $this->container->getParameter('mailjet.api_key'),
            $this->container->getParameter('mailjet.secret_key'),
            true,
            ['version' => 'v' . $version]
        );
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
                    'Variables' => $vars,
                ]
            ],
        ];

        $response = $this->getClient('3.1')->post(
            Resources::$Email,
            [
                'body' => $body
            ]
        );

        return $response->getData();
    }

    public function createContact($name, $email)
    {
        $response = $this->getClient()->post(
            Resources::$Contact,
            [
                'body' => [
                    'Name' => $name,
                    'email' => $email
                ]
            ]
        );

        return $response->getData();
    }

    public function updateContactData($id, $data)
    {
        $response = $this->getClient()->put(
            Resources::$Contactdata,
            [
                'id' => $id,
                'body' => [
                    'Data' => $data
                ]
            ]
        );

        return $response->getData();
    }

    public function manageContactsListsByContact($id, $contactsLists)
    {
        $response = $this->getClient()->post(
            Resources::$ContactManagecontactslists,
            [
                'id' => $id,
                'body' => [
                    'ContactsLists' => $contactsLists
                ]
            ]
        );

        return $response->getData();
    }

    public function getContactsListsByContact($id)
    {
        $response = $this->getClient()->get(
            Resources::$ContactGetcontactslists,
            [
                'id' => $id
            ]
        );

        return $response->getData();
    }

    public function getContactsList($id)
    {
        $response = $this->getClient()->get(
            Resources::$Contactslist,
            [
                'id' => $id
            ]
        );

        return $response->getData();
    }
}
