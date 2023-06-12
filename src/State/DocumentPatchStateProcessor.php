<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\Document;
use App\ApiResource\UpdateDocumentState;
use App\Enum\DocumentState;
use App\Repository\DocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Workflow\Exception\LogicException;
use Symfony\Component\Workflow\WorkflowInterface;

class DocumentPatchStateProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly DocumentRepository $documentRepository,
        #[Target('document_publishing')]
        private readonly WorkflowInterface  $workflow,
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        assert($data instanceof UpdateDocumentState);

        try {
            $document = $this->documentRepository->find($uriVariables['id']);
            $newState = DocumentState::from($data->getState());

            if (!$newState->getTransition()) {
                throw new BadRequestException('Can\'t apply this transition');
            }
            $this->workflow->apply($document, $newState->getTransition());

            $this->entityManager->persist($document);
            $this->entityManager->flush();

            return new Document(
                id: $document->getId(),
                title: $document->getTitle(),
                content: $document->getContent(),
                author: $document->getAuthor(),
                state: $newState
            );
        } catch (LogicException) {
            throw new BadRequestException('Can\'t apply this transition');
        }

    }
}
