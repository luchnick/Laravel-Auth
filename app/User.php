<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;

class User extends Model
{
    /**
     * @var int User Id
     */
    protected $id;

    /**
     * @var string User Name
     */
    protected $name;

    /**
     * @var string User Password
     */
    protected $password;

    /**
     * Set User Name.
     *
     * @param string $name User Name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Set User Password.
     *
     * @param string $password User Password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get User Id.
     */
    public function getUserId()
    {
        $id = $this->id;

        return $id;
    }

    /**
     * Get User Name.
     */
    public function getName()
    {
        $name = $this->name;

        return $name;
    }

    /**
     * Get User Password.
     */
    public function getPassword()
    {
        $password = $this->password;

        return $password;
    }

    /**
     * Get User by Id.
     *
     * @param int $id User Id
     *
     * @return mixed
     */
    public static function getUserById($id)
    {
        $userStorage = FileStorage::getStorage();

        $user = new self();
        $user->setName($userStorage[$id]['name']);

        return $user;
    }

    /**
     * Get User from Session.
     *
     * @return array
     */
    public static function getUserFromSession()
    {
        $user = null;
        $userId = Session::get('authenticated');

        if ($userId) {
            $user = self::getUserById(reset($userId));
        }

        return $user;
    }

    /**
     * Get User by Id.
     *
     * @param array $credentials User Credentials
     *
     * @return array
     */
    public static function getUserIdByCredentials($credentials)
    {
        $userId = null;

        $userStorage = FileStorage::getStorage();

        foreach ($userStorage as $key => $value) {
            if (
                $value['name'] === $credentials['name']
                && password_verify($credentials['password'], $value['password'])
            ) {
                $userId = $key;
                break;
            }
        }

        return $userId;
    }
}
