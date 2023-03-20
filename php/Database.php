<?php
	class Database extends PDO {
		protected static $inst;
		protected static $dsn;
        protected static $user;
        protected static $pass;

		public function __construct() {
            parent::__construct();

            self::$user = 'root';
            self::$pass = 'root';
			self::$dsn = 'mysql:host=localhost;dbname=kaylios';

			self::$inst = new PDO(self::$dsn, self::$user, self::$pass);
			self::$inst->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
	}
