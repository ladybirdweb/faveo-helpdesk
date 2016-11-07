<?php

namespace tests\units\Sly\NotificationPusher\Model;

use mageekguy\atoum as Units;
use Sly\NotificationPusher\Model\Message;

/**
 * BaseOptionedModel.
 *
 * @uses atoum\test
 * @author Cédric Dugat <cedric@dugat.me>
 */
class BaseOptionedModel extends Units\Test
{
    public function testMethods()
    {
        $this->if($object = new Message('Test', ['param' => 'test']))
            ->boolean($object->hasOption('param'))
                ->isTrue()
            ->string($object->getOption('param'))
                ->isEqualTo('test')

            ->boolean($object->hasOption('notExist'))
                ->isFalse()
            ->variable($object->getOption('notExist'))
                ->isNull()
            ->string($object->getOption('renotExist', '12345'))
                ->isEqualTo('12345')

            ->when($object->setOptions(['chuck' => 'norris']))
            ->boolean($object->hasOption('chuck'))
                ->isTrue()
            ->string($object->getOption('chuck'))
                ->isEqualTo('norris')

            ->when($object->setOption('poney', 'powerful'))
            ->boolean($object->hasOption('poney'))
                ->isTrue()
            ->string($object->getOption('poney'))
                ->isEqualTo('powerful')

            ->when($object->setOption('null', null))
            ->boolean($object->hasOption('null'))
                ->isTrue()
            ->variable($object->getOption('null'))
                ->isNull()
        ;
    }
}
