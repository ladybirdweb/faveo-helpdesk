<?php

namespace App\Http\Controllers\Agent\helpdesk;

use PhpImap\Mailbox;

class ImapMail extends Mailbox
{
    public function get_overview($mailId)
    {
        $overview = imap_fetch_overview($this->getImapStream(), $mailId, FT_UID);

        return $overview;
    }

    /**
     * This function uses imap_search() to perform a search on the mailbox currently opened in the given IMAP stream.
     * For example, to match all unanswered mails sent by Mom, you'd use: "UNANSWERED FROM mom".
     *
     * @param string $criteria See http://php.net/imap_search for a complete list of available criteria
     *
     * @return array mailsIds (or empty array)
     */
    public function searchMailbox($criteria = 'ALL')
    {
        //dd($this->getImapStream());
        $mailsIds = imap_search($this->getImapStream(), $criteria, SE_UID);
        //dd($mailsIds);
        return $mailsIds ? $mailsIds : [];
    }
}
