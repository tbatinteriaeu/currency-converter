1. Edit your composer.json (root) in your magento install dir

    "require": {
        ...
        "tbat/converter": "dev-master"
    },
	
    "repositories": [
	...
        {
            "type": "vcs",
            "url": "https://github.com/tbatinteriaeu/currency-converter.git"
        }
    ]

2. run: <your Magento install dir>composer update

3. run: <your Magento install dir>/bin/magento module:enable TBat_Converter

4. run: <your Magento install dir>/bin/magento setup:upgrade

5. run: <your Magento install dir>/bin/magento setup:static-content:deploy

Extension is now enabled and ready to use. 

To test it run http://yourmagentoinstance/converter in browser
