<?php
namespace App\Service;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileServices extends AbstractController
{
    public $slugger;
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public function UploadFiles($file): string
    {
        $formMenuFile = $file;

        if ($formMenuFile) {

            $originalFilename = pathinfo($formMenuFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $this->slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $formMenuFile->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $formMenuFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                dd("folder not found");
                // ... handle exception if something happens during file upload
            }


            return $newFilename;

        }


        return '';
    }
}