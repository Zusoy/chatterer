<?php

namespace Domain;

interface Bus
{
    /**
     * Executes a message and optionnaly returns the output of the handler.
     *
     * @return mixed
     */
    public function execute(Message $message): mixed;
}
