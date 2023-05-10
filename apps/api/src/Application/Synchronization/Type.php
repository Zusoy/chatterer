<?php

declare(strict_types=1);

namespace Application\Synchronization;

enum Type: string
{
    case INSERT = 'push.insert';
    case UPDATE = 'push.update';
    case DELETE = 'push.delete';
}
