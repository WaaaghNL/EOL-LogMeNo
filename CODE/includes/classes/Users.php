<?php
class Users{
    private function create(){
        
    }
    function remove(intenger $id){
        
    }
    function isTenantMaster(intenger $id){
        //Select from DB where ID = ID and mainuser = null. All Users with Mainuser null are Tenant masters. 
        if(true){
            return true;
        }
        else{
            //return ID from query
            return false;
        }
    }
    function lock(intenger $id){
    }
    function unlock(intenger $id){
    }
    function register(){
    }
    function login(string $username, string $password){
    }
    function logout(intenger $id){
    }
}
