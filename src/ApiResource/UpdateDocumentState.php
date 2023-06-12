<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\Patch;
use App\State\DocumentPatchStateProcessor;
use App\State\DocumentStateProvider;

#[Patch(
    uriTemplate: '/documents/{id}/state',
    input: UpdateDocumentState::class,
    output: Document::class,
    read: false,
    processor: DocumentPatchStateProcessor::class,
)]
class UpdateDocumentState
{
    public function __construct(
        private readonly string $state,
    )
    {
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }
}