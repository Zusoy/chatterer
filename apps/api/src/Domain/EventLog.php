<?php

namespace Domain;

interface EventLog
{
    public function record(Event $event): void;
}
