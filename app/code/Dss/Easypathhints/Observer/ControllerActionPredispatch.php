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

namespace Dss\Easypathhints\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Config\MutableScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Dss\Easypathhints\Helper\Data as EasypathhintsHelper;
use Dss\Easypathhints\Helper\Config as EasypathhintsConfigHelper;

/**
 * Observer for the controller action predispatch event.
 */
class ControllerActionPredispatch implements ObserverInterface
{
    /**
     * @param EasypathhintsHelper $_helper
     * @param MutableScopeConfigInterface $_mutableConfig
     */
    public function __construct(
        protected EasypathhintsHelper $_helper,
        protected MutableScopeConfigInterface $_mutableConfig
    ) {
    }

    /**
     * Execute the observer logic
     *
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        if (version_compare($this->_helper->getMagentoVersion(), '2.1.3', '>=')) {
            return $this;
        }

        if ($this->_helper->shouldShowTemplatePathHints()) {

            $this->_mutableConfig->setValue(
                EasypathhintsConfigHelper::XML_PATH_DEBUG_TEMPLATE_FRONT,
                1,
                ScopeInterface::SCOPE_STORE
            );

            $this->_mutableConfig->setValue(
                EasypathhintsConfigHelper::XML_PATH_DEBUG_TEMPLATE_ADMIN,
                1,
                ScopeInterface::SCOPE_STORE
            );

            $this->_mutableConfig->setValue(
                EasypathhintsConfigHelper::XML_PATH_DEBUG_BLOCKS,
                1,
                ScopeInterface::SCOPE_STORE
            );
        }
        return $this;
    }
}
