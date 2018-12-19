<?php

namespace App\Services;

use App\Entity\Photo;
use App\Entity\Profile;
use App\Entity\Security\User;
use Doctrine\Common\Collections\ArrayCollection;
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
    const FILEPATH = '/../../../public/data/portfolio/';
    const AVATARSPATH = '/../../../public/data/avatars/';
    const COUNT_PORTFOLIO = 9;

    /**@throws */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->em        = $container->get('doctrine.orm.entity_manager');

    }

    public function singleUploadFile(UploadedFile $file){

        /** @var User $user */
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        /** @var Profile $profile */
        $profile = $this->em->getRepository("App:Profile")->findOneBy(['user'=>$user]);

        /** @var ArrayCollection $portfolio */
        $portfolio = $this->em->getRepository("App:Photo")->findBy(['author'=>$profile]);
        if(count($portfolio->toArray())> self::COUNT_PORTFOLIO )
            throw new UserError(sprintf('Error count portfolio'));


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
        $newFile->setSize($file->getClientSize());
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

    public function changeAvatars(UploadedFile $file) :Profile
    {
        /** @var User $user */
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        /** @var Profile $profile */
        $profile = $this->em->getRepository("App:Profile")->findOneBy(['user'=>$user]);

        $targetDirectory = __DIR__ . self::AVATARSPATH;

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