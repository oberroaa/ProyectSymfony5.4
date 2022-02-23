<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Uid\Uuid;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;


class LoginController extends AbstractController
{
    private $em;
    private $token;
    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->em = $entityManager;
        $this->token = $tokenStorage->getToken();

    }

    /**
     * @Route("/login", name="login")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
          // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the use
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    /**
     * @Route("/api/login", name="api_login" , methods={"POST"})
     * @OA\Tag(name="api_login")
     * @OA\Parameter(
     *     name="email",
     *     in="query",
     *     description="Correo",
     *     @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="password",
     *     in="query",
     *     description="Contraseña",
     *     @OA\Schema(type="string")
     * )
     */
    public function api_login(Request $request, RateLimiterFactory $anonymousApiLimiter): Response
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'];
        $limiter = $anonymousApiLimiter->create($email);
        $limiter->reserve(1)->wait();

        $user = $this->em->getRepository(User::class)->findOneBy(["email" => $email]);
        if(!$user)
            return $this->json(["success" => false, "errors" => ["No User Exists"], "data" => null]);

        if($user->isVerified() == false)
            return $this->json(["success" => false, "errors" => ["User does not have permission"], "data" => null]);

        $url = $request->getSchemeAndHttpHost();
        $password = $data['password'];
        return $this->login_adm($url,$user->getUsername(),$password, 2785);
    }

    /**
     * @Route("/api/login/adm", name="api_login_adm", methods={"POST"})
     * @OA\Tag(name="api_login")
     */
    public function api_login_adm(Request $request, RateLimiterFactory $anonymousApiLimiter): Response
    {
        // usually you'll want to make sure the user is authenticated first
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $finished = false;
        while (!$finished):
            $uuid = Uuid::v4();
            $existe_uuid = $this->em->getRepository(User::class)->findOneBy(['apiToken'=>$uuid]);
            if (is_null($existe_uuid)):
                $finished = true;
            endif;
        endwhile;

        $user->setApiToken($uuid);
        $this->em->persist($user);
        $this->em->flush();
        $token = $uuid; // somehow create an API token for $user

        return $this->json([
            'user'  => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }

    private function login_adm($sitio,$username,$password,$token)
    {
        if($token != "2785")
            return $this->json(["success" => false, "errors" => ["You have not acceess"], "data" => null]);

        $httpClient = HttpClient::create();
        $uri = $sitio.'/api/login_check';
        $response = $httpClient->request('POST', $uri, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'username' => $username,
                'password' => $password
            ],
        ]);
        //  return new Response($response->getStatusCode());
        $statusCode = $response->getStatusCode();

        if($statusCode  == 200)
        {
            $content = $response->getContent();
            $token = json_decode($content,true);
            // $this->token = $response;
            return $this->json([
                'success'  => true,
                'errors' => null,
                "data" => $token
            ]);
        }
        return $this->json(["success" => false, "errors" => [$statusCode], "data" => null]);
    }



}
