<?php

namespace App\Enum;

enum DocumentState: string
{
    case DRAFT = 'draft';
    case REVIEW = 'review';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';

    public function getTransition() {
        return match($this)
        {
            DocumentState::DRAFT => null,
            DocumentState::REVIEW => 'to_review',
            DocumentState::PUBLISHED => 'to_published',
            DocumentState::ARCHIVED => 'to_archived',
        };
    }
}
