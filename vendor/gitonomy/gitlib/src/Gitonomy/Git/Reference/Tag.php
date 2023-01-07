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

namespace Gitonomy\Git\Reference;

use Gitonomy\Git\Commit;
use Gitonomy\Git\Exception\ProcessException;
use Gitonomy\Git\Exception\RuntimeException;
use Gitonomy\Git\Parser\ReferenceParser;
use Gitonomy\Git\Parser\TagParser;
use Gitonomy\Git\Reference;

/**
 * Representation of a tag reference.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 * @author Bruce Wells <brucekwells@gmail.com>
 */
class Tag extends Reference
{
    protected $data;

    public function getName()
    {
        if (!preg_match('#^refs/tags/(.*)$#', $this->revision, $vars)) {
            throw new RuntimeException(sprintf('Cannot extract tag name from "%s"', $this->revision));
        }

        return $vars[1];
    }

    /**
     * Check if tag is annotated.
     *
     * @return bool
     */
    public function isAnnotated()
    {
        try {
            $this->repository->run('cat-file', ['tag', $this->revision]);
        } catch (ProcessException $e) {
            return false; // Is not an annotated tag
        }

        return true;
    }

    /**
     * Returns the actual commit associated with the tag, and not the hash of the tag if annotated.
     *
     * @return Commit
     */
    public function getCommit()
    {
        if ($this->isAnnotated()) {
            try {
                $output = $this->repository->run('show-ref', ['-d', '--tag', $this->revision]);
                $parser = new ReferenceParser();
                $parser->parse($output);

                foreach ($parser->references as list($row)) {
                    $commitHash = $row;
                }

                return $this->repository->getCommit($commitHash);
            } catch (ProcessException $e) {
                // ignore the exception
            }
        }

        return parent::getCommit();
    }

    /**
     * Returns the tagger name.
     *
     * @return string A name
     */
    public function getTaggerName()
    {
        return $this->getData('taggerName');
    }

    /**
     * Returns the comitter email.
     *
     * @return string An email
     */
    public function getTaggerEmail()
    {
        return $this->getData('taggerEmail');
    }

    /**
     * Returns the authoring date.
     *
     * @return \DateTime A time object
     */
    public function getTaggerDate()
    {
        return $this->getData('taggerDate');
    }

    /**
     * Returns the message of the commit.
     *
     * @return string A tag message
     */
    public function getMessage()
    {
        return $this->getData('message');
    }

    /**
     * Returns the subject message (the first line).
     *
     * @return string The subject message
     */
    public function getSubjectMessage()
    {
        return $this->getData('subjectMessage');
    }

    /**
     * Return the body message.
     *
     * @return string The body message
     */
    public function getBodyMessage()
    {
        return $this->getData('bodyMessage');
    }

    /**
     * Return the GPG signature.
     *
     * @return string The GPG signature
     */
    public function getGPGSignature()
    {
        return $this->getData('gpgSignature');
    }

    /**
     * Check whether tag is signed.
     *
     * @return bool
     */
    public function isSigned()
    {
        try {
            $this->getGPGSignature();

            return true;
        } catch (\InvalidArgumentException $e) {
            return false;
        }
    }

    private function getData($name)
    {
        if (!$this->isAnnotated()) {
            return false;
        }

        if (isset($this->data[$name])) {
            return $this->data[$name];
        }

        if ($name === 'subjectMessage') {
            $lines = explode("\n", $this->getData('message'));
            $this->data['subjectMessage'] = reset($lines);

            return $this->data['subjectMessage'];
        }

        if ($name === 'bodyMessage') {
            $message = $this->getData('message');

            $lines = explode("\n", $message);

            array_shift($lines);
            array_pop($lines);

            $data['bodyMessage'] = implode("\n", $lines);

            return $data['bodyMessage'];
        }

        $parser = new TagParser();
        $result = $this->repository->run('cat-file', ['tag', $this->revision]);

        $parser->parse($result);

        $this->data['taggerName'] = $parser->taggerName;
        $this->data['taggerEmail'] = $parser->taggerEmail;
        $this->data['taggerDate'] = $parser->taggerDate;
        $this->data['message'] = $parser->message;
        $this->data['gpgSignature'] = $parser->gpgSignature;

        if (!isset($this->data[$name])) {
            throw new \InvalidArgumentException(sprintf('No data named "%s" in Tag.', $name));
        }

        return $this->data[$name];
    }
}
