<?php

namespace OCA\SocialLogin\AppInfo;

use OCP\AppFramework\App;
use OCP\IURLGenerator;
use OCP\IConfig;


class Application extends App
{
    private $appName = 'sociallogin';

    public function __construct()
    {
        parent::__construct($this->appName);
    }

    public function register()
    {
        $config = $this->query(IConfig::class);
        $urlGenerator = $this->query(IURLGenerator::class);
        $providers = json_decode($config->getAppValue($this->appName, 'oauth_providers'), true);
        foreach ($providers as $title=>$provider) {
            if ($provider['appid']) {
                \OC_App::registerLogIn([
                	'name' => ucfirst($title),
                	'href' => $urlGenerator->linkToRoute($this->appName.'.oAuth.login', ['provider'=>$title]),
                ]);
            }
        }
    }

    private function query($className)
    {
        return $this->getContainer()->query($className);
    }
}