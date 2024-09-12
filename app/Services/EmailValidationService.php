<?php
namespace App\Services;

use GuzzleHttp\Client;

class EmailValidationService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('MAILGUN_API_KEY'); // Add your Mailgun API Key here or in .env
    }

    public function validateEmail($email)
    {
        $response = $this->client->get('https://api.mailgun.net/v4/address/validate', [
            'query' => [
                'address' => $email,
                'api_key' => $this->apiKey
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        return $data['is_valid']; // Returns true or false
    }
}
