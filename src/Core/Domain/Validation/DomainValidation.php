<?php

namespace Core\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;

class DomainValidation
{

    /**
     * @throws EntityValidationException
     */
    public static function notEmpty(string $value, string $exceptMessage = ''): void
    {
        if (empty($value)) {
            throw new EntityValidationException($exceptMessage ?? "Should not be empty or null");
        }
    }

    /**
     * @throws EntityValidationException
     */
    public static function strMaxLength(string $value, string $exceptMessage = '', int $maxLength = 255): void
    {
        if (strlen($value) >= $maxLength) {
            throw new EntityValidationException(
                $exceptMessage ?? "The value must not be greater than {$maxLength} characters");
        }
    }

    /**
     * @throws EntityValidationException
     */
    public static function strMinLength(string $value, string $exceptMessage = '', int $minLength = 2): void
    {
        if (strlen($value) < $minLength) {
            throw new EntityValidationException(
                $exceptMessage ?? "The value must be at least {$minLength} characters");
        }
    }

    /**
     * @throws EntityValidationException
     */
    public static function strCanNullAndMaxLength(string $value = '', string $exceptMessage = '', int $length = 255): void
    {
        if (!empty($value) && strlen($value) > $length) {
            throw new EntityValidationException($exceptMessage ?? "The value must not be greater than {$length} characters");
        }
    }


}