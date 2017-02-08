<?php

namespace TrashPanda\OpCacheMonitor\Controller\Adminhtml\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Exception\NotFoundException;

/**
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class View extends Action
{
    /**
     * Authorization level
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'TrashPanda_OpCacheMonitor::opcache';

    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute() : Page
    {
        $page = $this->resultPageFactory->create();

        return $page->getConfig()->getTitle()->prepend(__('OpCache Overview'));
    }
}
