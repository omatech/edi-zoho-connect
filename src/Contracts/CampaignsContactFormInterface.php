<?php

namespace Omatech\EdiZohoConnect\Contracts;

interface CampaignsContactFormInterface extends ZohoFormInterface
{
    public function getListId(): string;
}
