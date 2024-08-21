<?php

declare(strict_types= 1);

/**
* Digit Software Solutions.
*
* NOTICE OF LICENSE
*
* This source file is subject to the EULA
* that is bundled with this package in the file LICENSE.txt.
*
* @category  Dss
* @package   Dss_Easypathhints
* @author    Extension Team
* @copyright Copyright (c) 2024 Digit Software Solutions. ( https://digitsoftsol.com )
*/

namespace Dss\Easypathhints\Model;

use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\Stdlib\Cookie\PublicCookieMetadata;
use Magento\Framework\Stdlib\CookieManagerInterface;

class Cookie
{
    /**
     * @param CookieManagerInterface $cookieManager
     * @param CookieMetadataFactory $cookieMetadataFactory
     * @param SessionManagerInterface $sessionManager
     */
    public function __construct(
        private CookieManagerInterface $cookieManager,
        private CookieMetadataFactory $cookieMetadataFactory,
        private SessionManagerInterface $sessionManager
    ) {
    }

    /**
     * Get form key cookie
     *
     * @return string|null
     */
    public function get(): string|null
    {
        return $this->cookieManager->getCookie(static::COOKIE_NAME);
    }

    /**
     * Set a cookie with a given value and duration
     *
     * @param string $value
     * @param int $duration
     * @return void
     */
    public function set($value, $duration = 86400): void
    {
        $publicCookieMetadata = $this->cookieMetadataFactory
            ->createPublicCookieMetadata()
            ->setDuration($duration)
            ->setPath($this->sessionManager->getCookiePath())
            ->setDomain($this->sessionManager->getCookieDomain());

        $this->cookieManager->setPublicCookie(
            static::COOKIE_NAME,
            $value,
            $publicCookieMetadata
        );
    }

    /**
     * Delete the cookie
     *
     * @return void
     */
    public function delete(): void
    {
        $publicCookieMetadata = $this->cookieMetadataFactory
            ->createPublicCookieMetadata()
            ->setPath($this->sessionManager->getCookiePath())
            ->setDomain($this->sessionManager->getCookieDomain());
        $this->cookieManager->deleteCookie(
            static::COOKIE_NAME,
            $publicCookieMetadata
        );
    }
}
