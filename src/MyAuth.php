<?php

namespace MyAuthPackage;

use Src\Auth\Auth;
use Src\Auth\IdentityInterface;
use Src\Session;

class MyAuth implements IdentityInterface
{
    private static IdentityInterface $user;

    public static function init(IdentityInterface $user): void
    {
        self::$user = $user;
        if (self::user()) {
            self::login(self::user());
        }
    }

    public static function login(IdentityInterface $user): void
    {
        self::$user = $user;
        Session::set('id', self::$user->getId());
    }

    public static function attempt(array $credentials): bool
    {
        if ($user = self::$user->attemptIdentity($credentials)) {
            self::login($user);
            return true;
        }
        return false;
    }

    public static function user()
    {
        $id = Session::get('id') ?? 0;
        return self::$user->findIdentity($id);
    }

    public static function check(): bool
    {
        if (self::user()) {
            return true;
        }
        return false;
    }

    public static function logout(): bool
    {
        Session::clear('id');
        return true;
    }

    public static function generateCSRF(): string
    {
        $token = md5(time());
        Session::set('csrf_token', $token);
        return $token;
    }

    public function findIdentity(int $id)
    {
        // Реализация метода из интерфейса IdentityInterface
        // Возвращайте экземпляр пользователя с заданным ID
    }

    public function getId(): int
    {
        // Реализация метода из интерфейса IdentityInterface
        // Возвращайте ID текущего пользователя
    }

    public function attemptIdentity(array $credentials)
    {
        // Реализация метода из интерфейса IdentityInterface
        // Попытка аутентификации пользователя по учетным данным
    }
}
