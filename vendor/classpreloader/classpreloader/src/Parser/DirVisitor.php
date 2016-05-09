<?php

/*
 * This file is part of Class Preloader.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 * (c) Michael Dowling <mtdowling@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ClassPreloader\Parser;

use ClassPreloader\Exceptions\DirConstantException;
use PhpParser\Node;
use PhpParser\Node\Scalar\MagicConst\Dir as DirNode;
use PhpParser\Node\Scalar\String_ as StringNode;

/**
 * This is the directory node visitor class.
 *
 * This is used to replace all references to __DIR__ with the actual directory.
 */
class DirVisitor extends AbstractNodeVisitor
{
    /**
     * Should we skip the file if it contains a dir constant?
     *
     * @var bool
     */
    protected $skip = false;

    /**
     * Create a new directory visitor instance.
     *
     * @param bool $skip
     *
     * @return void
     */
    public function __construct($skip = false)
    {
        $this->skip = $skip;
    }

    /**
     * Enter and modify the node.
     *
     * @param \PhpParser\Node $node
     *
     * @throws \ClassPreloader\Exceptions\DirConstantException
     *
     * @return \PhpParser\Node\Scalar\String_|null
     */
    public function enterNode(Node $node)
    {
        if ($node instanceof DirNode) {
            if ($this->skip) {
                throw new DirConstantException();
            }

            return new StringNode($this->getDir());
        }
    }
}
