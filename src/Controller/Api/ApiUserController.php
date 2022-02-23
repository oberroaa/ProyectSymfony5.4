<?php

namespace App\Controller\Api;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;

/**
 * @Route("/api/user", name="api_user")
 * @OA\Tag(name="api_user")
 */
class ApiUserController extends AbstractController
{
    private $client;
    private $em;
    private $token;
    private $limiter;
    public function __construct(HttpClientInterface $client, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, RateLimiterFactory $anonymousApiLimiter)
    {
        $this->client = $client;
        $this->em = $entityManager;
        $this->token = $tokenStorage->getToken();
        $this->limiter = $anonymousApiLimiter;
    }

    /**
     * @Route("/info", name="api_info" , methods={"GET"})
     */
    public function fetchGitHubInformation(): Response
    {
        $current_user = $this->token->getUser();
        $limiter = $this->limiter->create($current_user);
        $limiter->reserve(1)->wait();
        $response = $this->client->request(
            'GET',
            'https://api.github.com/repos/symfony/symfony-docs'
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $this->json([
            $content
        ]);
    }

    /**
     * @Route("/", name="api_user" , methods={"GET"})
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        //$hasAccess = $this->isGranted('ROLE_ADMIN');
        //$this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->json([
            'message' => $this->getUser()->getUserIdentifier(),
            'path' => 'src/Controller/Api/ApiUserController.php',
        ]);
    }
}
