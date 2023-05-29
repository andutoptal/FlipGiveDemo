<?php
use FlipGive\ShopCloud\ShopCloud;
use FlipGive\ShopCloud\InvalidPayloadException;
use FlipGive\ShopCloud\InvalidTokenException;

App::uses('AppController', 'Controller');

class IndexController extends AppController
{
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

            $payload = json_decode($this->request->data['payload'], true);

            try
            {
                $token = $shopCloud->identifiedToken($payload);
                $this->set('token', $token);
            }
            catch (InvalidPayloadException $e)
            {
                $this->set('errors', json_encode($shopCloud->getErrors(), JSON_PRETTY_PRINT));
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

            $token = $this->request->data['token'];

            try
            {
                $data = $shopCloud->readToken($token);
                $this->set('data', json_encode($data, JSON_PRETTY_PRINT));
            }
            catch (InvalidTokenException $e)
            {
                $this->set('errors', json_encode($shopCloud->getErrors(), JSON_PRETTY_PRINT));
            }
        }
        else
        {
            $this->redirect('/');
        }
    }
}
