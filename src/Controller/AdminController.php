<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/analytics", name="analytics")
     */
    public function analyticsAction(){
        return $this->render('analytics/analytics.html.twig');
    }

}