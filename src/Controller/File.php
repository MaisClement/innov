<?php

namespace App\Controller;

use App\Entity\Files;
use App\Repository\FilesRepository;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
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

    #[Route('/download/{id}')]
    public function downloadFiles($id)
    {
        $file = $this->filesRepository->find($id);
        $name = $file->getNameFile();
        $PATH = "../upload_files/";
        $filename = $PATH . $id;
        $original_name = $file->getNameFile();
    
        if (!file_exists($filename)) {
            throw new \Exception("File not found: $filename");
        }
    
        // Send the file to the user
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: 0');
        header('Content-Disposition: attachment; filename="'. $original_name. '"');
        header('Content-Length: '. filesize($filename));
        header('Pragma: public');
    
        ob_flush();
        ob_end_flush();
    
        return new BinaryFileResponse($filename, 200, [
            'Content-Disposition' => 'attachment; filename="'. basename($filename). '"',
            'Cache-Control' => 'no-cache, must-revalidate',
        ]);
    }
}
