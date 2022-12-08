<?php
	class Database extends PDO {
		protected $inst;
		protected $dsn;

		public function __construct() {
			self::$dsn = 'mysql:host=localhost;dbname=kaylios'
			/** finish this in the morning **/
		}
	}