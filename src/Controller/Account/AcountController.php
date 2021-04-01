<?php

namespace App\Controller\Account;

use App\Form\ChangePasswordType;
use App\Form\UserInformationChangeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AcountController extends AbstractController
{
    /**
     * @Route("/compte", name="acount")
     */
    public function index(): Response
    {

        return $this->render('acount/index.html.twig', [

        ]);
    }

    /**
     * @Route("/compte/Modifier-mes-information", name="account_information")
     */
    public function information(Request $request, EntityManagerInterface $manager)
    {
        $user=$this->getUser();
        $form =$this->createForm(UserInformationChangeType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $manager->persist($user);
            $manager->flush();
            $this->addFlash("success", "Vos information ont bien ete modifier");
        }
        return $this->render("acount/information.html.twig",[
            "form"=>$form->createView()
        ]);
    }

    /**
     *@Route("/compte/modifier-mon-mot-de-passe", name="account_password")
     */
    public function passwordUpdate(Request $request,
                                   UserPasswordEncoderInterface $encoder,
                                   EntityManagerInterface $manager)
    {
        $user= $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $old_pwd = $form->get('password')->getData();

            if ($encoder->isPasswordValid($user,$old_pwd)){

                $new_pwd = $form->get('new_password')->getData();
                $password = $encoder->encodePassword($user, $new_pwd);

                $user->setPassword($password);
                $manager->flush();
                $this->addFlash("success","Votre mot de passe a bien ete modifier");
            }else{
                $this->addFlash("danger", "Votre mot de passe actuel n est pas le bon");
            }
        }

        return $this->render("acount/password.html.twig",[
            "form"=>$form->createView()
        ]);
    }

    /**
     * @Route("/compte/mes-commandes", name="account_order")
     */
    public function orderListe()
    {
        dd("ok");
        //TODO a faire
    }
}
