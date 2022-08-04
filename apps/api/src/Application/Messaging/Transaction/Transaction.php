<?php

namespace Application\Messaging\Transaction;

interface Transaction
{
    public function begin();

    public function commit();

    public function rollback();
}
