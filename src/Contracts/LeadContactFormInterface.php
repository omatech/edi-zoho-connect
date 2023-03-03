<?php

namespace Omatech\EdiZohoConnect\Contracts;

interface LeadContactFormInterface extends ZohoFormInterface
{
    public function getNotes(): array;

    public function getFormData(): array;

    public function getFuenteDeFormulario(): string;
}
