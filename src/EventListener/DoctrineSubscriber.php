<?php

namespace App\EventListener;

use App\Entity\Log;
use Doctrine\ORM\Events;
use Psr\Log\LoggerInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class DoctrineSubscriber implements EventSubscriber
{
    private $logger;

    public function __construct(LoggerInterface $dblogger)
    {
        $this-> logger = $dblogger;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove
        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->log('Ajouté', $args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->log('Modifié', $args);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $this->log('Supprimé', $args);
    }

    public function log($message, $args)
    {
        $entity  = $args->getEntity();
        if(!$entity instanceof log){
            $this-> logger->info($entity->getId() . $message);
        }
       
    }
}