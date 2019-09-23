<?php

namespace App\Controller;

use App\Api\DistanceApi;
use App\Api\IpGeolocationApi;
use App\Form\DistanceType;
use App\Service\DataValidatorService;
use App\Service\DistanceService;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DistanceController extends Controller
{
    /**
     * Distance between ip addresse and postal addresse.
     *
     * @Route("/")
     */
    public function index(Request $request, DistanceApi $distanceApi)
    {
        $distance = null;
        $form = $this->createForm(DistanceType::class, []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $distance = $distanceApi->getDistatnce($data);
            if(isset($distance->code) && $distance->code === 'validation_error'){
                foreach ($distance->errors as $error){
                    $form->get(trim($error->property, "[]"))->addError(new FormError($error->message));
                }
            }
        }

        return $this->render('distance/form.html.twig', [
            'form' => $form->createView(),
            'distance' => $distance
        ]);
    }
}
