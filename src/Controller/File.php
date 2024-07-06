<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Entity\Files;
use App\Repository\IdeaRepository;
use App\Repository\FilesRepository;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class File extends AbstractController
{
    private IdeaRepository $ideaRepository;
    private FilesRepository $filesRepository;

    public function __construct(IdeaRepository $ideaRepository, FilesRepository $filesRepository) 
    {
        $this->ideaRepository = $ideaRepository;
        $this->filesRepository = $filesRepository;
    }

    #[Route('/download/{id}')]
    public function downloadFiles($id)
    {
        $file = $this->filesRepository->find($id);
        $PATH = "../upload_files/";
        $filename = $PATH . $id;
        $original_name = $file->getNameFile();
    
        if (!file_exists($filename)) {
            throw new \Exception("Fichier non trouvé: $filename");
        }
    
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

    #[Route('/download_all/{id}')]
    public function downloadAllFiles($id)
    {
        $idea = $this->ideaRepository->find($id);
        $files = $idea->getFiles();

        $zip = new \ZipArchive();
        $zipFile = tempnam(sys_get_temp_dir(), 'idea_files_');
        $zip->open($zipFile, \ZipArchive::CREATE);

        foreach ($files as $file) {
            $filePath = '../upload_files/'. $file->getId();
            $zip->addFile($filePath, $file->getNameFile());
        }
        
        $zip->close();

        $response = new StreamedResponse();
        $response->setCallback(function () use ($zipFile) {
            readfile($zipFile);
            unlink($zipFile);
        });
        $response->headers->set('Content-Type', 'application/zip');
        $response->headers->set('Content-Disposition', 'attachment; filename="idea_files_'. $id. '.zip"');
        $response->headers->set('Content-Length', filesize($zipFile));

        return $response;
    }
}
