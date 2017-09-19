<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class FileStorage extends Model
{
    /**
     * @var string File Name
     */
    protected static $fileName = 'user_storage.txt';

    /**
     * Prepare User to saving.
     *
     * @param \App\User $user
     *
     * @return array
     */
    protected function prepareUserForSaving(User $user)
    {
        $name = $user->getName();
        $password = password_hash($user->getPassword(), PASSWORD_DEFAULT);

        $userCredentials = [
            'name' => $name,
            'password' => $password,
        ];

        return $userCredentials;
    }

    /**
     * Get File Name.
     *
     * @return string
     */
    public static function getFileName()
    {
        $fileName = self::$fileName;

        return $fileName;
    }

    /**
     * Get Storage.
     */
    public static function getStorage()
    {
        $userStorage = Storage::get(self::getFileName());
        $userStorage = json_decode($userStorage, true);

        return $userStorage;
    }

    /**
     * Save User.
     *
     * @param \App\User $user
     */
    public function saveUser(User $user)
    {
        $userStorage = self::getStorage();

        $newUserId = max(array_keys($userStorage)) + 1;

        $userStorage[$newUserId] = $this->prepareUserForSaving($user);

        $userStorage = json_encode($userStorage);

        Storage::disk('local')
            ->put(
                $this->getFileName(),
                $userStorage
            );
    }
}
