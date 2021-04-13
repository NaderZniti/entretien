<?php

namespace App\Controller;

use App\Entity\Hotel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewController extends AbstractController
{
    /**
     * @Route("/admin/index/hotel", name="admin_hotel")
     */
    public function index(): Response
    {

        $hotel = $this->getDoctrine()->getRepository('App\Entity\Hotel')->findAll();
        // dd($hotel);
        return $this->render('hotel/index.html.twig', [
            'page' => 'hotel',
            'hotel' => $hotel
        ]);
        
    }

     /**
     * @Route("/admin/remove/hotel/{id}", name="del_hotel")
     */

    public function remove ($id)
    {
        $hotel = $this->getDoctrine()->getRepository('App\Entity\Hotel')->find($id);
        if($hotel){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hotel);
            $entityManager->flush();
        }
		
        return $this->redirectToRoute('admin_hotel');
    }

    /**
     * @Route("/admin/hotel/modfiy/{id}", name="modfiy_hotel")
     */
    
    public function modfiy($id)
    {
        $hotel = $this->getDoctrine()->getRepository('App\Entity\Hotel')->find($id);
        return $this->render('hotel/update.html.twig', [
            'page' => 'hotel',
            'hotel' => $hotel
        ]);
    }

    /**
     * @Route("/admin/hotel/modfiy_check/{id}", name="modfiy_check_hotel")
     */
    public function modfiy_check(Request $request,$id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $hotel = $this->getDoctrine()->getRepository('App\Entity\Hotel')->find($id);
        $hotel->setNom($request->get("nom"));
        $hotel->setAdresse($request->get("adresse"));
		$entityManager->persist($hotel);
        $entityManager->flush();
        return $this->redirectToRoute('admin_hotel');
    }
    
    
    /**
     * @Route("/admin/hotel/add", name="add_hotel")
     */

    public function add()
    {
        return $this->render('hotel/add.html.twig', [
            'page' => 'hotel',
        ]);
    }

     /**
     * @Route("/admin/hotel/add_check", name="add_check_hotel")
     */
    public function add_check(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $hotel = new Hotel();
        $hotel->setNom($request->get("nom"));
        $hotel->setAdresse($request->get("description"));
        // $hotel->setSalaire($request->get("salaire"));
		$entityManager->persist($hotel);
        $entityManager->flush();
        return $this->redirectToRoute('admin_hotel');
    }
}
