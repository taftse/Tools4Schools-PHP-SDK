<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 24/06/2018
 * Time: 19:12
 */

namespace Tools4Schools\SDK;


use Tools4Schools\SDK\Graph\GuzzleConnection;
use Tools4Schools\SDK\Graph\Model;
use Tools4Schools\SDK\Oauth2\Client;

class Tools4Schools
{
    /**
     * @const string Version number of the Tools4Schools PHP SDK.
     */
    const VERSION = '0.0.1';

    /**
     * @const string Default API version for requests.
     */
    const DEFAULT_API_VERSION = 'v1';

    /**
     * @const string The name of the environment variable that contains the app ID.
     */
    const APP_ID_ENV_NAME = 'TOOLS4SCHOOLS_APP_ID';
    /**
     * @const string The name of the environment variable that contains the app secret.
     */
    const APP_SECRET_ENV_NAME = 'TOOLS4SCHOOLS_APP_SECRET';


    /**
     * @const string Production API URL.
     */
    const BASE_API_URL = 'https://api.tools4schools.ie';

    /**
     * @const string Beta API URL.
     */
    const BASE_API_URL_BETA = 'https://staging.api.tools4schools.ie';

    /**
     * @const int The timeout in seconds for a normal request.
     */
    const DEFAULT_REQUEST_TIMEOUT = 60;

    /**
     * @var bool Toggle to use beta api url.
     */
    protected $enableBetaMode = false;


    /**
     * @var \GuzzleHttp\Client the graph client
     */
    protected $client;

    /**
     * @var Oauth2\Client the Oauth2 Client
     */
    protected $oauth2Client;

    protected $config;

    /**
     * Tools4Schools constructor.
     * @param $accessToken
     * @param bool $enableBeta
     */

    public function __construct(array $config = [])
    {
        $this->config = array_merge([
            'app_id' =>getenv(static::APP_ID_ENV_NAME),
            'app_secret' => getenv(static::APP_SECRET_ENV_NAME),
            'default_api_version' => static::DEFAULT_API_VERSION,
            'enable_beta_mode' =>false,
        ],$config);

        if(!$this->config['app_id'])
        {
            // throw new exception
        }

        if(!$this->config['app_secret'])
        {
            // throw new exception
        }


        //$this->enableBetaMode = $enableBeta;

        $this->client = new GuzzleConnection($this->getBaseApiUrl(),static::DEFAULT_API_VERSION,$this->config);
        Model::setConnection($this->client);
        //Model::setApiVersion();
    }

    /**
     * Toggle beta mode.
     *
     * @param boolean $betaMode
     */
    public function enableBetaMode($betaMode = true)
    {
        $this->config['enable_beta_mode'] = $betaMode;
    }

    /**
     * Returns the base api URL.
     *
     * @return string
     */
    public function getBaseApiUrl()
    {
        return $this->config['enable_beta_mode'] ? static::BASE_API_URL_BETA : static::BASE_API_URL;
    }
}