<?php

namespace App\DTOs;

class EmployeeDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $description,
        public readonly ?string $photo,
        public readonly array $position,
        public readonly string $biography,
        public readonly string $awards,
        public readonly array $ratings,
        public readonly array $reviews,
        public string $localPhotoPath
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            description: $data['description'] ?? '',
            photo: $data['photo'] ?? null,
            position: $data['position'] ?? [],
            biography: $data['biography'] ?? '',
            awards: $data['awards'] ?? '',
            ratings: $data['ratings'] ?? [],
            reviews: $data['reviews'] ?? [],
            localPhotoPath: $data['localPhotoPath'] ?? ''
        );
    }
}
