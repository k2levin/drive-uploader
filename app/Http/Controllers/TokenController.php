<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Lib\GoogleApiManager\GoogleApiManager;

class TokenController extends Controller
{
    /**
     * GoogleApiManager
     * @var GoogleApiManager
     */
    protected $GoogleApiManager;

    /**
     * constructor
     * @param GoogleApiManager $GoogleApiManager
     */
    public function __construct(GoogleApiManager $GoogleApiManager)
    {
        $this->GoogleApiManager = $GoogleApiManager;
    }

    /**
     * generate access token & refresh token page
     * @return mixed
     */
    public function generateToken()
    {
        $client = $this->GoogleApiManager->getClient();
        $client->addScope("https://www.googleapis.com/auth/drive");
        $client->setAccessType('offline');
        $client->setApprovalPrompt("force");
        $auth_url = $client->createAuthUrl();

        return view('token.generate_token', compact('auth_url'));
    }

    /**
     * generate access token & refresh token
     * @return json access token
     */
    public function getToken()
    {
        $client = $this->GoogleApiManager->getClient();
        $client->authenticate($_GET['code']);
        $access_token = $client->getAccessToken();

        return $access_token;
    }
}
