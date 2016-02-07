<?php
/**
 * Block for convert-form
 *
 * @package converter
 * @author Tomasz Biedrzycki <tomasz.biedrzycki@interia.eu>
 */
namespace TBat\Converter\Block;

use Magento\Framework\View\Element\Template;

/**
 * Main contact form block
 */
class ConverterForm extends Template
{

    /**
     * @var string
     */
    const DEFAULT_BASE_SYMBOL = 'RUB';

    /**
     * @var string
     */
    const DEFAULT_EXCHANGE_SYMBOL = 'PLN';

    /**
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
        $this->_isScopePrivate = true;
    }

    /**
     * Returns action url for contact form
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('converter/index/post', ['_secure' => true]);
    }

    public function getDefaultBaseSymbol()
    {
        return self::DEFAULT_BASE_SYMBOL;
    }

    public function getDefaultExchangeSymbol()
    {
        return self::DEFAULT_EXCHANGE_SYMBOL;
    }
}
