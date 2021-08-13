<?php

namespace Antilop\Bundle\MailjetBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MailjetBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
