<?php

namespace SSRouter\UnitTest;

class ControllerTwo
{
    public function slug(string $slug): string
    {
        return $slug;
    }

    public function update(int $id): int
    {
        return $id;
    }

    public function delete(int $id): int
    {
        return $id;
    }

    public function post(): string
    {
        return 'success';
    }
}
