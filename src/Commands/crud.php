<?php

namespace mcrud\crud\Commands ;

use Illuminate\Console\Command;
use PDO;
use DB;
use PDOException;
class crud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'to  essaly make crud ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }




            public function setEnvironmentValue($key, $value)
            {

                        $path = app()->environmentFilePath();

                        $escaped = preg_quote('='.env($key), '/');

                        file_put_contents($path, preg_replace(
                            "/^{$key}{$escaped}/m",
                            "{$key}={$value}",
                            file_get_contents($path)
                        ));
            }






    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       	$DB_DATABASE = $this->ask('What is your DATABASE Name ?');
		$DB_USERNAME = $this->ask('What is your DATABASE Username ?');
        $DB_PASSWORD = $this->ask('What is your DATABASE Password ?');

        if (!empty($DB_DATABASE)) {
            $this->setEnvironmentValue('DB_DATABASE', $DB_DATABASE);

		}

		if (!empty($DB_USERNAME)) {
            $this->setEnvironmentValue('DB_USERNAME', $DB_USERNAME);
		}

		if (!empty($DB_PASSWORD)) {
            $this->setEnvironmentValue('DB_PASSWORD', $DB_PASSWORD);
        }

        if (!empty($DB_DATABASE)) {
			$auto_create_DB = $this->confirm("do you want me to create a database in your engine or you have already created database with name ".$DB_DATABASE."? ");
			if ($auto_create_DB) {
				$pdo = $this->getPDOConnection(env('DB_HOST'), env('DB_PORT'), $DB_USERNAME, $DB_PASSWORD);
				$pdo->exec(sprintf(
						'CREATE DATABASE IF NOT EXISTS %s CHARACTER SET %s COLLATE %s;',
						$DB_DATABASE,
						config('database.connections.mysql.charset'),
						config('database.connections.mysql.collation')
					));

				$this->info("DATABAES ".$DB_DATABASE." Created and is ready ");

			}else {
                $this->info("something erorr tyr again");
            }

		}


     }


    private function getPDOConnection($host, $port, $username, $password)
    {
        return new PDO(sprintf('mysql:host=%s;port=%d;', $host, $port), $username, $password);
    }
}
