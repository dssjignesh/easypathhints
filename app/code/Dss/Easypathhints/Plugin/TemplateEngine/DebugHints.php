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

namespace Dss\Easypathhints\Plugin\TemplateEngine;

use Magento\Developer\Model\TemplateEngine\Decorator\DebugHintsFactory;
use Magento\Framework\View\TemplateEngineFactory;
use Magento\Framework\View\TemplateEngineInterface;
use Dss\Easypathhints\Helper\Data as EasyPathHintsHelper;

class DebugHints
{
    /**
     * @param EasypathhintsHelper $easyPathHintsHelper
     * @param  DebugHintsFactory $debugHintsFactory
     */
    public function __construct(
        private EasyPathHintsHelper $easyPathHintsHelper,
        protected DebugHintsFactory $debugHintsFactory
    ) {
    }

    /**
     * After plugin for creating template engine.
     *
     * @param TemplateEngineFactory $subject
     * @param TemplateEngineInterface $invocationResult
     * @return TemplateEngineInterface
     */
    public function afterCreate(
        TemplateEngineFactory $subject,
        TemplateEngineInterface $invocationResult
    ) {
        if ($this->easyPathHintsHelper->shouldShowTemplatePathHints()) {
            $showBlockHints = 1;
            return $this->debugHintsFactory->create([
                'subject' => $invocationResult,
                'showBlockHints' => $showBlockHints,
            ]);
        }
        return $invocationResult;
    }
}
