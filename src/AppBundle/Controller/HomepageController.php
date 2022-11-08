<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\NewsCategory;
use AppBundle\Entity\News;
use AppBundle\Entity\Testimonial;
use AppBundle\Entity\Banner;
use AppBundle\Entity\Contact;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class HomepageController extends Controller
{
    public function indexAction(Request $request)
    {
        $listCategoriesOnHomepage = $this->get('settings_manager')->get('listCategoryOnHomepage');
        $blocksOnHomepage = array();

        if (!empty($listCategoriesOnHomepage)) {
            $listCategoriesOnHomepage = json_decode($listCategoriesOnHomepage, true);

            if (is_array($listCategoriesOnHomepage)) {
                for ($i = 0; $i < count($listCategoriesOnHomepage); $i++) {
                    $blockOnHomepage = [];
                    $category = $this->getDoctrine()
                                    ->getRepository(NewsCategory::class)
                                    ->find($listCategoriesOnHomepage[$i]["id"]);

                    if ($category) {
                        $listCategoriesIds = array($category->getId());
                        $listSubIds = explode(",", $listCategoriesOnHomepage[$i]["subId"]);
                        $listSubTabs = [];

                        if ($listCategoriesOnHomepage[$i]["subId"] != null && count($listSubIds) > 0) {
                            for ($j = 0; $j < count($listSubIds); $j++) {
                                $subCat = $this->getDoctrine()
                                        ->getRepository(NewsCategory::class)
                                        ->find($listSubIds[$j]);

                                if ($subCat) {
                                    $posts = $this->getDoctrine()
                                        ->getRepository(News::class)
                                        ->createQueryBuilder('n')
                                        ->leftJoin('n.category', 't')
                                        ->where('t.id =:subCat')
                                        ->andWhere('n.enable = :enable')
                                        ->setParameter('subCat', $subCat->getId())
                                        ->setParameter('enable', 1)
                                        ->orderBy('n.createdAt', 'DESC')
                                        ->setMaxResults( $listCategoriesOnHomepage[$i]["items"] )
                                        ->getQuery()->getResult();
                                }

                                $listSubTabs[] = (object) array('subCategory' => $subCat, 'posts' => $posts);
                            }
                        } else {
                            $posts = $this->getDoctrine()
                                ->getRepository(News::class)
                                ->createQueryBuilder('n')
                                ->leftJoin('n.category', 't')
                                ->where('t.id =:subCat')
                                ->andWhere('n.enable = :enable')
                                ->setParameter('subCat', $category->getId())
                                ->setParameter('enable', 1)
                                ->orderBy('n.createdAt', 'DESC')
                                ->setMaxResults( $listCategoriesOnHomepage[$i]["items"] )
                                ->getQuery()->getResult();
                        }
                    }

                    $blockOnHomepage = (object) array('category' => $category, 'listSubTabs' => $listSubTabs, 'posts' => $posts, 'description' => $listCategoriesOnHomepage[$i]["description"]);
                    $blocksOnHomepage[] = $blockOnHomepage;
                }
            }
        }

        $banners = $this->getDoctrine()
            ->getRepository(Banner::class)
            ->findBy(
                array('bannercategory' => 1),
                array('createdAt' => 'DESC')
            );

        return $this->render('homepage/index.html.twig', [
            'blocksOnHomepage' => $blocksOnHomepage,
            'banners' => $banners,
            'showSlide' => true
        ]);
    }

    /**
     * Render list testimonial
     * @return Testimonial
     */
    public function listTestimonialAction($template = NULL)
    {
        $testimonial = $this->getDoctrine()
            ->getRepository(Testimonial::class)
            ->findAll();

        if (!$template) {
            return $this->render('testimonial/testimonial.html.twig', [
                'testimonial' => $testimonial,
            ]);
        } else {
            return $this->render($template, [
                'testimonial' => $testimonial
            ]);
        }
    }

    public function renderFormContactAction()
    {
        $contact = new Contact();
        
        $form = $this->createFormBuilder($contact)
            ->setAction($this->generateUrl('homepagecontact'))
            ->add('name', TextType::class, array('label' => 'Tên của bạn'))
            ->add('email', EmailType::class, array('label' => 'Email của bạn', 'required' => false))
            ->add('phone', TextType::class, array('label' => 'Số điện thoại'))
            ->add('send', ButtonType::class, array('label' => 'Gửi'))
            ->getForm();

        return $this->render('layout/contactFooter.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/homepage-contact", name="homepagecontact")
     * 
     * @return JSON
     */
    public function handleContactFormAction(Request $request, \Swift_Mailer $mailer)
    {
        if (!$request->isXmlHttpRequest()) {
            return new Response(
                json_encode(
                    array(
                        'status'=>'error',
                        'message' => 'You can access this only using Ajax!'
                    )
                )
            );
        } else {
            $contact = new Contact();
            
            $form = $this->createFormBuilder($contact)
                ->add('name', TextType::class)
                ->add('email', EmailType::class)
                ->add('phone', TextType::class)
                ->getForm();

            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($contact);
                $em->flush();

                if (null !== $contact->getId()) {
                    
                    /* $message = \Swift_Message::newInstance()
                        ->setSubject($this->get('translator')->trans('comment.email.title', ['%siteName%' => $this->get('settings_manager')->get('siteName')]))
                        ->setFrom(['hotro.xaydungminhduy@gmail.com' => $this->get('settings_manager')->get('siteName')])
                        ->setTo($this->get('settings_manager')->get('emailContact'))
                        ->setBody(
                            $this->renderView(
                                'Emails/contact.html.twig',
                                array(
                                    'name' => $request->request->get('form')['name'],
                                    'email' => $request->request->get('form')['email'],
                                    'phone' => $request->request->get('form')['phone']
                                )
                            ),
                            'text/html'
                        )
                    ;

                    $mailer->send($message); */
    
                    return new Response(
                        json_encode(
                            array(
                                'status'=>'success',
                                'message' => 'Chúng tôi đã nhận được thông tin của bạn. Chúng tôi sẽ kiểm tra và liên hệ sớm đến bạn!'
                            )
                        )
                    );
                } else {
                    return new Response(
                        json_encode(
                            array(
                                'status'=>'error',
                                'message' => $this->get('translator')->trans('comment.have_a_problem_on_your_request')
                            )
                        )
                    );
                }
            } else {
                return new Response(
                    json_encode(
                        array(
                            'status'=>'error',
                            'message' => $this->get('translator')->trans('comment.have_a_problem_on_your_request')
                        )
                    )
                );
            }
        }
    }
}
