<?php

namespace App\DataTransferObjects;

class PostData
{
    public function __construct(public readonly string $title, public readonly string $description)
    {
    }
}
