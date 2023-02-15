<?php

namespace App\Controller;
use App\Entity\Synopsis;
use App\Form\SynopsisType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Repository\SynopsisRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BibliothequeController extends AbstractController
{
    /**
     * @Route("/bibliothequeCreate", name="app_bibliotheque")
     * 
     */

    public function AddAnime(Request $request): Response
    {   
            $data = $request->getContent();
            $data = json_decode($data, true);
            $EntityManager = $this->getDoctrine()->getManager();
            $synopsis = new Synopsis();
            $synopsis->setTitre($data["Titre"]);
            $synopsis->setTitreOriginal($data["TitreOriginal"]);
            $synopsis->setGenre($data["Genre"]);
            $synopsis->setTheme($data["Theme"]);
            $synopsis->setTitre($data["Titre"]);
            $synopsis->setNombreEpisode($data["NombreEpisode"]);
            $synopsis->setAgeConseiller($data["AgeConseiller"]);
            $synopsis->setDateDiffusion($data["DateDiffusion"]);
            $synopsis->setStudio($data["Studio"]);
            $synopsis->setSynopsis($data["synopsis"]);
            $imageFile = $synopsis->get('AnimeImage')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                
                try {
                    $imageFile->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Image cannot be saved.');
                }
                $synopsis->setAnimeImage($newFilename);
            }
            $EntityManager->persist($synopsis);
            $EntityManager->flush();
            return $this->json('Created new project successfully with id ' . $synopsis->getId());
    }
    /**
     * @Route("/list", name="bibliotheque_list", methods={"GET"})
     */
    public function index(): Response
    {
        $Lists = $this->getDoctrine()
            ->getRepository(Synopsis::class)
            ->findAll();
  
        $data = [];
  
        foreach ($Lists as $list) {
           $data[] = [
               'id' => $list->getId(),
               'Titre' => $list->getTitre(),
               'TitreOriginal' => $list->getTitreOriginal(),
               'Genre' => $list->getGenre(),
               'Theme' => $list->getTheme(),
               'NombreEpisode' => $list->getNombreEpisode(),
               'Origine' => $list->getOrigine(),
               'AgeConseiller' => $list->getAgeConseiller(),
               'DateDiffusion' => $list->getDateDiffusion(),
               'Studio' => $list->getStudio(),
               'synopsis' => $list->getSynopsis(),
               'AnimeImage' => $list->getAnimeImage(),
           ];
        }
  
  
        return $this->json($data);
    }
     /**
     * @Route("/bibliothequeShow/{id}", name="bibliotheque_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $anime = $this->getDoctrine()
            ->getRepository(Synopsis::class)
            ->find($id);
  
        if (!$anime) {
  
            return $this->json('No anime found for id' . $id, 404);
        }
  
        $data =  [
            'id' => $anime->getId(),
            'Titre' => $anime->getTitre(),
            'TitreOriginal' => $anime->getTitreOriginal(),
            'Genre' => $anime->getGenre(),
            'Theme' => $anime->getTheme(),
            'NombreEpisode' => $anime->getNombreEpisode(),
            'Origine' => $anime->getOrigine(),
            'AgeConseiller' => $anime->getAgeConseiller(),
            'DateDiffusion' => $anime->getDateDiffusion(),
            'Studio' => $anime->getStudio(),
            'synopsis' => $anime->getSynopsis(),
            'AnimeImage' => $anime->getAnimeImage(),
        ];
          
        return $this->json($data);
    }
    public function edit(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $synopsis = $entityManager->getRepository(Synopsis::class)->find($id);
  
        if (!$synopsis) {
            return $this->json('No anime found for id' . $id, 404);
        }
         
        $content = json_decode($request->getContent());
         
        $synopsis->setTitre($content->Titre);
        $synopsis->setTitreOriginal($content->TitreOriginal);
        $synopsis->setGenre($content->Genre);
        $synopsis->setTheme($content->Theme);
        $synopsis->setNombreEpisode($content->NombreEpisode);
        $synopsis->setOrigine($content->Origine);
        $synopsis->setAgeConseiller($content->AgeConseiller);
        $synopsis->setDateDiffusion($content->DateDiffusion);
        $synopsis->setStudio($content->Studio);
        $synopsis->setSynopsis($content->synopsis);
        $imageFile = $synopsis->get('AnimeImage')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                
                try {
                    $imageFile->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Image cannot be saved.');
                }
                $synopsis->setAnimeImage($content->$newFilename);
            }
        $entityManager->flush();
  
        $data =  [
            'id' => $synopsis->getId(),
            'Titre' => $synopsis->getTitre(),
            'TitreOriginal' => $synopsis->getTitreOriginal(),
            'Genre' => $synopsis->getGenre(),
            'Theme' => $synopsis->getTheme(),
            'NombreEpisode' => $synopsis->getNombreEpisode(),
            'Origine' => $synopsis->getOrigine(),
            'AgeConseiller' => $synopsis->getAgeConseiller(),
            'DateDiffusion' => $synopsis->getDateDiffusion(),
            'Studio' => $synopsis->getStudio(),
            'synopsis' => $synopsis->getSynopsis(),
            'AnimeImage' => $synopsis->getAnimeImage(),
        ];
          
        return $this->json($data);
    }
    /**
     * @Route("/bibliothequeDelete/{id}", name="anime_delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $anime = $entityManager->getRepository(Synopsis::class)->find($id);
  
        if (!$anime) {
            return $this->json('No anime found for id' . $id, 404);
        }
  
        $entityManager->remove($anime);
        $entityManager->flush();
  
        return $this->json('Deleted a anime successfully with id ' . $id);
    }
  
  
}
