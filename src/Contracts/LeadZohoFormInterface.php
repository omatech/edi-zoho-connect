<?php

namespace Omatech\EdiZohoConnect\Contracts;

interface LeadZohoFormInterface extends ZohoFormInterface
{
    public function getNotes(): array;

    public function getFormData(): array;

    public function getFuenteDeFormulario(): string;
}
