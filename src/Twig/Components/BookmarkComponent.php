<?php

namespace App\Twig\Components;

use App\Entity\User;
use App\Entity\Painting;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\LiveArg;

#[AsLiveComponent()]
final class BookmarkComponent extends AbstractController
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public bool $redirect = false;

    #[LiveProp(writable: true)]
    public string $tag = 'button';

    #[LiveProp(writable: true)]
    public Painting $painting;

    public function __construct(
        private Security $security,
        private UserRepository $userRepository,
    ) {
    }

    #[LiveAction]
    public function toggleBookmark(): Response|self
    {
        /** @var User */
        $user = $this->security->getUser();
        if ($user->getPaintingsBookmarked()->contains($this->painting)) {
            $user->removePaintingsBookmarked($this->painting);
        } else {
            $user->addPaintingsBookmarked($this->painting);
        }

        $this->userRepository->save($user, flush: true);
        if ($this->redirect) {
            return $this->redirectToRoute('app_profile');
        }
        return $this;
    }

    public function isBookmarked(): bool
    {
        /** @var User $user */
        $user = $this->security->getUser();
        return $user->getPaintingsBookmarked()->contains($this->painting);
    }
}
