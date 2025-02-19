<?php

namespace App\Application\UseCase\Authenticate;

use App\Application\Abstract\AbstractCommandHandler;
use App\Application\Contract\JsonWebTokenServiceContract;
use App\Application\Contract\TelegramAuthServiceContract;
use App\Application\Contract\UserReadRepositoryContract;
use App\Application\Support\AccessDeniedException;
use App\Application\Support\Session;

readonly class AuthenticateCommandHandler extends AbstractCommandHandler
{
    private TelegramAuthServiceContract $telegramAuthService;
    private UserReadRepositoryContract  $userReadRepository;
    private JsonWebTokenServiceContract $jsonWebTokenService;

    public function __construct(
        TelegramAuthServiceContract $telegramAuthService,
        UserReadRepositoryContract $userReadRepository,
        JsonWebTokenServiceContract $jsonWebTokenService
    )
    {
        $this->telegramAuthService = $telegramAuthService;
        $this->userReadRepository = $userReadRepository;
        $this->jsonWebTokenService = $jsonWebTokenService;
    }

    public function __invoke(AuthenticateCommand $command): AuthenticateCommandResult
    {
        $chatId = $this->telegramAuthService->verify($command->hash, $command->data);
        $user = $chatId ? $this->userReadRepository->getByChatIdOrNull($chatId) : null;

        AccessDeniedException::throwIf($user === null or $user->hasAccess() === false);

        $session = Session::start($user->getId());

        $accessToken = $this->jsonWebTokenService->createAccessToken($session);
        $refreshToken = $this->jsonWebTokenService->createRefreshToken($session);

        return new AuthenticateCommandResult($accessToken, $refreshToken);
    }
}