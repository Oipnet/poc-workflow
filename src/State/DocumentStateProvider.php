<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\Document;
use App\Enum\DocumentState;
use App\Repository\DocumentRepository;

class DocumentStateProvider implements ProviderInterface
{
    public function __construct(
        private DocumentRepository $documentRepository,
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $document = $this->documentRepository->find($uriVariables['id']);

        if (!$document) {
            return null;
        }

        return new Document(
            id: $document->getId(),
            title: $document->getTitle(),
            content: $document->getContent(),
            author: $document->getAuthor(),
            state: DocumentState::from($document->getState())
        );
    }
}
