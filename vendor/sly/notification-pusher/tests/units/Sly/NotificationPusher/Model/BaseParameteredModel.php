<?php

namespace tests\units\Sly\NotificationPusher\Model;

use mageekguy\atoum as Units;
use Sly\NotificationPusher\Model\Device;

/**
 * BaseParameteredModel.
 *
 * @uses atoum\test
 * @author Cédric Dugat <cedric@dugat.me>
 */
class BaseParameteredModel extends Units\Test
{
    public function testMethods()
    {
        $this->if($object = new Device('Test', ['param' => 'test']))
            ->boolean($object->hasParameter('param'))
                ->isTrue()
            ->string($object->getParameter('param'))
                ->isEqualTo('test')

            ->boolean($object->hasParameter('notExist'))
                ->isFalse()
            ->variable($object->getParameter('notExist'))
                ->isNull()
            ->string($object->getParameter('renotExist', '12345'))
                ->isEqualTo('12345')

            ->when($object->setParameters(['chuck' => 'norris']))
            ->boolean($object->hasParameter('chuck'))
                ->isTrue()
            ->string($object->getParameter('chuck'))
                ->isEqualTo('norris')

            ->when($object->setParameter('poney', 'powerful'))
            ->boolean($object->hasParameter('poney'))
                ->isTrue()
            ->string($object->getParameter('poney'))
                ->isEqualTo('powerful')

            ->when($object->setParameter('null', null))
            ->boolean($object->hasParameter('null'))
                ->isTrue()
            ->variable($object->getParameter('null'))
                ->isNull()
        ;
    }
}
