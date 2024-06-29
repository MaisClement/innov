<?php

namespace App\Controller;

use App\Entity\Files;
use App\Repository\FilesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class File extends AbstractController
{
    private FilesRepository $filesRepository;

    public function __construct(FilesRepository $filesRepository) 
    {
        $this->filesRepository = $filesRepository;
    }

    #[Route('/files/{id}')]
    public function downloadFiles($id)
    {
        $name = $file->getNameFile();

        $filename = $PATH . $name;

        if (is_file($filename)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: 0');
            header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
            header('Content-Length: ' . filesize($filename));
            header('Pragma: public');

            flush();

            readfile($filename);
        }
    }
}
