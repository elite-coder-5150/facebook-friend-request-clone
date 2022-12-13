<?php
	class Database extends PDO {
		protected $inst;
		protected $dsn;

		public function __construct() {
			self::$dsn = 'mysql:host=localhost;dbname=kaylios';
			self::$inst = new PDO(self::$dsn, 'root', 'root');
			self::$inst->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	}