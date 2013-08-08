<?php

namespace abstraction\xysLibrary\validate;

use abstraction\business\exception\ExceptionBusiness;

class ValidationEntity
{
    private $reflection;

    private $result;

    public function __construct (\abstraction\entity\AbstractEntity $entity)
    {
        $this->reflection = new \abstraction\xysLibrary\annotation\ReflectionAnnotatedClass($entity);
    }

    public function validateEntity ()
    {
        $colum = $this->reflection->getAnnotations('ORM\Column');
        var_dump($colum); exit;
    }

    private function validInteger ()
    {

    }

    private function addMessage ($message)
    {
        $this->result[] = $message;
    }

    public function exceptionMessages ()
    {
        if (0 < count($this->result)) {
            throw new ExceptionBusiness(implode('|', $this->result));
        }
    }
}