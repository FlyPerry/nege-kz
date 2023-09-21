<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Flexible Migrations
 *
 * An open source utility inspired by Ruby on Rails
 *
 * Reworked for Kohana by Fernando Petrelli
 *
 * Based on Migrations module by Jamie Madill
 *
 * @package		Flexiblemigrations
 * @author 		Matías Montes
 * @author 		Jamie Madill
 * @author    Fernando Petrelli
 */

class Kohana_Flexiblemigrations
{
	protected $_config;

    public $file_pattern = '/^(\d{14})-(\w+)-(\w+)$/';

    public function __construct($config_name="config")
	{
		$this->_config = Kohana::$config->load($config_name)->as_array();
	}

	public function get_config() 
	{
		return $this->_config;
	}

	/**
	 * Run all pending migrations
	 *
	 */
	public function migrate($force=false)
	{
		$migration_keys = $this->get_migration_keys();
		$migrations 	= ORM::factory('migration')->find_all();
		$messages		= array();

		//Remove executed migrations from queue
		foreach ($migrations as $migration) 
		{
			if (array_key_exists($migration->hash, $migration_keys) && !$force)
			{
				unset($migration_keys[$migration->hash]);
			}
		}

		if (count($migration_keys) > 0) 
		{
			foreach ($migration_keys as $key => $value) 
			{
				$msg = "Executing migration: '" . $value . "' with hash: " .$key;
				
//				try
//				{
					$migration_object = $this->load_migration($key);
					$migration_object->up();
                    if (!($migration_object->driver() instanceof Drivers_Virtual)){
                        $model = ORM::factory('Migration');
                        $model->hash = $key;
                        $model->name = $value;
                        $model->save();
                        $model ? $messages[] = array(0 => $msg) : $messages[] = array(1 => $msg);
                    } else {
                        $messages[] = array(0 => $msg);
                    }

//				}
//				catch (Exception $e)
//				{
//					$messages[] = array(1 => $msg . "\n" . $e->getMessage());
//					return $messages;
//				}
			}
		}
		return $messages;
	}

	/**
	 * Rollback last executed migration.
	 *
	 */
	public function rollback() 
	{
		//Get last executed migration
		$model		= ORM::factory('migration')->order_by('created_at','DESC')->order_by('hash','DESC')->limit(1)->find();
		$messages	= array();

		if ($model->loaded()) 
		{
			try 
			{
				$migration_object = $this->load_migration($model->hash);
				$migration_object->down();

				if ($model) 
				{
					$msg = "Migration '" . $model->name . "' with hash: " . $model->hash . ' was succefully "rollbacked"';
					$messages[] = array(0 => $msg);
				} else {
					$messages[] = array(1 => "Error executing rollback");
				}
				$model->delete();
			}
			catch (Exception $e) 
			{
				$messages[] = array(1 => $e->getMessage());
			}
		}
		else 
		{
			$messages[] = array(1 => "There's no migration to rollback");
		}

		return $messages;
	}

	/**
	 * Rollback last executed migration.
	 *
	 */
	public function get_timestamp() 
	{
		return date('YmdHis');
	}

	/**
	 * Get all valid migrations file names
	 *
	 * @return array migrations_filenames
	 */
	public function get_migrations()	
	{
        $modules=Kohana::modules()+array('application'=>APPPATH);
        $migrations=array();

		foreach ($modules as $module){
            $dir = $module . $this->_config['path'];
            if (!is_dir($dir)){
                continue; //Пропускаем модули без папок миграций
            }
            $files = glob($dir .DIRECTORY_SEPARATOR.'*'.EXT);
            foreach ($files as $i => $file)
            {
                $name = basename($file, EXT);
                if (!preg_match($this->file_pattern, $name)) //Check filename format
                unset($files[$i]);
            }
            $migrations=array_merge($migrations,$files);
        }

		return $migrations;
	}

    public function cmp_keys($a,$b){
        list($a)=explode('-',$a);
        list($b)=explode('-',$b);
        if ($a>$b) return 1;
        if ($b>$a) return -1;
        return 0;
    }

	/**
	 * Generates a new migration file
	 * TODO: Probably needs to be in outer class
	 *
	 * @return integer completion_code
	 */
	public function generate_migration($migration_name,$module="application")
	{
		try
		{
			//Creates the migration file with the timestamp and the name from params
			$file_name 	= $this->get_timestamp(). '-' .$module.'-'. $migration_name . '.php';
			$config 	= $this->get_config();
			$file 		= $this->get_file($config, $file_name, $module);
			
			//Opens the template file and replaces the name
			$view = new View('migration_template');
			$view->set_global('migration_name', $migration_name);
			fwrite($file, $view);
			fclose($file);
			chmod($this->get_dir($config,$module).$file_name, 0770);
			return 0;
		}
		catch (Exception $e)
		{
			return 1;
		}
	}	

	/**
	 * Get all migration keys (timestamps)
	 *
	 * @return array migrations_keys
	 */
	protected function get_migration_keys() 
	{
		$migrations = $this->get_migrations();
		$keys = array();
		foreach ($migrations as $migration)
		{
            $basename = basename($migration, EXT);
            Minion_CLI::write($basename);
            if(preg_match($this->file_pattern,$basename,$matches)){
                $sub_migration = $matches[1]."-".$matches[2];
                $keys = Arr::merge($keys, array($sub_migration => $matches[3]));
            }

		}
        uksort($keys,array($this,'cmp_keys'));
		return $keys;
	}

    public function get_hash_by_name($name){
        if(preg_match($this->file_pattern,$name,$matches)){
            return $matches[1]."-".$matches[2];
        }
        return FALSE;
    }

	/**
	 * Load the migration file, and returns a Migration object
	 *
	 * @return Migration object with up and down functions
	 */
	protected function load_migration($version) 
	{
        list($timestamp,$module)=explode('-',$version,3);
        if ($module=='application'){
            $path = APPPATH.$this->_config['path'].DIRECTORY_SEPARATOR;
        } else {
            $path = MODPATH.$module.DIRECTORY_SEPARATOR.$this->_config['path'].DIRECTORY_SEPARATOR;
        }
        $f = glob($path .$version.'*'. EXT);

		if ( count($f) > 1 ) // Only one migration per step is permitted
			throw new Kohana_Exception('There are repeated migration names');

		if ( count($f) == 0 ) // Migration step not found
			throw new Kohana_Exception("There's no migration to rollback");

		$file = basename($f[0]);
		$name = basename($f[0], EXT);

		// Filename validation
		if ( !preg_match($this->file_pattern, $name, $match) )
			throw new Kohana_Exception('Invalid filename :file', array(':file' => $file));

		$match[3] = strtolower($match[3]);
		require $f[0]; //Includes migration class file

		$class = ucfirst($match[3]); //Get the class name capitalized

		if ( !class_exists($class) )
			throw new Kohana_Exception('Class :class doesn\'t exists', array(':class' => $class));

		if ( !method_exists($class, 'up') OR !method_exists($class, 'down') )
			throw new Kohana_Exception('Up or down functions missing on class :class', array(':class' => $class));

		return new $class(false,'default',$this->_config['driver']);
	}

    /**
     * @param $config
     * @param $file_name
     * @return resource
     */
    public function get_file($config, $file_name, $module)
    {
        $dir = $this->get_dir($config, $module);
        return fopen($dir . $file_name, 'w+');
    }

    /**
     * @param $config
     * @param $module
     * @return string
     */
    public function get_dir($config, $module)
    {
        if ($module === 'application') {
            $dir = APPPATH . $config['path'] . DIRECTORY_SEPARATOR;
            return $dir;
        } else {
            $dir = MODPATH . $module . DIRECTORY_SEPARATOR . $config['path'] . DIRECTORY_SEPARATOR;
            return $dir;
        }
    }



}