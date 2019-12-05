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
        if (is_array($layoutarray) && in_array("catalog_category_view", $layoutarray)) {
            $uri = $this->urlInterface->getCurrentUrl();
            if (stristr($uri, '?')) {
                $this->pageConfig->setRobots('NOINDEX, FOLLOW');
            }
        }
    }
}