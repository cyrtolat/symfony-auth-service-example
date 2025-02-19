<?php

namespace App\Application\UseCase\RefreshToken;

use App\Application\Abstract\AbstractCommandHandler;
use App\Application\Contract\JsonWebTokenServiceContract;
use App\Application\Contract\UserReadRepositoryContract;
use App\Application\Support\AccessDeniedException;

readonly class RefreshTokenCommandHandler extends AbstractCommandHandler
{
    private JsonWebTokenServiceContract $jsonWebTokenService;
    private UserReadRepositoryContract  $userReadRepository;

    public function __construct(
        JsonWebTokenServiceContract $jsonWebTokenService,
        UserReadRepositoryContract $userReadRepository
    )
    {
        $this->jsonWebTokenService = $jsonWebTokenService;
        $this->userReadRepository = $userReadRepository;
    }

    public function __invoke(RefreshTokenCommand $command): RefreshTokenCommandResult
    {
        $session = $this->jsonWebTokenService->verifyRefreshToken($command->refreshToken);
        $user = $session ? $this->userReadRepository->getByIdOrNull($session->userId) : null;

        AccessDeniedException::throwIf($user === null or $user->hasAccess() === false);

        $this->jsonWebTokenService->revokeAccessToken($session);
        $this->jsonWebTokenService->revokeRefreshToken($session);

        $accessToken = $this->jsonWebTokenService->createAccessToken($session);
        $refreshToken = $this->jsonWebTokenService->createRefreshToken($session);

        return new RefreshTokenCommandResult($accessToken, $refreshToken);
    }
}