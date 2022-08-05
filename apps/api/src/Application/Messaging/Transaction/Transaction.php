<?php

namespace Application\Messaging\Transaction;

interface Transaction
{
    public function begin(): void;

    public function commit(): void;

    public function rollback(): void;
}
