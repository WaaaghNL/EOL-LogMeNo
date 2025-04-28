<?php

class Worker {

    private $tenant_id;
    private $tenant_key;
    //Filesystem
    private $fs = array();
    private $fs_root = '/home/USERNAME/domains/logmeno.com/files/';
    private $fs_tenant;
    //FS - Subfolders
    private $fs_secrets;
    private $fs_logs;
    private $fs_backups;
    private $fs_recordings;

    function __construct($id, $key) {
        $this->tenant_id = $id;
        $this->tenant_key = $key;

        //Filesystem
        $this->fs['root'] = $this->fs_root;
        $this->fs['tenant'] = $this->fs_root . $this->tenant_key . '/';
        $this->fs['secrets'] = $this->fs['tenant'] . 'secrets/';
        $this->fs['logs'] = $this->fs['tenant'] . 'logs/';
        $this->fs['rc_stats'] = $this->fs['tenant'] . 'rc_stats/';
        $this->fs['recordings'] = $this->fs['tenant'] . 'recordings/';
        $this->fs['backups'] = $this->fs['tenant'] . 'backups/';
    }

    function __destruct() {

    }

    function get_filesystem() {
        return $this->fs;
    }

    function validate_folder_structure() {
        $tenant = DB::query("SELECT id,tenantkey FROM tenants WHERE tenantkey = %s ORDER BY id ASC LIMIT 1", $this->tenant_key);
        if (!is_null($this->tenant_key) AND count($tenant) == 1) {

            if (!is_dir($this->fs['root'])) {
                mkdir($this->fs['root'], 0755, true);
            }
            if (!is_dir($this->fs['tenant'])) {
                mkdir($this->fs['tenant'], 0755, true);
            }
            if (!is_dir($this->fs['secrets'])) {
                mkdir($this->fs['secrets'], 0755, true);
            }
            if (!is_dir($this->fs['logs'])) {
                mkdir($this->fs['logs'], 0755, true);
            }
            if (!is_dir($this->fs['recordings'])) {
                mkdir($this->fs['recordings'], 0755, true);
            }
            if (!is_dir($this->fs['rc_stats'])) {
                mkdir($this->fs['rc_stats'], 0755, true);
            }
            if (!is_dir($this->fs['backups'])) {
                mkdir($this->fs['backups'], 0755, true);
            }

            return true;
        }
        else {
            return "Tenant key not valid, please check <b>KEY</b>";
        }
    }
}
