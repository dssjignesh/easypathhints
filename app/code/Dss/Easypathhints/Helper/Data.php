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

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Module\ModuleListInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Dss\Easypathhints\Logger\Logger;
use Dss\Easypathhints\Helper\Config;
use Dss\Easypathhints\Model\TemplateHintCookie;
use Magento\Framework\App\ProductMetadataInterface;

class Data extends AbstractHelper
{
    /**
     * Constructor
     *
     * @param Context $context
     * @param Logger $customLogger
     * @param Config $configHelper
     * @param TemplateHintCookie $templateHintCookie
     * @param ModuleListInterface $moduleList
     * @param ProductMetadataInterface $mageMetaData
     */
    public function __construct(
        Context $context,
        protected Logger $customLogger,
        protected Config $configHelper,
        protected TemplateHintCookie $templateHintCookie,
        protected ModuleListInterface $moduleList,
        protected ProductMetadataInterface $mageMetaData
    ) {
        parent::__construct($context);
    }

    /**
     * Check if template path hints should be shown.
     *
     * @return bool
     */
    public function shouldShowTemplatePathHints(): bool
    {
        if (!$this->configHelper->isActive()) {
            return false;
        }
        $tp                 = $this->_getRequest()->getParam('tp');
        $accessCode         = $this->_getRequest()->getParam('code');
        $dbAccessCode       = $this->configHelper->getAccessCode();
        $dbCookieStatus     = $this->configHelper->getSaveInCookie();
        $cookieStatus       = $this->_getRequest()->getParam('cookie', -1);

        $checkAccessCode = true;
        if (! empty($dbAccessCode)) {
            $checkAccessCode = ($dbAccessCode == $accessCode)
                ? true
                : false;
        }

        // Set or delete cookie value
        if ($dbCookieStatus) {
            if (1 == $cookieStatus) {
                $this->templateHintCookie->set(1);
            } elseif (0 == $cookieStatus) {
                $this->templateHintCookie->delete();
            }
        }

        if (($tp && $checkAccessCode)
            || $this->templateHintCookie->get()
        ) {
            return true;
        }

        return false;
    }

    /**
     * Get the extension version.
     *
     * @return string
     */
    public function getExtensionVersion(): string
    {
        $moduleCode = 'Dss_Easypathhints';
        $moduleInfo = $this->moduleList->getOne($moduleCode);
        return $moduleInfo['setup_version'];
    }

    /**
     * Get the Magento version.
     *
     * @return string
     */
    public function getMagentoVersion(): string
    {
        return $this->mageMetaData->getVersion();
    }

    /**
     * Logging Utility.
     *
     * @param string $message
     * @param bool $useSeparator
     * @return void
     */
    public function log($message, $useSeparator = false): void
    {
        if ($this->configHelper->getDebugStatus()) {
            if ($useSeparator) {
                $this->customLogger->customLog(str_repeat('=', 100));
            }

            $this->customLogger->customLog($message);
        }
    }
}
