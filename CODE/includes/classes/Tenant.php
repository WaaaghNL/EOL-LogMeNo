<?php

class Tenant {

    private $name;
    private $timezone;
    private $maxage;
    private $tenant_id;
    private $tenant_key;

    private function genKey() {
        $key = substr(uniqid(), -8);
        //Select from

        $keyCount = DB::query("SELECT tenantkey FROM tenants WHERE tenantkey=%s", $key);
        if (count($keyCount) === 0) {
            return $key;
        }
        else {
            $this->genKey();
        }
    }

    function validateTenantKey($key) {
        if (preg_match('/^[a-zA-Z0-9]{8}$/', $tenant)) {
            $this->get_tenant_by_key($key);
        }
        else {
            return false;
        }
    }

    function find_tenant($tenant = null) {
        if (is_numeric($tenant)) {
            //Check if tenant exists by id
            return $this->get_tenant_by_id($tenant);
        }
        elseif (preg_match('/^[a-zA-Z0-9]{8}$/', $tenant)) {
            //check if tenant exists by key
            return $this->get_tenant_by_key($tenant);
        }
        else {
            return false;
        }
    }

    private function get_tenant_by_id($id) {
        if (is_numeric($id)) {
            $tenant = DB::query("SELECT id,tenantkey FROM tenants WHERE id = %i ORDER BY name ASC LIMIT 1", $id);
            if (count($tenant) == 1) {
                return $tenant[0];
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    private function get_tenant_by_key($key) {
        if (ctype_alnum($key)) {
            $tenant = DB::query("SELECT id,tenantkey FROM tenants WHERE tenantkey = %s ORDER BY name ASC LIMIT 1", $key);
            if (count($tenant) == 1) {
                return $tenant[0];
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
    
    function listTenants() {
        $tenants = DB::query("SELECT * FROM tenants");
        if (count($tenants) != 0) {
            return $tenants;
        }
        else {
            return false;
        }
    }

    function createTenant($name) {

    }

    function destroyTenant($id) {

    }
}
