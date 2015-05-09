<?php
namespace AppBundle\Factory;

use AppBundle\Entity\User;
use Symfony\Component\Config\Definition\Exception\Exception;

class EntityFactory
{
    const ENTITY_NAME_USER = "user_entity";

    /**
     * @param $entityType
     * @return User|null
     */
    public function createEntity($entityType)
    {
        switch($entityType){
            case self::ENTITY_NAME_USER:
                $entity = new User();
                break;
            default:
                throw new Exception('Not possible create Entity');
                break;
        }

        return $entity;
    }
}
