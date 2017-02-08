<?php

namespace TrashPanda\OpCacheMonitor\Controller\Adminhtml\Flush;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Exception\NotFoundException;

/**
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 */
class Index extends Action
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

    public function __construct(Context $context, PageFactory $resultPageFactory, Registry $coreRegistry)
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute() : ResultInterface
    {
        opcache_reset();

        $this->messageManager->addSuccessMessage('OpCache successfully flushed');

        return $this->resultRedirectFactory->create()->setPath('*/config/view');
    }
}
