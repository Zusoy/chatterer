<?php

namespace Domain\Identity;

interface Identifiable
{
    public function getIdentifier(): Identifier;
}
