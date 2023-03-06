<?php

namespace Omatech\EdiZohoConnect\Contracts;

interface CampaignsZohoFormInterface extends ZohoFormInterface
{
    public function getListId(): string;
}
