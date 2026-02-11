<?php

namespace Mauro\CartReminder\Block;

use Magento\Framework\View\Element\Template;
use Magento\Checkout\Model\Cart;
use Magento\Catalog\Helper\Image;

class CartReminder extends Template
{
    protected Cart $cart;
    protected Image $imageHelper;

    public function __construct(
        Template\Context $context,
        Cart $cart,
        Image $imageHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->cart = $cart;
        $this->imageHelper = $imageHelper;
    }

    public function getFilteredItems(): array
    {
        $items = $this->cart->getQuote()->getAllVisibleItems();

        $filtered = [];
        $count = 0;

        foreach ($items as $item) {
            $product = $item->getProduct();

            if (in_array(14, $product->getCategoryIds())) {
                $filtered[] = [
                    'name' => $product->getName(),
                    'url' => $product->getProductUrl(),
                    'image' => $this->imageHelper
                        ->init($product, 'product_small_image')
                        ->getUrl()
                ];

                $count++;

                if ($count >= 3) {
                    break;
                }
            }
        }

        return $filtered;
    }

    public function shouldRender(): bool
    {
        return count($this->getFilteredItems()) > 0;
    }

    public function getItemsJson(): string
    {
        return json_encode($this->getFilteredItems());
    }
}