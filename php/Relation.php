<?php

    class Relation {
        public $unblock;
        protected $db;
        public $error;

        public function __construct() {
            $this->db = new Database();
            $this->error = '';
        }

        public function request($from, $to) {
            if ($this->alreadyFriends($from, $to)) {
                return false;
            } else if ($this->isPending($from, $to)) {
                return false;
            } else {
                $sql = "INSERT INTO `relation` (`from`, `to`, `status`) VALUES (?, ?, 'P')";
                $query = $this->db->prepare($sql);
                $query->execute([$from, $to]);
                return true;
            }
        }
        private function alreadyFriends($from, $to) {
            $sql = "SELECT * FROM `relation` WHERE `from`=? AND `to`=? AND `status`='F'";

            $query = $this->db->prepare($sql);
            $query->execute([$from, $to]);

            if ($query->rowCount() == 1) {
                $this->error = "Already added as friends";
                return true;
            } else if ($query->rowCount() == 0) {
                return false;
            }
        }

        private function isPending($from, $to) {
            $sql = "SELECT * FROM `relation` WHERE
                (`status`='P' AND `from`=? AND `to`=?) OR
                (`status`='P' AND `from`=? AND `to`=?)";

            $query = $this->db->prepare($sql);
            $query->execute([$from, $to, $to, $from]);

            if ($query->rowCount() == 1) {
                $this->error = "Already has a pending friend request";
                return true;
            } else if ($query->rowCount() == 0) {
                return false;
            }
        }

        public function accept($from, $to) {
            $this->updateRequest($from, $to, 'F');

            $sql = "INSERT INTO `relation` 
                    (`from`, `to`, `status`) 
                    VALUES (?, ?, 'F')";
            $query = $this->db->prepare($sql);
            $query->execute([$to, $from]);

            return true;
        }

        private function updateRequest($from, $to, $status): void {
            $sql = "UPDATE relation SET status=?
                WHERE `from`=? AND `to`=? AND `status`='P'";

            $query = $this->db->prepare($sql);
            $query->execute([$status, $from, $to]);

            if ($query->rowCount() == 0) {
                $this->error = "Invalid friend request";
            }
        }
        public function cancel($from, $to) {
            $sql = "DELETE FROM `relation` WHERE `from`=? AND `to`=? AND `status`='P'";

            $query = $this->db->prepare($sql);
            $query->execute([$from, $to]);

            return true;
        }

        public function block($from, $to, $blocked = true) {
            if ($blocked) {
                $sql = "INSERT INTO `relation` (`from`, `to`, `status`) VALUES (?, ?, 'B')";

                $query = $this->db->prepare($sql);
                $query->execute([$from, $to]);
            } else {
                $sql = "DELETE FROM `relation` WHERE `from`=? AND `to`=? AND `status`='B'";

                $query = $this->db->prepare($sql);
                $query->execute([$from, $to]);

                $this->request($from, $to);
            }
            $this->unfriend($from, $to);
            return true;
        }

        public function unblock($from, $to) {
//            $this->block($from, $to, false);
            $sql = "DELETE FROM `relation` WHERE `from`=? AND `to`=? AND `status`='B'";
            $query = $this->db->prepare($sql);
            $query->execute([$from, $to]);
            return true;
        }
        public function unfriend($from, $to) {
            $sql = "DELETE FROM `relation` WHERE
                (`from`=? AND `to`=?) OR
                (`from`=? AND `to`=?)";

            $query = $this->db->prepare($sql);
            $query->execute([$from, $to, $to, $from]);

            return true;
        }

        public function getRequest($user_id) {
            $req = ["in" => [], "out" => []];

            $sql = "SELECT * FROM `relation` WHERE `to`=? AND `status`='P'";

            $query = $this->db->prepare($sql);
            $query->execute([$user_id]);

            while ($query->fetchAll(PDO::FETCH_OBJ)) {
                $req["in"][] = $query->fetchAll(PDO::FETCH_OBJ);
            }
            return $req;
        }

        public function getFriends($user_id) {
            $sql = "SELECT * FROM `relation` WHERE `from`=? AND `status`='F'";

            $query = $this->db->prepare($sql);
            $query->execute([$user_id]);

            $this->getBlockedUsers($user_id);

            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public function getBlockedUsers($user_id) {
            $sql = "SELECT * FROM `relation` WHERE `from`=? AND `status`='B'";

            $query = $this->db->prepare($sql);
            $query->execute([$user_id]);

            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public function getUsers($user_id) {
            $sql = "SELECT * FROM `users` WHERE `id`!=?";

            $query = $this->db->prepare($sql);
            $query->execute([$user_id]);

            return $query->fetchAll(PDO::FETCH_OBJ);
        }
    } 
