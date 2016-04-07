<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = '10.26.73.50:7001';
$db['default']['username'] = 'bslog';
$db['default']['password'] = 'a424e701475f5663bf36c406a143e2ba';
$db['default']['mydbprefix'] = 'other_';
$db['default']['database'] = $db['default']['mydbprefix'] . 'excptstatistics';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

$db['default']['glog_mysql'] = '
CREATE TABLE IF NOT EXISTS `库名`.`表名` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` varchar(50) NOT NULL,
  `ver` varchar(50) NOT NULL,
  `mver` varchar(50) NOT NULL,
  `umid` varchar(50) NOT NULL,
  `a1` int(11) NOT NULL,
  `a2` int(11) NOT NULL,
  `a3` int(11) NOT NULL,
  `a4` int(11) NOT NULL,
  `a5` int(11) NOT NULL,
  `a6` int(11) NOT NULL,
  `a7` int(11) NOT NULL,
  `a8` int(11) NOT NULL,
  `a9` int(11) NOT NULL,
  `a10` int(11) NOT NULL,
  `b1` int(11) NOT NULL,
  `b2` int(11) NOT NULL,
  `b3` int(11) NOT NULL,
  `b4` int(11) NOT NULL,
  `b5` int(11) NOT NULL,
  `b6` int(11) NOT NULL,
  `b7` int(11) NOT NULL,
  `b8` int(11) NOT NULL,
  `b9` int(11) NOT NULL,
  `b10` int(11) NOT NULL,
  `c1` int(11) NOT NULL,
  `c2` int(11) NOT NULL,
  `c3` int(11) NOT NULL,
  `c4` int(11) NOT NULL,
  `c5` int(11) NOT NULL,
  `c6` int(11) NOT NULL,
  `c7` int(11) NOT NULL,
  `c8` int(11) NOT NULL,
  `c9` int(11) NOT NULL,
  `c10` int(11) NOT NULL,
  `d1` int(11) NOT NULL,
  `d2` int(11) NOT NULL,
  `d3` int(11) NOT NULL,
  `d4` int(11) NOT NULL,
  `d5` int(11) NOT NULL,
  `d6` int(11) NOT NULL,
  `d7` int(11) NOT NULL,
  `d8` int(11) NOT NULL,
  `d9` int(11) NOT NULL,
  `d10` int(11) NOT NULL,
  `e1` int(11) NOT NULL,
  `e2` int(11) NOT NULL,
  `e3` int(11) NOT NULL,
  `e4` int(11) NOT NULL,
  `e5` int(11) NOT NULL,
  `e6` int(11) NOT NULL,
  `e7` int(11) NOT NULL,
  `e8` int(11) NOT NULL,
  `e9` int(11) NOT NULL,
  `e10` int(11) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `timeStamp` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `minData` (`cid`,`ver`,`mver`),
  KEY `umid` (`umid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
';

/* End of file database.php */
/* Location: ./application/config/database.php */