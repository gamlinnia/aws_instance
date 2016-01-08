<?php

require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$app -> contentType('application/json');
$input = json_decode($app->request->getBody(), true);
$instances = json_decode(file_get_contents('config/instances.json'), true);
$groupInstances = json_decode(file_get_contents('config/groupInstances.json'), true);

require_once('AWSSDKforPHP/aws.phar');

/*CORS*/
require_once 'CORS.php';
/*常用 function*/
require_once ('tools.php');

$app->get('/api/getGroupInstanceList', function () {
    global $groupInstances;
    echo json_encode($groupInstances);
});

$app->get('/api/getInstanceList', function () {
    global $instances;
    $response = array();
    foreach ($instances as $eachInstName) {
        foreach ($eachInstName['instance_id'] as $eachInstanceId) {
            $instanceInfo = array(
                'instName' => $eachInstName['instName'],
                'instance_id' => $eachInstanceId,
                'key' => $eachInstName['key'],
                'secret' => $eachInstName['secret']
            );
//            $status = checkInstanceStatus($instanceInfo);
//            $instanceInfo['status'] = $status;
            $response[] = $instanceInfo;
       }
    }
    echo json_encode($response);
});

$app->post('/api/startInstance', function () {
    global $input;
    $instanceInfo = $input;
    $keySecret = array(
        'key' => $instanceInfo['key'],
        'secret' => $instanceInfo['secret'],
        'region' => $instanceInfo['instName']
    );
    $client = Aws\Ec2\Ec2Client::factory($keySecret);
    $result = $client->startInstances(array('InstanceIds' => array($instanceInfo['instance_id'])));
    echo json_encode($result->toArray());
});

$app->post('/api/stopInstance', function () {
    global $input;
    $instanceInfo = $input;
    $keySecret = array(
        'key' => $instanceInfo['key'],
        'secret' => $instanceInfo['secret'],
        'region' => $instanceInfo['instName']
    );
    $client = Aws\Ec2\Ec2Client::factory($keySecret);
    $result = $client->stopInstances(array('InstanceIds' => array($instanceInfo['instance_id'])));
    echo json_encode($result->toArray());
});

$app->run();
