<?php

declare(strict_types=1);

namespace Zepgram\CodeMaker;

class Constraint
{
    const AREA_BASE = 'base';

    const AREA_FRONTEND = 'frontend';

    const AREA_ADMINHTML = 'adminhtml';

    const AREA_CRONTAB = 'crontab';

    const AREA_WEBAPI_REST = 'webapi_rest';

    const AREA_WEBAPI_SOAP = 'webapi_soap';

    const AREA_GRAPHQL = 'graphql';

    const MAGENTO_AREA = [
        self::AREA_BASE,
        self::AREA_FRONTEND,
        self::AREA_ADMINHTML,
        self::AREA_CRONTAB,
        self::AREA_WEBAPI_REST,
        self::AREA_WEBAPI_SOAP,
        self::AREA_GRAPHQL
    ];

    const MAGENTO_VIEW_AREA = [
        self::AREA_FRONTEND,
        self::AREA_ADMINHTML
    ];

    const ETC_DIRECTORY = 'etc';

    const FRONTEND_BLOCK_DIRECTORY = 'Block';

    const BACKEND_BLOCK_DIRECTORY = 'Block/Adminhtml';

    const FRONTEND_CONTROLLER_DIRECTORY = 'Controller';

    const BACKEND_CONTROLLER_DIRECTORY = 'Controller/Adminhtml';

    const FRONTEND_CONTROLLER_CLASS = [
        'Magento\Framework\App\Action\Action',
        'Magento\Framework\App\Action\Context'
    ];

    const BACKEND_CONTROLLER_CLASS = [
        'Magento\Backend\App\Action',
        'Magento\Backend\App\Action\Context'
    ];

    const FRONTEND_BLOCK_CLASS = [
        'Magento\Backend\Block\Template',
        'Magento\Backend\Block\Template\Context'
    ];

    const BACKEND_ROUTER_ID = 'admin';

    const FRONTEND_ROUTER_ID = 'standard';
}
