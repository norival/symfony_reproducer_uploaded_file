<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

#[AsController]
#[Route('/upload-file', 'upload-file')]
class UploadFileController
{
    public function __construct(
        private readonly Environment $twig
    ) {
    }

    public function __invoke(Request $request): Response
    {
        if ('POST'=== $request->getMethod()) {
            /** @var UploadedFile $file */
            $file = $request->files->get('file');

            return new Response($this->twig->render('upload-file.html.twig', [
                'realPath' => $file->getRealPath(),
            ]));
        }

        return new Response($this->twig->render('upload-file.html.twig', [
            'maxFileSize' => ini_get('upload_max_filesize'),
            'postMaxSize' => ini_get('post_max_size'),
        ]));
    }
}
