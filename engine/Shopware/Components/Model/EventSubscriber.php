<?php
/**
 * Shopware 4.0
 * Copyright © 2012 shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 *
 * @category   Shopware
 * @package    Shopware_Components_Model
 * @subpackage Model
 * @copyright  Copyright (c) 2012, shopware AG (http://www.shopware.de)
 * @version    $Id$
 * @author     Oliver Denter
 * @author     $Author$
 */

namespace Shopware\Components\Model;

use Doctrine\ORM\Event\LifecycleEventArgs,
//    Doctrine\Common\Persistence\Event\LifecycleEventArgs,
//    Doctrine\Common\Persistence\Event\PreUpdateEventArgs,
    Doctrine\Common\EventSubscriber as BaseEventSubscriber;

/**
 * The Shopware EventSubscriber is an extension of the standard Doctrine EventSubscriber.
 *
 * This subscriber has different event listener functions to trace the LiveCycleEvents of doctrine models and forward them to Enlight Events.
 * Thus it is possible to listen on certain events of specified shopware models.
 *
 * Enlight event listener function can be registered over $this->subscribeEvent();
 * Example:
 *  - Before a new article created (Model: Shopware\Models\Article\Article) we want to call an own function named "beforeAnArticleCreated".
 *
 * - Plugin Solution:
 * $this->subscribeEvent(
 *     $this->createEvent('Shopware\Models\Article\Article::prePersist', 'beforeAnArticleCreated')
 * );
 * </code>
 *
 * - Shopware Core Solution:
 * Shopware()->Subscriber()->subscribeEvent(
 *     new Enlight_Event_EventHandler('Shopware\Models\Article\Article::prePersist', 'beforeAnArticleCreated')
 * );
 */
class EventSubscriber implements BaseEventSubscriber
{
    /**
     * @var \Enlight_Event_EventManager
     */
    protected $eventManager;

    /**
     * Class constructor. Requires the \Enlight_Event_EventManager as argument
     * @param $eventManager
     */
    public function __construct($eventManager)
    {
        $this->eventManager = $eventManager;
    }

    /**
     * Specifies the list of events to listen
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preRemove',
            'preUpdate',
            'postPersist',
            'postUpdate',
            'postRemove'
        );
    }

    /**
     * Event listener function of the preUpdate live cycle event. Fired before an existing model saved.
     *
     * @param LifecycleEventArgs $eventArgs
     * @return \Enlight_Event_EventArgs|null
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entityName = $this->getEntityName($eventArgs->getEntity());
        return $this->notifyEvent($entityName. '::preUpdate', $eventArgs);
    }

    /**
     * Event listener function of the preRemove live cycle event. Fired before an model removed.
     *
     * @param LifecycleEventArgs $eventArgs
     * @return \Enlight_Event_EventArgs|null
     */
    public function preRemove(LifecycleEventArgs $eventArgs)
    {
        $entityName = $this->getEntityName($eventArgs->getEntity());
        return $this->notifyEvent($entityName. '::preRemove', $eventArgs);
    }

    /**
     * Event listener function of the prePersist live cycle event. Fired before a new model saved.
     *
     * @param LifecycleEventArgs $eventArgs
     * @return \Enlight_Event_EventArgs|null
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entityName = $this->getEntityName($eventArgs->getEntity());
        return $this->notifyEvent($entityName. '::prePersist', $eventArgs);
    }

    /**
     * Event listener function of the postUpdateRemove live cycle event. Fired after an existing model saved.
     *
     * @param LifecycleEventArgs $eventArgs
     * @return \Enlight_Event_EventArgs|null
     */
    public function postUpdate(LifecycleEventArgs $eventArgs)
    {
        $entityName = $this->getEntityName($eventArgs->getEntity());
        return $this->notifyEvent($entityName. '::postUpdate', $eventArgs);
    }

    /**
     * Event listener function of the postRemove live cycle event. Fired after a model removed.
     *
     * @param LifecycleEventArgs $eventArgs
     * @return \Enlight_Event_EventArgs|null
     */
    public function postRemove(LifecycleEventArgs $eventArgs)
    {
        $entityName = $this->getEntityName($eventArgs->getEntity());
        return $this->notifyEvent($entityName. '::postRemove', $eventArgs);
    }

    /**
     * Event listener function of the postPersist live cycle event. Fired after a new model saved.
     *
     * @param LifecycleEventArgs $eventArgs
     * @return \Enlight_Event_EventArgs|null
     */
    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        $entityName = $this->getEntityName($eventArgs->getEntity());
        return $this->notifyEvent($entityName. '::postPersist', $eventArgs);
    }

    /**
     * Returns the class name of the passed entity.
     * @param $entity \Shopware\Components\Model\ModelEntity
     * @return string
     */
    protected function getEntityName($entity) {
        if ($entity instanceof \Doctrine\ORM\Proxy\Proxy) {
            $entityName = get_parent_class($entity);
        } else {
            $entityName = get_class($entity);
        }
        return $entityName;
    }

    /**
     * Notify a lifecycleCallback event of doctrine over the enlight event manager
     * @param $eventName string
     * @param $eventArgs LifecycleEventArgs
     * @return \Enlight_Event_EventArgs|null
     */
    protected function notifyEvent($eventName, $eventArgs) {
        return $this->eventManager->notify($eventName, array(
            'entityManager' => $eventArgs->getEntityManager(),
            'entity' => $eventArgs->getEntity()
        ));
    }
}
