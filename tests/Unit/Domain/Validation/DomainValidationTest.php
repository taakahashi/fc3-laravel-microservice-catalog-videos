<?php

namespace Tests\Unit\Domain\Validation;

use PHPUnit\Framework\TestCase;
use Core\Domain\Validation\DomainValidation;
use Core\Domain\Exception\EntityValidationException;
use Throwable;

class DomainValidationTest extends TestCase
{

    public function testNotEmpty()
    {
        try {
            DomainValidation::notEmpty('');

            static::fail();
        } catch (Throwable $th) {
            static::assertInstanceOf(EntityValidationException::class, $th);
        }

    }

    public function testNotEmptyWithCustomMessageException()
    {
        try {
            DomainValidation::notEmpty('', 'custom');

            static::fail();
        } catch (Throwable $th) {
            static::assertInstanceOf(EntityValidationException::class, $th, 'custom');
        }
    }

    public function testStrMaxLength()
    {
        try {
            DomainValidation::strMaxLength('teste', 'custom', 3);

            static::fail();
        } catch (Throwable $th) {
            static::assertInstanceOf(EntityValidationException::class, $th, 'custom');
        }
    }

    public function testStrMinLength()
    {
        try {
            DomainValidation::strMinLength('teste', 'custom', 8);

            static::fail();
        } catch (Throwable $th) {
            static::assertInstanceOf(EntityValidationException::class, $th, 'custom');
        }
    }

    public function testStrCanNullAndMaxLength()
    {
        try {
            DomainValidation::strCanNullAndMaxLength('teste', 'custom', 3);

            $this->fail();
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'custom');
        }
    }



}