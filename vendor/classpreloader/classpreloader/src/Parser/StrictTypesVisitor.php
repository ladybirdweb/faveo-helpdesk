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

use ClassPreloader\Exceptions\StrictTypesException;
use PhpParser\Node;
use PhpParser\Node\Stmt\DeclareDeclare;

/**
 * This is the strict types visitor class.
 *
 * This allows us to identify files containing stict types declorations.
 */
class StrictTypesVisitor extends AbstractNodeVisitor
{
    /**
     * Enter and modify the node.
     *
     * @param \PhpParser\Node $node
     *
     * @throws \ClassPreloader\Exceptions\StrictTypesException
     *
     * @return null
     */
    public function enterNode(Node $node)
    {
        if ($node instanceof DeclareDeclare && ($node->getLine() === 1 || $node->getLine() === 2)) {
            throw new StrictTypesException();
        }
    }
}
