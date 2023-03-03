<?php

namespace Omatech\EdiZohoConnect\Contracts;

use Psr\Http\Message\ResponseInterface;

interface ZohoFormInterface
{
    public function getFormType(): string;

    public function sendToZoho(): ResponseInterface;
}
