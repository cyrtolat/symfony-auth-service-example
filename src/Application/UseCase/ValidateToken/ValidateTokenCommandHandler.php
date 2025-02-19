<?php

namespace App\Application\UseCase\ValidateToken;

use App\Application\Abstract\AbstractCommandHandler;
use App\Application\Contract\JsonWebTokenServiceContract;
use App\Application\Contract\UserReadRepositoryContract;
use App\Application\Support\AccessDeniedException;

readonly class ValidateTokenCommandHandler extends AbstractCommandHandler
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

    public function __invoke(ValidateTokenCommand $command): ValidateTokenCommandResult
    {
        $session = $this->jsonWebTokenService->verifyAccessToken($command->accessToken);
        $user = $session ? $this->userReadRepository->getByIdOrNull($session->userId) : null;

        AccessDeniedException::throwIf($user === null or $user->hasAccess() === false);

        return new ValidateTokenCommandResult($user->getId());
    }
}