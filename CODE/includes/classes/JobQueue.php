<?php

class JobQueue {

    private $tenant_id;
    private $tenant_key;
    private $tenant_jwt;
    private $override = false;
    private $overrideJob = null;

    function __construct($tenant = null) {
        if (!is_null($tenant)) {
            $this->find_tenant($tenant);
        }
    }

    function overideEnable($tenant, $job) {
        $this->override = true;
        $this->overrideJob = $job;
        $this->find_tenant($tenant);
    }

    function overrideStatus() {
        return $this->override;
    }

    private function showPrivate() { //change to a normal function while debugging
        echo $this->tenant_id . "<br />";
        echo $this->tenant_key . "<br />";
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
            $tenant = DB::query("SELECT id,tenantkey,ringcentral_jwt FROM tenants WHERE id = %i ORDER BY name ASC LIMIT 1", $id);
            if (count($tenant) == 1) {
                $this->tenant_id = $tenant[0]['id'];
                $this->tenant_key = $tenant[0]['tenantkey'];
                $this->tenant_jwt = $tenant[0]['ringcentral_jwt'];
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
            $tenant = DB::query("SELECT id,tenantkey,ringcentral_jwt FROM tenants WHERE tenantkey = %s ORDER BY name ASC LIMIT 1", $key);
            if (count($tenant) == 1) {
                $this->tenant_id = $tenant[0]['id'];
                $this->tenant_key = $tenant[0]['tenantkey'];
                $this->tenant_jwt = $tenant[0]['ringcentral_jwt'];
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

    /**
     * Add job to the queue
     *
     */
    function createJob($tenant, $type, $offset = 60) {
        if (!$this->override) {
//Only create job while override is false
            $jobsWaiting = DB::query("SELECT id FROM worker_jobs WHERE status = %s AND type = %s AND tenant = %i", 'Pending', $type, $tenant);

            if (count($jobsWaiting) === 0) {

                echo "Create Job<br />";
                $nexttime = time() + ($offset * 60);
                DB::insert('worker_jobs', array(
                    'status' => 'Pending',
                    'tenant' => $tenant,
                    'type' => $type,
                    'startAfter' => $nexttime,
                    'after' => date('Y-m-d H:i:s', $nexttime),
                ));

                $insert_id = DB::insertId(); // which id did it choose?!? tell me!!
                echo "Job created with ID: " . $insert_id . " <br />";
            }
        }
    }

    /**
     * Claim a job, it selects a job from the queue and sets te status from pending to In Progress
     * Returns false if no jobs
     * Returns Array with job info
     */
    function claimJob() {
        if ($this->override) {
            $job['id'] = 0;
            $job['tenantID'] = $this->tenant_id;
            $job['tenantKEY'] = $this->tenant_key;
            $job['tenantJWT'] = $this->tenant_jwt;
            $job['type'] = $this->overrideJob;
            $job['startAfter'] = time() - 100;

            return $job;
        }
        else {
            if (isset($this->tenant_id)) {
                $jobs = DB::query("SELECT * FROM worker_jobs WHERE tenant = %i AND status = %s AND startAfter <= UNIX_TIMESTAMP() ORDER BY startAfter ASC LIMIT 1", $this->tenant_id, 'Pending');
            }
            else {
                $jobs = DB::query("SELECT * FROM worker_jobs WHERE status = %s AND startAfter <= UNIX_TIMESTAMP() ORDER BY startAfter ASC LIMIT 1", 'Pending');
            }
            
            if (count($jobs) === 1) {
//Update Job to in progress
                DB::query("UPDATE worker_jobs SET status=%s, startTime=UNIX_TIMESTAMP() WHERE id=%i", 'In Progress', $jobs[0]['id']);
                $this->find_tenant($jobs[0]['tenant']);
//return result
                $job['id'] = $jobs[0]['id'];
                $job['tenantID'] = $this->tenant_id;
                $job['tenantKEY'] = $this->tenant_key;
                $job['tenantJWT'] = $this->tenant_jwt;
                $job['type'] = $jobs[0]['type'];
                $job['startAfter'] = $jobs[0]['startAfter'];

                return $job;
            }
            else {
                return false;
            }
        }
    }

    function finishJob($id, $status, $resultDescription, $benchmark = 0) {
        DB::query("UPDATE worker_jobs SET status=%s, durationMs=%s, resultDescription=%s, endTime=UNIX_TIMESTAMP() WHERE id=%i", $status, $benchmark, $resultDescription, $id); //Update Job to in progress
    }

    /**
     * cancel a job from queue
     */
    function cancelJob() {

    }

    /**
     * cancel a job from queue
     */
    function disableJob() {

    }

    /**
     * remove job from queue
     */
    function deleteJob() {

    }

    function updateJob($id, $status) {
        DB::query("UPDATE worker_jobs SET status=%s WHERE id=%i", $status, $id);
    }

    /**
     * Show disabled jobque, Show all disabled jobs
     * $tenant will return a selected tenant
     */
    function showDisabledJobQueue($tenant = null) {

    }

    function stuckJobs($tenant = null) {
        $timestamp = time() - 600; //Time now-offset in seconds 300 = 5min, 600 = 10min
        return DB::query("SELECT * FROM worker_jobs WHERE status = %s AND startTime IS NOT NULL AND endTime IS NULL AND startTime <= %i ORDER BY startAfter ASC", 'In Progress', $timestamp);
    }

    /**
     * Remove jobs older than x days
     *
     * @param int $days
     * @return int
     */
    function cleanJobQueue($days) {
        //Verwijder regels waar inname log resultaten is 0
        DB::query("DELETE FROM `worker_jobs` WHERE `resultDescription` = 'Logs: Downloaded 0 logs' AND `status` = 'Completed'");
        DB::query("DELETE FROM `worker_jobs` WHERE `resultDescription` = 'Logs: Added 0 to database!' AND `status` = 'Completed'");

        $delay = $days * 24 * 60 * 60; //days
        //$delay = $days * 60; //minutes for debugging
        DB::query("DELETE FROM `worker_jobs` WHERE `status` = 'Completed' AND `endTime` <= (UNIX_TIMESTAMP()-%i)", $delay);

        $affectedRows = DB::affectedRows(); // which id did it choose?!? tell me!!
        return $affectedRows;
    }
}
