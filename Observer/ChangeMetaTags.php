<?php


namespace Netzexpert\CategoryRobots\Observer;


use Magento\Catalog\Model\Layer\Resolver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Page\Config;

class ChangeMetaTags implements ObserverInterface
{
    /**
     * @var Resolver
     */
    private $layerResolver;

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
     * @param Resolver $resolver
     */
    public function __construct(
        UrlInterface $url,
        Config $config,
        Resolver $resolver
    )
    {
        $this->layerResolver = $resolver;
        $this->pageConfig = $config;
        $this->urlInterface = $url;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /*$layer = $this->layerResolver->get();
        $activeFilters = $layer->getState()->getFilters();*/

        $layoutarray = $observer->getData('layout')->getUpdate()->getHandles();
        if ($layoutarray[1] == 'catalog_category_view') {
            $uri = $this->urlInterface->getCurrentUrl();
            if (/*$activeFilters or*/ stristr($uri, '?')) {
                $this->pageConfig->setRobots('NOINDEX, FOLLOW');
            }
        }
    }
}