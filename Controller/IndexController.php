<?php
use FlipGive\ShopCloud\ShopCloud;
use FlipGive\ShopCloud\InvalidPayloadException;
use FlipGive\ShopCloud\InvalidTokenException;

App::uses('AppController', 'Controller');

class IndexController extends AppController
{
    public $components = ['RequestHandler'];

    const CLOUD_SHOP_ID = 'A2DE537C';
    const SECRET = 'sk_5ef962a96245420d';

    public function index()
    {
    }

    public function identifiedToken()
    {
        if ($this->request->is('post'))
        {
            $shopCloud = new ShopCloud(self::CLOUD_SHOP_ID, self::SECRET);
            $isJson = $this->request->is('json');

            $payload = $isJson ? $this->request->data['payload'] : json_decode($this->request->data['payload'], true);
            try
            {
                $token = $shopCloud->identifiedToken($payload);
                $this->set('token', $token);

                if ($isJson)
                {
                    $this->set('_serialize', ['token']);
                }
            }
            catch (InvalidPayloadException $e)
            {
                $this->handleErrors($shopCloud->getErrors(), $isJson);
            }
        }
        else
        {
            $this->redirect('/');
        }
    }

    public function readToken()
    {
        if ($this->request->is('post'))
        {
            $shopCloud = new ShopCloud(self::CLOUD_SHOP_ID, self::SECRET);
            $isJson = $this->request->is('json');

            $token = $this->request->data['token'];

            try
            {
                $payload = $shopCloud->readToken($token);

                $this->set('payload', $isJson ? $payload : json_encode($payload, JSON_PRETTY_PRINT));

                if ($isJson)
                {
                    $this->set('_serialize', ['payload']);
                }
            }
            catch (InvalidTokenException $e)
            {
                $this->handleErrors($shopCloud->getErrors(), $isJson);
            }
        }
        else
        {
            $this->redirect('/');
        }
    }

    private function handleErrors($errors, $isJson)
    {
        $this->response->statusCode(400);
        $this->set('errors', $isJson ? $errors : json_encode($errors, JSON_PRETTY_PRINT));

        if ($isJson)
        {
            $this->set('_serialize', ['errors']);
        }
    }
}
