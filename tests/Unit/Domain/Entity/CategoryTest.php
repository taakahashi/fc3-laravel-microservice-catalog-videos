<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Category;
use Core\Domain\Exception\EntityValidationException;
use Ramsey\Uuid\Uuid;
use PHPUnit\Framework\TestCase;
use Throwable;

class CategoryTest extends TestCase
{

    public function testAttributes()
    {
        $category = new Category(
            name: 'Terror',
            description: 'Desc',
            isActive: true
        );

        //var_dump($category);
        self::assertNotEmpty($category->id);
        self::assertNotEmpty($category->createdAt());
        self::assertEquals('Terror', $category->name);
        self::assertEquals('Desc', $category->description);
        self::assertTrue($category->isActive);
    }

    public function testActivated()
    {
        $category = new Category(
            name: 'Terror',
            isActive: false
        );

        self::assertFalse($category->isActive);

        $category->activate();

        self::assertTrue($category->isActive);
    }

    public function testDisabled()
    {
        $category = new Category(
            name: 'Terror',
            isActive: true
        );

        self::assertTrue($category->isActive);

        $category->disable();

        self::assertFalse($category->isActive);
    }

    public function testUpdate()
    {
        $uuid = Uuid::uuid4()->toString();

        $category = new Category(
            id: $uuid,
            name: 'Terror',
            description: 'Desc Terror',
            isActive: true,
            createdAt: '2022-01-01 12:12:12'
        );

        $category->update(
            name: 'new_name',
            description: 'new_desc'
        );

        static::assertEquals($uuid, $category->id);
        static::assertEquals('new_name', $category->name);
        static::assertEquals('new_desc', $category->description);
    }

    public function testExceptionName()
    {
        try {
            $category = new Category(
                name: 'T',
                description: 'Desc Terror'
            );

            static::fail();
        } catch (Throwable $throwable) {
            static::assertInstanceOf(EntityValidationException::class, $throwable);
        }
    }

    public function testExceptionDescription()
    {
        try {
            $category = new Category(
                name: 'T',
                description: 'EntityValidationExceptionEntityValidationExceptionEntityValidationExceptionEntityValidationExceptionEntityValidationExceptionEntityValidationExceptionEntityValidationExceptionEntityValidationExceptionEntityValidationExceptionEntityValidationExceptionEntityValidationExceptionEntityValidationException'
            );

            static::fail();
        } catch (Throwable $throwable) {
            static::assertInstanceOf(EntityValidationException::class, $throwable);
        }
    }

}
