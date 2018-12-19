<?php

namespace App\Services;

use Doctrine\ORM\EntityManager;
use GraphQL\Error\UserError;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FilesService
{
    private $container;
    /**@var $em EntityManager */
    private $em;

    /**@throws */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->em        = $container->get('doctrine.orm.entity_manager');

    }

    public function singleUploadFile($idFileDoc, UploadedFile $file){

        /** @var FileDocuments $fileDoc */
        $fileDoc = $this->em->getRepository("App:Files\FileDocuments")->find($idFileDoc);
        if(!$fileDoc) throw new UserError(sprintf('Could not find filedocument #%d', $idFileDoc));

        $targetDirectory = __DIR__ . self::FILEPATH;

        $realName = $file->getClientOriginalName();
        $mimeType = $file->getClientMimeType();
        $extName  = $file->getClientOriginalExtension();

        $uniqName = $this->generateUniqFileName($extName);


//////////////////////////////// проверка существования файла с таким именем
        $finder = new Finder();
        $finder->files()->in($targetDirectory)->name($uniqName);
        while (count($finder)) {
            $uniqName = $this->generateUniqFileName($extName);
            $finder->files()->in($targetDirectory)->name($uniqName);
        }
/////////////////////// поиск существующего имени файла в директории
        $realName = str_replace("." . $file->getClientOriginalExtension(), "", $realName);
        $search = $this->em->getRepository("App:Files\Files")->findBy(["realFileName" => $realName, "fileDocument" => $fileDoc->getId(),]);

        $i = 1;
        while (count($search)) {
            $realName = $realName . "(" . $i . ")";
            $search = $this->em->getRepository("App:Files\Files")->findBy([
                "realFileName" => $realName,
                "fileDocument" => $fileDoc->getId(),
            ]);
            $i++;
        }
///////////////////Добавление новоро файла в базу /////////////////////

        $newFile = new Files();
        $newFile->setAuthor(NULL);
        $newFile->setFileDocument($fileDoc);
        $newFile->setFilePath($targetDirectory.$uniqName);
        $newFile->setSize($file->getClientSize());
        $newFile->setType($file->getClientOriginalExtension());
        $newFile->setRealFileName($realName);
        $newFile->setUniqFileName($uniqName);
        if($fileDoc->getFiles()) {

            /** @var Files $neighbour */
            $neighbour = $this->em->getRepository("App:Files\Files")->findOneBy(["fileDocument"=>$fileDoc, "neighbourTop"=>NULL]);
            if($neighbour){
                $neighbour->setNeighbourTop($newFile);
                $newFile->setNeighbourBottom($neighbour);
            }

        }else{
            $newFile->setNeighbourTop(NULL);
        }

        $this->em->persist($newFile);
        $file->move($targetDirectory, $uniqName);


        $finder->files()->in($targetDirectory)->name($uniqName);
        if (!count($finder))
            throw new UserError(sprintf('Error loading file'));
        $this->em->flush();

        $action = "singleUploadFile";
        $event = new SendSocketUpdateEvent($this->serializableFile($action, $newFile));
        $this->container->get("event_dispatcher")->dispatch("send_socket_update", $event);

        return $newFile;
    }
}