<?php

namespace SSRouter\UnitTest;

class ControllerOne
{
    public function index(): string
    {
        return 'success';
    }

    public function update(): string
    {
        return 'success';
    }

    public function delete(): string
    {
        return 'success';
    }

    public function another(): string
    {
        return 'success';
    }

    public function dummy(): string
    {
        return 'success';
    }
}
