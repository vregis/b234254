<?php

$vendorDir = dirname(__DIR__);

return array (
  'marciocamello/yii2-paypal' => 
  array (
    'name' => 'marciocamello/yii2-paypal',
    'version' => '0.1.1.0',
    'alias' => 
    array (
      '@ak' => $vendorDir . '/marciocamello/yii2-paypal',
    ),
  ),
  'c006/yii2-paypal-ipn' => 
  array (
    'name' => 'c006/yii2-paypal-ipn',
    'version' => '9999999-dev',
    'alias' => 
    array (
      '@c006/paypal_ipn' => $vendorDir . '/c006/yii2-paypal-ipn',
    ),
  ),
  'yiisoft/yii2-swiftmailer' => 
  array (
    'name' => 'yiisoft/yii2-swiftmailer',
    'version' => '2.0.4.0',
    'alias' => 
    array (
      '@yii/swiftmailer' => $vendorDir . '/yiisoft/yii2-swiftmailer',
    ),
  ),
  'nodge/yii2-eauth' => 
  array (
    'name' => 'nodge/yii2-eauth',
    'version' => '2.4.1.0',
    'alias' => 
    array (
      '@nodge/eauth' => $vendorDir . '/nodge/yii2-eauth/src',
    ),
    'bootstrap' => 'nodge\\eauth\\Bootstrap',
  ),
  'yiisoft/yii2-bootstrap' => 
  array (
    'name' => 'yiisoft/yii2-bootstrap',
    'version' => '2.0.5.0',
    'alias' => 
    array (
      '@yii/bootstrap' => $vendorDir . '/yiisoft/yii2-bootstrap',
    ),
  ),
  'kartik-v/yii2-krajee-base' => 
  array (
    'name' => 'kartik-v/yii2-krajee-base',
    'version' => '1.8.2.0',
    'alias' => 
    array (
      '@kartik/base' => $vendorDir . '/kartik-v/yii2-krajee-base',
    ),
  ),
  'kartik-v/yii2-social' => 
  array (
    'name' => 'kartik-v/yii2-social',
    'version' => '9999999-dev',
    'alias' => 
    array (
      '@kartik/social' => $vendorDir . '/kartik-v/yii2-social',
    ),
  ),
);
