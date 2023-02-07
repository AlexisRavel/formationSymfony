<?php

namespace App\Services;

class RolesHelper {
    private array $rolesHierarchy;
    private array $roles;

    public function __construct(array $rolesHierarchyes) {
        $this->rolesHierarchy = $rolesHierarchyes;
        $this->roles = array();
    }

    public function getRoles() :array {
        if(count($this->roles) > 0) {
            return $this->roles;
        }

        foreach($this->rolesHierarchy as $cleRole => $role) {
            $this->roles[$cleRole] = $role[0];
        }

        return $this->roles;
    }
}

?>