<?php

namespace App\Controller;

use App\Entity\Subscriber;
use App\Controller\Environment ;
use App\Form\SubscriberFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;




class FormController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request ): Response
    {
       $subscriber = new Subscriber();
       $form = $this->createForm(SubscriberFormType::class,$subscriber);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()){
         $interest = $form->get('interest')->getData();
         $FullName = $form->get('FullName')->getData();
         $email = $form->get('email')->getData();

         $json = file_get_contents('../data.json');
         $json_data = json_decode($json,true);


         $new = array(
           'interest'=>$interest ,
           'FullName' =>$FullName,
           'email' =>$email
         );

          if( !$json_data == null){
            array_push($json_data, $new);
            $json = json_encode($json_data);
            file_put_contents('../data.json', $json);
            return new RedirectResponse('thank');
          }

          else {
            $json = json_encode($new);
            file_put_contents('../data.json', $json);
            return new RedirectResponse('thank');
          }


     }




        return $this->render('home/index.html.twig', [
            'controller_name' => 'FormController',
            'subscriber_form' => $form->createView(),
        ]);
    }

}
