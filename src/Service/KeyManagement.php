<?php


    namespace App\Service;

    use Firebase\JWT\JWT;

    class KeyManagement
    {
        private const CONFIG_FILE = __DIR__ . '/../openssl.cnf';
        private const KEY_PATH = __DIR__ . "/../certs/";
        private const PRIVATE_KEY = self::KEY_PATH . "privateKey.pem";
        private const PUBLIC_KEY = self::KEY_PATH . "publicKey.pem";

        public function loadPublicKey()
        {
            if (!file_exists(self::PUBLIC_KEY)) {
                $this->generateKeys();
            }

            return file_get_contents(self::PUBLIC_KEY);
        }

        private function loadPrivateKey()
        {
            if (!file_exists(self::PRIVATE_KEY)) {
                $this->generateKeys();
            }

            return file_get_contents(self::PRIVATE_KEY);
        }

        public function encode($payload): string
        {
            return JWT::encode($payload, $this->loadPrivateKey(), 'RS256');
        }

        public function decode($key): object
        {
            return JWT::decode($key, $this->loadPublicKey(), array('RS256'));
        }

        public function generateKeys()
        {
            $privateKeyResource = openssl_pkey_new([
                'config'           => self::CONFIG_FILE,
                'private_key_bits' => 3072,
                'private_key_type' => OPENSSL_KEYTYPE_RSA,
                'default_md'       => 'sha256'
            ]);

            openssl_pkey_export_to_file($privateKeyResource, __DIR__ . '/../certs/privateKey.pem', null, ['config' => self::CONFIG_FILE]);
            $privateKeyDetailsArray = openssl_pkey_get_details($privateKeyResource);
            file_put_contents(__DIR__ . '/../certs/publicKey.pem', $privateKeyDetailsArray['key']);
        }
    }