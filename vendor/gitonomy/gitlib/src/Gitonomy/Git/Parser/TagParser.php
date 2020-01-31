<?php

/**
 * This file is part of Gitonomy.
 *
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 * (c) Julien DIDIER <genzo.wm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Gitonomy\Git\Parser;

use Gitonomy\Git\Exception\RuntimeException;

class TagParser extends ParserBase
{
    public $object;
    public $type;
    public $tag;
    public $taggerName;
    public $taggerEmail;
    public $taggerDate;
    public $gpgSignature;
    public $message;

    protected function doParse()
    {
        $this->consume('object ');
        $this->object = $this->consumeHash();
        $this->consumeNewLine();

        $this->consume('type ');
        $this->type = $this->consumeTo("\n");
        $this->consumeNewLine();

        $this->consume('tag ');
        $this->tag = $this->consumeTo("\n");
        $this->consumeNewLine();

        $this->consume('tagger ');
        list($this->taggerName, $this->taggerEmail, $this->taggerDate) = $this->consumeNameEmailDate();
        $this->taggerDate = $this->parseDate($this->taggerDate);

        $this->consumeNewLine();
        $this->consumeNewLine();

        try {
            $this->message = $this->consumeTo('-----BEGIN PGP SIGNATURE-----');
            $this->gpgSignature = $this->consumeGPGSignature();
        } catch (RuntimeException $e) {
            $this->message = $this->consumeAll();
        }
    }

    protected function consumeGPGSignature()
    {
        $expected = '-----BEGIN PGP SIGNATURE-----';
        $length = strlen($expected);
        $actual = substr($this->content, $this->cursor, $length);
        if ($actual != $expected) {
            return '';
        }
        $this->cursor += $length;

        return $this->consumeTo('-----END PGP SIGNATURE-----');
    }

    protected function consumeNameEmailDate()
    {
        if (!preg_match('/(([^\n]*) <([^\n]*)> (\d+ [+-]\d{4}))/A', $this->content, $vars, 0, $this->cursor)) {
            throw new RuntimeException('Unable to parse name, email and date');
        }

        $this->cursor += strlen($vars[1]);

        return [$vars[2], $vars[3], $vars[4]];
    }

    protected function parseDate($text)
    {
        $date = \DateTime::createFromFormat('U e O', $text.' UTC');

        if (!$date instanceof \DateTime) {
            throw new RuntimeException(sprintf('Unable to convert "%s" to datetime', $text));
        }

        return $date;
    }
}
