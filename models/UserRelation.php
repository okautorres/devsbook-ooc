<?php
class UserRelation{
    public $user_from;
    public $user_to;
}

interface UserRelationDAO{
    public function insert (UserRelation $u);
    public function delete (UserRelation $u);
    public function getFollowing($id);
    public function getFollowers($id);
    public function isFollowing($id1, $id2);
    //public function getFriends($id, $ids);
}