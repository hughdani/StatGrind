<?php
abstract class User
{
    private $user_id;
    private $user_name;
    private $first_name;
    private $last_name;
    protected $account_type;

    public function __construct($user_id, $user_name, $first_name, $last_name)
    {
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->db = new Database();
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
    }

    public function getUserName()
    {
        return $this->user_name;
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function setLastName($last_name)
    {
        $this->user_id = $last_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function getAccountType()
    {
        return $this->account_type;
    }
}

class Instructor extends User
{
    const USER_TYPE = 1;
    public function __construct($user_id, $user_name, $first_name, $last_name)
    {
        parent::__construct($user_id, $user_name, $first_name, $last_name);
        $this->account_type = self::USER_TYPE;
    }
}

class TA extends User
{
    const USER_TYPE = 3;
    public function __construct($user_id, $user_name, $first_name, $last_name)
    {
        parent::__construct($user_id, $user_name, $first_name, $last_name);
        $this->account_type = self::USER_TYPE;
    }
}

class Student extends User
{
    const USER_TYPE = 2;
    public function __construct($user_id, $user_name, $first_name, $last_name)
    {
        parent::__construct($user_id, $user_name, $first_name, $last_name);
        $this->account_type = self::USER_TYPE;
    }
}

class NullUser extends User
{
    const USER_TYPE = -1;
    public function __construct($user_id=0, $user_name="dummy_id", $first_name="dummy_first", $last_name="dummy_last")
    {
        parent::__construct($user_id, $user_name, $first_name, $last_name);
        $this->account_type = self::USER_TYPE;
    }
}