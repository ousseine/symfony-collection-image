<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Wedded;
use App\Form\ImageType;
use App\Form\WeddedType;
use App\Service\UploaderImageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class WeddingController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly UploaderImageService $imageService,
    ){
    }

    #[Route('/', name: 'wedding')]
    #[Route('/index', name: 'wedding_index')]
    public function index(): Response
    {
        return $this->render('wedding/index.html.twig', [
            'wedds' => $this->manager->getRepository(Wedded::class)->findAll()
        ]);
    }

    #[Route('/nouveau', name: 'wedding_new', methods: ['GET', 'POST'])]
    #[Route('/modifier/{id}', name: 'wedding_edit', methods: ['GET', 'POST'])]
    public function form(Request $request, Wedded $wedded = null): Response
    {
        if (!$wedded) $wedded = new Wedded();

        $form = $this->createForm(WeddedType::class, $wedded);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$wedded->getId()) {
                $images = $form->get('images')->getData();

                if ($images) {
                    foreach ($images as $item) {
                        $image = new Image();

                        $imageName = $this->imageService->uploade($item);
                        $image->setName($imageName);
                        $wedded->addImage($image);

                        $this->manager->persist($image);
                    }
                }

                $this->manager->persist($wedded);
            }

            $this->manager->flush();

            return $this->redirectToRoute('wedding_index');
        }

        return $this->render('wedding/form.html.twig', [
            'form' => $form,
            'wedd' => $wedded
        ]);
    }

    #[Route('/{id}', name: 'wedding_delete', methods: ['POST'])]
    public function delete(Wedded $wedded, Request $request): RedirectResponse
    {
        $token = $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete', $token)) {

            if ($wedded->getImages() !== null) {
                foreach ($wedded->getImages() as $image) {
                    $imageExist = $this->getParameter('image_directory') .'/'. $image->getName();
                    if (is_file($imageExist)) unlink($imageExist);
                }
            }

            $this->manager->remove($wedded);
            $this->manager->flush();
        }

        return $this->redirectToRoute('wedding_index');
    }
}
