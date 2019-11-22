<?php


namespace Netzexpert\CategoryRobots\Observer;


use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Page\Config;

class ChangeMetaTags implements ObserverInterface
{
    /**
     * @var Config
     */
    private $pageConfig;

    /**
     * @var UrlInterface
     */
    private $urlInterface;

    /**
     * ChangeMetaTags constructor.
     * @param UrlInterface $url
     * @param Config $config
     */
    public function __construct(
        UrlInterface $url,
        Config $config
    )
    {
        $this->pageConfig = $config;
        $this->urlInterface = $url;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $layoutarray = $observer->getData('layout')->getUpdate()->getHandles();
        if ($layoutarray[1] == 'catalog_category_view') {
            $uri = $this->urlInterface->getCurrentUrl();
            if (stristr($uri, '?')) {
                $this->pageConfig->setRobots('NOINDEX, FOLLOW');
            }
        }
    }
}