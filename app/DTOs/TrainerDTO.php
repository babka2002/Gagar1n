<?php

namespace App\DTOs;

use PHPUnit\Framework\Constraint\IsWritable;

class TrainerDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $last_name,
        public readonly string $second_name,
        public readonly ?string $photo,
        public readonly ?string $description,
        public readonly PositionDTO $position,
        public readonly DepartmentDTO $department,
        public readonly int $timestamp,
        public string $localPhotoPath
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            last_name: $data['last_name'],
            second_name: $data['second_name'],
            photo: $data['photo'],
            description: $data['description'],
            position: PositionDTO::fromArray($data['position']),
            department: DepartmentDTO::fromArray($data['department']),
            timestamp: $data['timestamp'],
            localPhotoPath: $data['localPhotoPath'] = ''
        );
    }
}
