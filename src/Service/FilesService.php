<?php

namespace App\Service;

use App\Entity\Photo;
use App\Entity\Profile;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use GraphQL\Error\UserError;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FilesService
{
    /** @var $container Container  */
    private $container;

    /**@var $em EntityManager */
    private $em;

    const FILEPATH = '/../../../public/data/portfolio/';
    const AVATARSPATH = '/../../../public/data/avatars/';
    const COUNT_PORTFOLIO = 9;
    const MAX_FOTOSIZE = 25; // size file MB
    const FILES_TYPES = ['gif', 'png', 'bmp', 'ico', 'jpeg', 'jpg' ];
    /**
     * @param $container
     * @throws
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->em        = $container->get('doctrine.orm.entity_manager');

    }

    /**
     * @param UploadedFile $file
     * @return Photo
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function singleUploadFile(UploadedFile $file){

        if($file->getSize()/1048576 > self::MAX_FOTOSIZE )
            throw new UserError(sprintf('Error maxsize foto'));
        if( !in_array(strtolower($file->getType()), self::FILES_TYPES))
             throw new UserError(sprintf("Unrecognized file's type"));

        /** @var Profile $profile */
        $profile =  $this->container->get("profile.service")->getProfile();
        if(!$profile) throw new UserError(sprintf('Could not find people profile'));


            /** @var ArrayCollection $portfolio */
        $portfolio = $this->em->getRepository("App:Photo")->findBy(['author'=>$profile]);
        if(count($portfolio->toArray())> self::COUNT_PORTFOLIO )
            throw new UserError(sprintf('Error count portfolio'));




        $targetDirectory = __DIR__ . self::FILEPATH;

        $realName = $file->getClientOriginalName();
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
        $search = $this->em->getRepository("App:Files\Files")->findBy(["realFileName" => $realName]);

        $i = 1;
        while (count($search)) {
            $realName = $realName . "(" . $i . ")";
            $search = $this->em->getRepository("App:Files\Files")->findBy([
                "realFileName" => $realName
            ]);
            $i++;
        }
///////////////////Добавление новоро файла в базу /////////////////////


        $newFile = new Photo();
        $newFile->setAuthor($profile);
        $newFile->setFilePath($targetDirectory.$uniqName);
        $newFile->setSize($file->getSize());
        $newFile->setType($file->getClientOriginalExtension());
        $newFile->setRealFileName($realName);
        $newFile->setUniqFileName($uniqName);

        $this->em->persist($newFile);
        $file->move($targetDirectory, $uniqName);


        $finder->files()->in($targetDirectory)->name($uniqName);
        if (!count($finder))
            throw new UserError(sprintf('Error loading file'));
        $this->em->flush();

//        $action = "singleUploadFile";
//        $event = new SendSocketUpdateEvent($this->serializableFile($action, $newFile));
//        $this->container->get("event_dispatcher")->dispatch("send_socket_update", $event);

        return $newFile;
    }

    /**
     * @param UploadedFile $file
     * @return Profile
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function changeAvatars(UploadedFile $file) :Profile
    {

        if($file->getSize()/1048576 > self::MAX_FOTOSIZE )
            throw new UserError(sprintf('Error maxsize foto'));
        if( !in_array(strtolower($file->getType()), self::FILES_TYPES))
            throw new UserError(sprintf("Unrecognized file's type"));


        /** @var Profile $profile */
        $profile =  $this->container->get("profile.service")->getProfile();
        if(!$profile) throw new UserError(sprintf('Could not find people profile'));

        $targetDirectory = __DIR__ . self::AVATARSPATH;

        $extName  = $file->getClientOriginalExtension();

        $uniqName = $this->generateUniqFileName($extName);

//////////////////////////////// проверка существования файла с таким именем
        $finder = new Finder();
        $finder->files()->in($targetDirectory)->name($uniqName);
        while (count($finder)) {
            $uniqName = $this->generateUniqFileName($extName);
            $finder->files()->in($targetDirectory)->name($uniqName);
        }
///////////////////Добавление новоро файла в базу /////////////////////
        unlink( $profile->getAvatar());
        $profile->setAvatar($targetDirectory.$uniqName);
        $this->em->flush($profile);

        return $profile;
    }


    private function generateUniqFileName($extName){
        if ($extName && $extName != "") {
            $uniqName = md5(microtime()) . substr(md5(rand()), 0, 9) . "." . $extName;
        } else {
            $uniqName = md5(microtime()) . substr(md5(rand()), 0, 9);
        }
        return $uniqName;
    }
}