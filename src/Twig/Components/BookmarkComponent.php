<?php

namespace App\Twig\Components;

use App\Entity\Painting;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent()]
final class BookmarkComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public Painting $painting;

    public function __construct(
        private Security $security,
        private UserRepository $userRepository,
    ) {
    }

    #[LiveAction]
    public function toggleBookmark(): void
    {
        /** @var User */
        $user = $this->security->getUser();
        if ($user->getPaintingsBookmarked()->contains($this->painting)) {
            $user->removePaintingsBookmarked($this->painting);
        } else {
            $user->addPaintingsBookmarked($this->painting);
        }

        $this->userRepository->save($user, flush: true);
    }

    public function isBookmarked(): bool
    {
        /** @var User $user */
        $user = $this->security->getUser();
        return $user->getPaintingsBookmarked()->contains($this->painting);
    }
}
