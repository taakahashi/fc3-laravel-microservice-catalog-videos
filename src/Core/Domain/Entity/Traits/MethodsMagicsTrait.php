<?php

namespace Core\Domain\Entity\Traits;

use Exception;

trait MethodsMagicsTrait
{
    /**
     * @throws Exception
     */
    public function __get($property)
    {
        if(isset($this->{$property})) {
            return $this->{$property};
        }

        $class = get_class($this);
        throw new Exception("Property {$property} not found in {$class}");
    }

    public function id(): string
    {
        return (string) $this->id;
    }

    public function createdAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }
}
