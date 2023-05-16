<?php

declare(strict_types=1);

namespace Domain\Security;

enum Operation: string
{
    case USER_CREATE = 'user:create';
    case USER_LIST = 'user:list';

    case CREATE_STATION = 'station:create';
    case UPDATE_STATION = 'station:update';
    case DELETE_STATION = 'station:delete';
    case INVITE_STATION = 'station:invite';
    case LIST_STATION_CHANNELS = 'station:list_channels';
    case LIST_STATION_USERS = 'station:list_users';

    case CREATE_CHANNEL = 'channel:create';
    case UPDATE_CHANNEL = 'channel:update';
    case DELETE_CHANNEL = 'channel:delete';
    case JOIN_CHANNEL = 'channel:join';
    case LIST_USERS_CHANNEL = 'channel:list_users';

    case CREATE_MESSAGE = 'message:create';
    case DELETE_MESSAGE = 'message:delete';

    case DELETE_INVITATION = 'invitation:delete';
}
