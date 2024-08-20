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

namespace Dss\Easypathhints\Block\System\Config\Form\Field;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Config\Block\System\Config\Form\Field;
use Dss\Easypathhints\Helper\Data;

class Version extends Field
{
    /**
     * Constructor.
     *
     * @param Context $context
     * @param Data $_helper
     */
    public function __construct(
        Context $context,
        protected Data $_helper
    ) {
        parent::__construct($context);
    }

    /**
     * Retrieve HTML for the form element.
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $extensionVersion = $this->_helper->getExtensionVersion();
        $element->setValue($extensionVersion);

        return $element->getValue();
    }
}
