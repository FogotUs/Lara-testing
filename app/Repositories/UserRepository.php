<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;


/**
 * Хранилище запросов модели Users.
 */
final readonly class UserRepository
{
    /**
     * Создает пользователя и привязывает $referralCode если он есть.
     *
     * @param string $login
     * @param string $password
     * @param int|null $referralId  id реферала, если есть.
     *
     * @return User
     */
    public function create(string $login, string $password, ?int $referralId): User
   {
      return User::query()
       ->create([
           'login'         => $login,
           'password'      => $password,
           'referrer_id'   => $referralId ?? null,
       ]);
   }

    /**
     *
     * Проверяет, есть ли реферальный код у другой записи.
     *
     * @param string $referralCode Код реферала.
     *
     * @return Model|null Возвращает Model или ничего.
     */
    public function getReferralId(?string $referralCode): Model | null
   {
        return $referralCode
           ? User::query()
               ->where('referral_code', $referralCode)
               ->first('id')
           : null;
   }

    /**
     * Возвращает данные пользователя со связанными записями и их связанными записями.
     *
     * @param string $login идентификатор юзера.
     *
     * @return User Модель юзера.
     *
     */
    public function getUserWithChildren(string $login): User
    {
        return User::query()
            ->where('login', $login)
            ->with('childrenWithGrand')
            ->firstOrFail();
    }

    /**
     * Изменение пароля
     *
     * @param string $login логин пользователя
     * @param string $password новый пароль
     *
     * @return bool
     *
     */
    public function changePassword(string $login, string $password): bool
    {
        return User::query()
            ->where('login', $login)
            ->first()
            ->update(['password' => $password]);
    }

}
