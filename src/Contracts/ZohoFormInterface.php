<?php

namespace Omatech\EdiZohoConnect\Contracts;

use Psr\Http\Message\ResponseInterface;

interface ZohoFormInterface
{
    public function sendToZoho(): ResponseInterface;

    public function getZohoData(): array;
}
