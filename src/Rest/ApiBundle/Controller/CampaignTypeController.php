<?php

namespace Rest\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Rest\ApiBundle\Entity\CampaignType;
use Rest\ApiBundle\Form\CampaignTypeType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class CampaignTypeController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @ApiDoc(
     *  description="Create new Campaign Type",
     * )
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postAction(Request $request)
    {
        $campaignType = new CampaignType();
        $form = $this->createForm(CampaignTypeType::class, $campaignType, [
            'csrf_protection' => false,
        ]);

        $form->submit($request->request->all());

        if (!$form->isValid()) {
            $response = [
                'errors' => (string) $form->getErrors(true, false),
            ];

            $view = $this->view($response, 200);

            return $this->handleView($view);
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($campaignType);
        $manager->flush();

        $view = $this->view([
            'id' => $campaignType->getId(),
            'name' => $campaignType->getName(),
        ], 200);

        return $this->handleView($view);
    }
}
