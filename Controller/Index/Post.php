<?php
/**
 * Controller for handling post requests from converter
 *
 * @package converter
 * @author Tomasz Biedrzycki <tomasz.biedrzycki@interia.eu>
 */
namespace TBat\Converter\Controller\Index;

use \Magento\Framework\DataObject;
use Magento\TestFramework\Event\Magento;
use TBat\Converter\Controller as Controller;

class Post extends Controller\Index
{

    /**
     * webservice api url
     */
    const XML_PATH_WEBSERVICE_URL = 'converter/webservice/url';



    /**
     * Post handling / currency converting
     *
     * @return void
     * @throws \Exception
     */
    public function execute()
    {
        //first of all validate request
        $post = $this->getRequest()->getPostValue();
        if (!$this->getRequest()->isXmlHttpRequest() || !$post) {
            $this->_redirect('*/*/');
            return;
        }

        $this->getResponse()->setHeader('Content-type', 'application/json');

        $response = array('success'=>false);

        try {
            $postObject = new DataObject();
            $postObject->setData($post);

            $error = false;

            if (!\Zend_Validate::is(trim($post['base_value']), 'NotEmpty')) {
                $error = true;
            }
            if (!\Zend_Validate::is(trim($post['base']), 'NotEmpty')) {
                $error = true;
            }
            if (!\Zend_Validate::is(trim($post['exchange']), 'NotEmpty')) {
                $error = true;
            }
            if ($error) {
                throw new \Exception();
            }


            $converterService = $this->_objectManager->create(
                '\TBat\Converter\Model\Converter\Service\Client',
                array('url'=>$this->scopeConfig->getValue(self::XML_PATH_WEBSERVICE_URL),
                ));

            $result = $converterService->calculate($post['base'],$post['exchange'], $post['base_value']); ;

            $response['success'] = true;
            $response['result'] = $result;

            $this->messageManager->addSuccess(
                __('Thanks for using our converter.')
            );

        } catch (\Exception $e) {

            $response['message'] = $e->getMessage();
            $this->messageManager->addError(
                __('We can\'t process your request right now. Sorry, that\'s all we know.')
            );
        }

        $this->getResponse()->setBody($this->jsonEncoder->encode($response));

    }
}
