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

namespace Dss\Easypathhints\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    public const XML_PATH_ENABLED = 'dss_easypathhints/general/enabled';
    public const XML_PATH_DEBUG = 'dss_easypathhints/general/debug';
    public const XML_PATH_ACCESS_CODE = 'dss_easypathhints/general/access_code';
    public const XML_PATH_SAVE_COOKIE = 'dss_easypathhints/general/save_in_cookie';
    public const XML_PATH_PROFILER = 'dss_easypathhints/general/show_profiler';

    public const XML_PATH_DEBUG_TEMPLATE_FRONT = 'dev/debug/template_hints_storefront';
    public const XML_PATH_DEBUG_TEMPLATE_ADMIN = 'dev/debug/template_hints_admin';
    public const XML_PATH_DEBUG_BLOCKS = 'dev/debug/template_hints_blocks';

    /**
     * Constructor
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        protected ScopeConfigInterface $scopeConfig
    ) {
    }

    /**
     * Retrieve configuration value by XML path
     *
     * @param string $xmlPath
     * @param int|null $storeId
     * @return mixed
     */
    public function getConfigValue($xmlPath, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $xmlPath,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Check if the module is enabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isEnabled($storeId = null): bool
    {
        return (bool) $this->getConfigValue(self::XML_PATH_ENABLED, $storeId);
    }

    /**
     * Alias for isEnabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function isActive($storeId = null): bool
    {
        return $this->isEnabled($storeId);
    }

    /**
     * Get the debug status
     *
     * @param int|null $storeId
     * @return bool
     */
    public function getDebugStatus($storeId = null): bool
    {
        return (bool) $this->getConfigValue(self::XML_PATH_DEBUG, $storeId);
    }

    /**
     * Retrieve the access code
     *
     * @param int|null $storeId
     * @return string|null
     */
    public function getAccessCode($storeId = null): string|null
    {
        return $this->getConfigValue(self::XML_PATH_ACCESS_CODE, $storeId);
    }

    /**
     * Check if save in cookie is enabled
     *
     * @param int|null $storeId
     * @return bool
     */
    public function getSaveInCookie($storeId = null): bool
    {
        return (bool) $this->getConfigValue(self::XML_PATH_SAVE_COOKIE, $storeId);
    }

    /**
     * Get the show profiler status
     *
     * @param int|null $storeId
     * @return bool
     */
    public function getShowProfiler($storeId = null): bool
    {
        return (bool) $this->getConfigValue(self::XML_PATH_PROFILER, $storeId);
    }
}
