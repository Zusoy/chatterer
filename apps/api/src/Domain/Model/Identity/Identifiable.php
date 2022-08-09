<?php

namespace Domain\Model\Identity;

interface Identifiable
{
    public function getId(): Identifier;
}
