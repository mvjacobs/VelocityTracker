<?php
/**
 * This is core configuration file.
 *
 * Use it to configure core behaviour of Cake.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 * Database configuration class.
 * You can specify multiple configurations for production, development and testing.
 *
 * datasource => The name of a supported datasource; valid options are as follows:
 *		Database/Mysql 		- MySQL 4 & 5,
 *		Database/Sqlite		- SQLite (PHP5 only),
 *		Database/Postgres	- PostgreSQL 7 and higher,
 *		Database/Sqlserver	- Microsoft SQL Server 2005 and higher
 *
 * You can add custom database datasources (or override existing datasources) by adding the
 * appropriate file to app/Model/Datasource/Database. Datasources should be named 'MyDatasource.php',
 *
 *
 * persistent => true / false
 * Determines whether or not the database should use a persistent connection
 *
 * host =>
 * the host you connect to the database. To add a socket or port number, use 'port' => #
 *
 * prefix =>
 * Uses the given prefix for all the tables in this database. This setting can be overridden
 * on a per-table basis with the Model::$tablePrefix property.
 *
 * schema =>
 * For Postgres/Sqlserver specifies which schema you would like to use the tables in. Postgres defaults to 'public'. For Sqlserver, it defaults to empty and use
 * the connected user's default schema (typically 'dbo').
 *
 * encoding =>
 * For MySQL, Postgres specifies the character encoding to use when connecting to the
 * database. Uses database default not specified.
 *
 * unix_socket =>
 * For MySQL to connect via socket specify the `unix_socket` parameter instead of `host` and `port`
 */
class DATABASE_CONFIG {

	public $default = null;

	public $live = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'pivotal',
		'password' => 'mszouKK5RqzzoXnnNEKYBYGAH51Ked3JycEDCvE6dST4K6ExVYa2wROdmBBR0kM',
		'database' => 'velocitytracker',
		'prefix' => 'vt_',
		'encoding' => 'utf8',
	);

	public $marc = array(
            'datasource' => 'Database/Mysql',
            'persistent' => false,
            'host' => '127.0.0.1',
            'login' => 'root',
            'password' => '',
            'database' => 'velocitytracker',
            'prefix' => 'vt_',
            'encoding' => 'utf8',
    );

	public $test = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'user',
		'password' => 'password',
		'database' => 'test_database_name',
		'prefix' => '',
		//'encoding' => 'utf8',
	);

    public $pivotal = array(
        'datasource'   => 'RestSource',
        'host'         => 'www.pivotaltracker.com/services/v4',
        'content-type' => 'application/xml',
        'port'         => 443,
        'scheme'       => 'https'
    );

	// the construct function is called automatically, and chooses prod or dev. UPdate! works for baking now
	function __construct () {
		//check to see if server name is set (thanks Frank)
		switch(getenv('CAKE_ENV')) {
			case 'marc':
				$this->default = $this->marc;
				break;
			case 'live':
				$this->default = $this->live;
                Configure::write('debug', 0);
				break;
			default:
				$this->default = $this->live;
                Configure::write('debug', 0);
				break;
		}
	}
}
