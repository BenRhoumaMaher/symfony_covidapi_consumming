<?php
/**
 * HomeController.php
 *
 * This file contains the definition of the HomeController class, which handles
 * actions related to Covid informations in the United States.
 *
 * @category Controllers
 * @package  App\Controller\Home
 * @author   Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 * @license  No license (Personal project)
 * @link     https://symfony.com/doc/current/controller.html
 * @since    PHP 8.2
 */

namespace App\Controller;

use App\Service\CallApiService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * HomeController
 *
 * @category Controllers
 *
 * @package App\Controller\Home
 *
 * @author Maher Ben Rhouma <maherbenrhoumaaa@gmail.com>
 *
 * @license No license (Personal project)
 *
 * @link https://symfony.com/doc/current/controller.html
 */

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]

    /**
     * Index Method to handle each department information
     *
     * @param CallApiService $callApiService Service to call APIs.
     * @return Response HTTP response.
     */
    public function index(CallApiService $callApiService): Response
    {
        return $this->render(
            'home/index.html.twig',
            [
                'data' => $callApiService->getUsaData(),
                'departments' => $callApiService->getAllData(),
            ]
        );
    }
}
