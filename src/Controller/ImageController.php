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

#[Route('/admin/image')]
class ImageController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly UploaderImageService $imageService,
    ){
    }

    #[Route('/add/{id}', name: 'image_add', methods: ['GET', 'POST'])]
    public function add(Wedded $wedded, Request $request): JsonResponse
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('name')->getData();
            $imageName = $this->imageService->uploade($imageFile);
            $image->setName($imageName);
            $wedded->addImage($image);

            $this->manager->persist($image);
            $this->manager->flush();
        }

        return new JsonResponse([
            'code' => Response::HTTP_OK,
            'data' => $image->getName(),
            'image' => $this->renderView('image/_img.html.twig', ['image' => $image]),
            'message' => "L'image à bien été enregistrer"
        ], status: Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'image_delete_edit', methods: ['POST'])]
    public function delete(Image $image, Request $request): RedirectResponse
    {
        $token = $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete', $token)) {
            $imageExist = $this->getParameter('image_directory') .'/'. $image->getName();
            if (is_file($imageExist)) unlink($imageExist);

            $this->manager->remove($image);
            $this->manager->flush();
        }

        return $this->redirectToRoute('wedding_edit', ['id' => $image->getWedd()->getId()]);
    }

    public function form(Wedded $wedded): Response
    {
        $form = $this->createForm(ImageType::class);

        return $this->render('image/_form.html.twig', [
            'form' => $form,
            'wedd' => $wedded
        ]);
    }
}
