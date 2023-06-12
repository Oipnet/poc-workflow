<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use App\Enum\DocumentState;
use App\State\DocumentPatchStateProcessor;
use App\State\DocumentStateProvider;

#[Get(provider: DocumentStateProvider::class)]
class Document
{
    public function __construct(
        private int $id,
        private string $title,
        private string $content,
        private string $author,
        private DocumentState $state,
    ) {
    }

    /**
     * @return DocumentState
     */
    public function getState(): DocumentState
    {
        return $this->state;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}