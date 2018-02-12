<?php
namespace Rest\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Rest\ApiBundle\Entity\Campaign;
use Rest\ApiBundle\Form\CampaignType;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Class CampaignController
 */
class CampaignController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @ApiDoc(
     *  description="Create new Campaign",
     * )
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postAction(Request $request)
    {
        $token = $this->get('security.token_storage')->getToken();
        $user = $token->getUser();

        $campaign = new Campaign();
        $campaign->setUser($user);

        $form = $this->createForm(CampaignType::class, $campaign, [
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
        $manager->persist($campaign);
        $manager->flush();

        $view = $this->view([
            'id' => $campaign->getId(),
            'name' => $campaign->getName(),
            'campaignTypeId' => $campaign->getCampaignType()->getId(),
        ], 200);

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  description="Update Campaign",
     * )
     *
     * @param Request  $request
     * @param Campaign $campaign
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putAction(Request $request, Campaign $campaign)
    {
        $form = $this->createForm(CampaignType::class, $campaign, [
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
        $manager->flush();

        $view = $this->view([
            'id' => $campaign->getId(),
            'name' => $campaign->getName(),
            'campaignTypeId' => $campaign->getCampaignType()->getId(),
        ], 200);

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  description="Delete Campaign",
     * )
     *
     * @param Campaign $campaign
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Campaign $campaign)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($campaign);
        $manager->flush();

        $view = $this->view([], 200);

        return $this->handleView($view);
    }
}
