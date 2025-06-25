<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Database\Factories\UserFactory;


/**
 * Пользователь.
 *
 * @property int $id Идентификатор.
 * @property string $login Логин.
 * @property string $referral_code Код реферальной программы.
 * @property int $referrer_id Id родител
 */

#[ObservedBy([UserObserver::class])]
final class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use Notifiable;

    /**
     * {@inheritdoc }
     */
    protected $fillable = [
        'login',
        'referral_code',
        'referrer_id',
        'password',
    ];

    /**
     * {@inheritdoc }
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * {@inheritdoc }
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Переопределяет ключ доступа к моделе.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'login';
    }

    /**
     * Получает рефералов.
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'referrer_id');
    }


    /**
     * Возвращает детей и их детей
     *
     * @return HasMany
     */
    public function childrenWithGrand(): HasMany
    {
        return $this->children()->with('children');
    }

}
