<?php

namespace MDQ\GeneBundle\Services;

use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use MDQ\UserBundle\Entity\User;

class RoleService
{
    private $roleHierarchy;

    /**
     * Constructor
     *
     * @param RoleHierarchyInterface $roleHierarchy
     */
    public function __construct(RoleHierarchyInterface $roleHierarchy)
    {
        $this->roleHierarchy = $roleHierarchy;
    }

    /**
     * isGranted
     *
     * @param string $role
     * @param $user
     * @return bool
     */
    public function isGranted($role, User $user) {

        if($user===Null){return false;}
        $role = new Role($role);

        foreach($user->getRoles() as $userRole) {
            if (in_array($role, $this->roleHierarchy->getReachableRoles(array(new Role($userRole)))))
                return true;
        }

        return false;
    }
}

// Pris sur internet : permet lors du test du role d'avoir aussi la hiérarchei, par ex admin est compté dans super admin.

