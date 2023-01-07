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

namespace Gitonomy\Git;

use Gitonomy\Git\Exception\ProcessException;
use Gitonomy\Git\Exception\ReferenceNotFoundException;

/**
 * Reference in a Git repository.
 *
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 * @author Julien DIDIER <genzo.wm@gmail.com>
 */
abstract class Reference extends Revision
{
    protected $commitHash;

    public function __construct(Repository $repository, $revision, $commitHash = null)
    {
        $this->repository = $repository;
        $this->revision = $revision;
        $this->commitHash = $commitHash;
    }

    /**
     * @return string
     */
    public function getFullname()
    {
        return $this->revision;
    }

    /**
     * @return void
     */
    public function delete()
    {
        $this->repository->getReferences()->delete($this->getFullname());
    }

    /**
     * @return string
     */
    public function getCommitHash()
    {
        if (null !== $this->commitHash) {
            return $this->commitHash;
        }

        try {
            $result = $this->repository->run('rev-parse', ['--verify', $this->revision]);
        } catch (ProcessException $e) {
            throw new ReferenceNotFoundException(sprintf('Can not find revision "%s"', $this->revision));
        }

        return $this->commitHash = trim($result);
    }

    /**
     * @return Commit Commit associated to the reference.
     */
    public function getCommit()
    {
        return $this->repository->getCommit($this->getCommitHash());
    }

    /**
     * @return Commit
     */
    public function getLastModification($path = null)
    {
        return $this->getCommit()->getLastModification($path);
    }
}
