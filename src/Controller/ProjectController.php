<?php

namespace App\Controller;

use App\Form\ProjectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Project;


class ProjectController extends AbstractController
{
    /**
     * @Route("/project", name="project_list")
     */
    public function index()
    {
        return $this->render('project/index.html.twig', [
            'controller_name' => 'ProjectController',
        ]);
    }

    /**
     * @Route("/project/new", name="project_new")
     */
    public function new(Request $request)
    {
        $project=new Project();
        $project->setCreated(new \DateTime());


        $form=$this->createFormBuilder($project)
            ->add('name', TextType::class, array('label' => 'Project.New.NameField'))
            ->add('creator')
            ->add('managers')
            ->add('save', SubmitType::class, array('label' => 'Project.New.Create'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();



            return $this->redirectToRoute('project_show',array('id'=>$project->getId()));
        }

        return $this->render('project/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/project/show/{id}", methods={"GET","HEAD"},name="project_show")
     */
    public function show($id)
    {
        return $this->render('project/show.html.twig', [
            'controller_name' => 'ProjectController',
        ]);
    }
}
