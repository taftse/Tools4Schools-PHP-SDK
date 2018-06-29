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


    public function __construct($accessToken,$enableBeta = false)
    {
        $this->enableBetaMode = $enableBeta;
        Model::setConnection(new GuzzleConnection($this->getBaseApiUrl(),static::DEFAULT_API_VERSION,['access_token'=>$accessToken]));
        //Model::setApiVersion();
    }

    /**
     * Toggle beta mode.
     *
     * @param boolean $betaMode
     */
    public function enableBetaMode($betaMode = true)
    {
        $this->enableBetaMode = $betaMode;
    }

    /**
     * Returns the base api URL.
     *
     * @return string
     */
    public function getBaseApiUrl()
    {
        return $this->enableBetaMode ? static::BASE_API_URL_BETA : static::BASE_API_URL;
    }
}