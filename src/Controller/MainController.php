<?php

    namespace App\Controller;

    use App\Service\KeyManagement;
    use Exception;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    class MainController extends AbstractController
    {
        #[Route('/getPublicKey', name: 'getPublicKey')]
        public function getPublicKey(KeyManagement $keyManagement): Response
        {
            $res = new Response($keyManagement->loadPublicKey());
            $res->headers->set('Content-Type', 'text/plain');
            return $res;
        }

        /**
         * @throws Exception
         */
        #[Route('/verify/{key?}', name: 'verifyKey')]
        public function verifyKey(KeyManagement $keyManagement, $key): Response
        {
            if (!$key) {
                throw new Exception("The key is not provided!");
            }

            return $this->json($keyManagement->decode($key));
        }

        /**
         * @throws Exception
         */
        #[Route('/issue/{payload?}', name: 'issueKey')]
        public function issueKey(KeyManagement $keyManagement, $payload): Response
        {
            if (!$payload) {
                throw new Exception("The json payload is not provided!");
            }

            return $this->json([
                'key' => $keyManagement->encode(json_decode($payload))
            ]);
        }
    }
