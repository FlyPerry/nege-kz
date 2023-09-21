<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Initialize User Permissions Based On Roles
    |--------------------------------------------------------------------------
    |
    | This closure is called by the Authority\Ability class' "initialize" method
    |
    */
    /*
     * Вместо этого переопределяйте Cms_Controller_Admin::ini_autority()
     */
    'initialize' => function($user)
    {
        // The initialize method (this Closure function) will be ran on every page load when the bundle get's started.
        // A User Object will be passed into this method and is available via $user
        // The $user variable is a instantiated User Object (application/models/user.php)

        // First, let's group together some "Actions" so we can later give a user access to multiple actions at once
//        Authority::action_alias('manage', array('create', 'read', 'update', 'delete'));
//        Authority::action_alias('moderate', array('update'));

        // If a user doesn't have any roles, we don't have to give him permissions so we can stop right here.
//        if(count($user->roles) === 0) return false;

//        if($user->has('roles',ORM::factory('role', array('name' => 'admin'))))
//        {
//             The logged in user is an admin, we allow him to perform manage actions (create, read, update, delete) on "all" "Resources".
//            Authority::allow('manage', 'all');
//            Authority::allow('moderate', 'all');
//            Authority::allow('edit', 'all');
//            Authority::allow('create', 'all');
//            Authority::allow('delete', 'all');
//        }



        // We can also allow "Actions" on certain "Resources" by results we get from somewhere else, look closely at the next example
//        foreach (ORM::factory('authority')->where('user_id','=',$user->id)->find_all() as $permission) {
//            if ($permission->rule === 'allow') {
//                Authority::allow($permission->action, $permission->resource);
//            } else {
//                Authority::deny($permission->action, $permission->resource);
//            }
//        }
    }


);