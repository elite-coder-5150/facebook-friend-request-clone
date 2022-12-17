<?php
    class Relation {
        protected $db;
        public $error;

        public function __construct() {
            $this->db = new Database();
            $this->error = '';
        }

        public function request($from, $to) {
            $sql = 'SELECT * FROM `relations` WHERE from=:from AND to=: to';

            $query = $this->db->prepare($sql);
            $query->execute(array(':from' => $from, ':to' => $to));

            /**
             * 
             * if (is_array($query->fetch(PDO::FETCH_ASSOC))) {
             *  $this->error = 'You have already sent a request to this user.';
             * return false;
             * } */
            if ($query->rowCount() == 1) {
                $this->error = 'You are already send a request to this usr.';
                return false;
            }

            $sql = "SELECT * FROM `relations` 
                WHERE (
                    status='p' AND from=:from AND to=:to
                ) OR (
                    status='p' AND from=:to AND to=:from
                )";

            /*
            if (is_array($query->fetch(PDO::FETCH_ASSOC))) {
                $this->error = 'Your request is pending.';
                return false;
            }*/

            if ($query->rowCount() == 1) {
                $this->error = 'Your request is pending';
                return false;
            }

            $sql = 'INSERT INTO `relations` (from, to, status) VALUES (:from, :to, :status)';

            $query = $this->db->prepare($sql);
            $query->execute([
                ':from' => $from, 
                ':to' => $to, 
                ':status' => 'p'
            ]);

            return true;
        }

        public function accept($from, $to) {
            $sql = "UPDATE `relations` SET status=:status WHERE from=:from AND to=:to";

            $query = $this->db->prepare($sql);

            $query->execute([
                ':status' => 'f', 
                ':from' => $from, 
                ':to' => $to
            ]);

            if (is_array($query->fetch(PDO::FETCH_ASSOC))) {
                $this->error = 'invalid friend request.';
                return false;
            }

            $sql = "INSERT INTO `relations` (from, to, status) VALUES (:from, :to, :status)";

            $query = $this->db->prepare($sql);
            $query->execute([
                ':from' => $to, 
                ':to' => $from, 
                ':status' => 'f'
            ]);

            return true;
        }

        public function cancelRequest($from, $to) {
            $sql = "DELETE FROM relations (from, to, status) VALUES(:from, :to, :status)";

            $query = $this->db->prepare($sql);
            $query->execute([
                ':from' => $from,
                ':to' => $to,
                ':status' => 'p'
            ]);

            return true;
        }


        public function unfriend($from, $to) {
            $sql = "DELETE * FROM `relations` 
                WHERE (
                    status='p' AND from=:from AND to=:to
                ) OR (
                    status='p' AND from=:to AND to=:from
                )";

            $query = $this->db->prepare($sql);
            $query->execute([
                ':from' => $from,
                ':to' => $to,
                ':from' => $to,
                ':to' => $from
            ]);

            return true
        }

        
    } 