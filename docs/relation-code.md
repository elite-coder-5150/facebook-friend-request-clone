Code for the isPending method of the Relation class. {#isPending}
```php
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
```
