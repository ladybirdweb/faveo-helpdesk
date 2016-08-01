<?php

namespace App\Http\Controllers\Agent\helpdesk;

use PhpImap\Mailbox;

class ImapMail extends Mailbox {

    public function get_overview($mailId) {
        $overview = imap_fetch_overview($this->getImapStream(), $mailId, FT_UID);
        return $overview;
    }

}
