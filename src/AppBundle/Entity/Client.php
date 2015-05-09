<?php
namespace AppBundle\Entity;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Client extends BaseClient
{
    const ROLE_WEB = "ROLE_WEB";
    const ROLE_MOBILE = "ROLE_MOBILE";

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $role;

    /**
     * @param string $role ( ROLE_WEB | ROLE_MOBILE )
     */
    public function __construct($role=self::ROLE_WEB)
    {
        parent::__construct();

        if($role == self::ROLE_WEB) {
            $this->role = self::ROLE_MOBILE;
        }else{
            $this->role = self::ROLE_WEB;
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }
}