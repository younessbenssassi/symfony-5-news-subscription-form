<?php

namespace App\Controller;
use App\Entity\Subscriber;
use App\Form\SubscriberFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class DashbordController extends AbstractController
{
    /**
     * @Route("/dashbord", name="dashbord")
     */
    public function index(): Response
    {
      $json = file_get_contents('../data.json');
      $json_data = json_decode($json,true);
        return $this->render('dashbord/index.html.twig', [
            'controller_name' => 'DashbordController',
            'subscribers' => $json_data,
        ]);
    }




    /**
     * @Route("/dashbord/delete/{email}", name="delet_subscriber")
     */
    public function delete(Request $request)
    {

        $json = file_get_contents('../data.json');
        $subscribers = json_decode($json,true);
        $email= $request->get('email');

        $key = array_search($email,array_column($subscribers,'email'),true);
        $key2=array_keys($subscribers);
        $real_key=$key2[$key];
        //dd($real_key);
        unset($subscribers[$real_key]);

        $json = json_encode($subscribers);
        file_put_contents('../data.json', $json);
        return new RedirectResponse('../');

    }



    /**
     * @Route("/dashbord/edit/{email}", name="edit_subscriber")
     */
    public function edit(Request $request)
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
           $delete=$this->delete($request);
           return new RedirectResponse('../');
         }

         else {
           $json = json_encode($new);
           file_put_contents('../data.json', $json);
           $delete=$this->delete($request);
           return new RedirectResponse('../');
         }
       }


       return $this->render('dashbord/edit.html.twig', [
           'controller_name' => 'DashbordController',
           'edit_form' => $form->createView(),
       ]);


    }
}
