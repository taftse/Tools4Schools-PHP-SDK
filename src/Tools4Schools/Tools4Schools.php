<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 29/06/2018
 * Time: 18:48
 */

namespace Tools4Schools\SDK;


use Tools4Schools\SDK\Graph\Model;
use Tools4Schools\SDK\Oauth2\AuthTokenMiddleware;
use Tools4Schools\SDK\Oauth2\Client as Oauth2Client;

class Tools4Schools
{
    /**
     * Version number of the Tools4Schools PHP SDK.
     *
     * @const string
     */
    const VERSION = '0.0.2';

    /**
     * Default API version for requests.
     *
     * @const string
     */
    const DEFAULT_API_VERSION = 'v1';

    /**
     * The url to the production server
     *
     * @const string
     */
    const BASE_API_URL = 'https://api.tools4schools.ie';

    /**
     * The url to the staging server
     *
     * @const string
     */
    const BASE_API_URL_BETA = 'https://staging.api.tools4schools.ie';

    /**
     * Toggle to use staging api url.
     *
     * @var bool
     */
    protected $enableBetaMode = false;

    /**
     * The main guzzle connection
     *
     * @var \GuzzleConnection the graph client
     */
    protected $connection;

    /**
     * The oauth2 client to handle authentication requests
     *
     * @var Oauth2\Client the Oauth2 Client
     */
    protected $oauth2Client;

    /**
     * List of configure values
     *
     * @var array
     */
    protected $config = [];

    /**
     * A tenants uuid
     *
     * @var string
     */
    protected $tenant;

    public function __construct(array $config = [])
    {

        $this->config = array_merge([
            //'app_id' => getenv(static::APP_ID_ENV_NAME),
            //'app_secret' => getenv(static::APP_SECRET_ENV_NAME),
            'default_api_version' => static::DEFAULT_API_VERSION,
            'enable_beta_mode' => false,
        ], $config);

        $this->config['base_uri'] = $this->getBaseApiUrl();

        $this->connection = new GuzzleConnection($this->config);

        $this->oauth2Client = new Oauth2Client($this->config);

        $this->connection->addMiddleware(new AuthTokenMiddleware($this->oauth2Client));


        Model::setConnection($this->connection);


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