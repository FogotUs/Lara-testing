<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AccountResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

final readonly class AccountController extends Controller
{
    public function __construct(
        private UserRepository $repository,
    ) {
    }

    /**
     * Возвращает Responce с данными аккаунта и списком рефералов.
     *
     * @param User $user
     *
     * @return JsonResource
     */
    public function index(User $user): JsonResource
    {
        return AccountResource::make($this->repository->getUserWithChildren($user->login));
    }

    /**
     * Регистрация пользователя.
     *
     * @param RegisterRequest $request
     *
     * @return JsonResponse
     */
    public function create(RegisterRequest $request): JsonResponse
    {
        $referrer = $this->repository->getReferralId($request->reffer);
        $this->repository->create($request->login, $request->password, $referrer->id ?? null);
        return response()->json(['message'=>'Успешная регистрация'], ResponseAlias::HTTP_CREATED);
    }

    /**
     * Легкий метод для авторизации
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function show(LoginRequest $request): JsonResponse
    {
        return response()
            ->json(['message' => 'Успешная авторизация'],
                ResponseAlias::HTTP_OK
            );
    }

    /**
     * Изменение пароля пользователя.
     *
     * @param PasswordChangeRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(PasswordChangeRequest $request, User $user): JsonResponse
    {
        $validated = $request->validated();
        if ($this->repository->changePassword($user->login, $validated['password'])) {
            return response()->json(['message' => 'Пароль успешно изменен'], ResponseAlias::HTTP_OK);
        }
        else {
            return response()->json(['message' => 'Пароль не был изменен'], ResponseAlias::HTTP_NOT_ACCEPTABLE);
        }
    }
}
