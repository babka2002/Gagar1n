<?php

namespace App\DTOs;

class PositionDTO
{
    public function __construct(
        public readonly ?string $id,
        public readonly ?string $title,
    ) {}

    public static function fromArray(?array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            title: $data['title'] ?? null,
        );
    }
}
