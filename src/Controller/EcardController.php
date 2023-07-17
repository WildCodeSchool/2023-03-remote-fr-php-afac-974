<?php

namespace App\Controller;

use App\Entity\Ecard;
use App\Entity\Painting;
use App\Entity\User;
use App\Form\EcardType;
use App\Repository\EcardRepository;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Uid\Factory\UuidFactory;

#[Route('/ecard', name: 'app_')]
class EcardController extends AbstractController
{
    public function __construct(
        private UuidFactory $uuidFactory,
    ) {
    }

    #[Route('/{id<\d+>}', name: 'ecard_painting')]
    #[IsGranted('ROLE_USER')]
    public function index(
        Painting $painting,
        Request $request,
        EcardRepository $ecardRepository,
        MailerInterface $mailer
    ): Response {

        $ecard = new Ecard();
        $form = $this->createForm(EcardType::class, $ecard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sentTo = $form->get('sentTo')->getData();
            $ecard->setUuid($this->uuidFactory->create());
            $ecard->setPainting($painting);
            $ecard->setUser($this->getUser());
            $ecard->setSendedAt(new DateTime('now'));
            $ecardRepository->save($ecard, true);

            $mail = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($sentTo)
                ->subject('Vous avez reçu une carte éléctronique ! - AFAC974')
                ->html($this->renderView('mail/template_mail.html.twig', [
                    'user' => $ecard->getUser(),'ecard' => $ecard
                ]));

            $mailer->send($mail);
            $this->addFlash('success', 'Votre e-card à bien été envoyée !');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('ecard/index.html.twig', [
            'painting' => $painting,
            'form' => $form
        ]);
    }

    #[Route('/show/{uuid}', name: 'ecard_show')]
    public function show(Ecard $ecard): Response
    {
        return $this->render('ecard/show.html.twig', [
            'ecard' => $ecard
        ]);
    }

    #[Route('/historique-ecard', name:"ecard_galery", priority: 1)]
    #[IsGranted('ROLE_USER')]
    public function ecardGalery(
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        /** @var User $user */
        $user = $this->getUser();

        $pagination = $paginator->paginate(
            $user->getEcards(),
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('ecard/galery.html.twig', [
            'ecards' => $pagination
        ]);
    }
}
