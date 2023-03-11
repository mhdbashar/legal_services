<?php

namespace app\services\messages;

defined('BASEPATH') or exit('No direct script access allowed');

use app\services\messages\AbstractPopupMessage;

class FirstTicketCreated extends AbstractPopupMessage
{
    public function isVisible(...$params)
    {
        $ticket_id = $params[0];

        return $ticket_id == 1;
    }

    public function getMessage(...$params)
    {
        return _l('first_ticket_created_alert');
    }
}
