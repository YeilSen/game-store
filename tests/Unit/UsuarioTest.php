<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class UsuarioTest extends TestCase
{
    public function test_correo_valido()
    {
        $correo = "usuario@correo.com";

        $this->assertMatchesRegularExpression(
            "/^[^@\s]+@[^@\s]+\.[^@\s]+$/",
            $correo
        );
    }
}