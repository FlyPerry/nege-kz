    
<?php defined('SYSPATH') or die('No direct script access.');
 
class Task_Db_Migrate extends Minion_Task
{
    /**
     * Task to run pending migrations
     *
     * @return null
     */
    protected $_options = array(
        'env' => 'DEVELOPMENT',
        'module'=>'application'
    );

    protected function _execute(array $params)
    {

        if($params['env']!='DEVELOPMENT'){
            Kohana::$environment = constant('Kohana::' . strtoupper($params['env']));
        }

        $migrations = new Flexiblemigrations();
        try 
        {
            $model = ORM::factory('Migration');
        } 
        catch (Database_Exception $a) 
        {
            Minion_CLI::write('Flexible Migrations is not installed. Please Run the migrations.sql script in your mysql server');
            exit();
        }
        try
        {
            $messages = $migrations->migrate();
        } catch (Exception $e){
            Minion_CLI::write(Kohana_Exception::text($e));
        }

        if (empty($messages)) { 
            Minion_CLI::write("Nothing to migrate");
        } else {
            foreach ($messages as $message) {
                if (key($message) == 0) { 
                    Minion_CLI::write($message[0]);
                    Minion_CLI::write("OK");
                } else { 
                    Minion_CLI::write($message[key($message)]);
                    Minion_CLI::write("ERROR");
                }
            }
        }
    }
}