<?php
require 'vendor/autoload.php';

use Aws\SecretsManager\SecretsManagerClient;
use Aws\Exception\AwsException;

$secretName = 'testSecret';
$region = 'ap-southeast-2';

$client = new SecretsManagerClient([
    'version' => 'latest',
    'region' => $region,
    /*
    for the actual code we will get this from env varibales 

    $ export AWS_ACCESS_KEY_ID=abc # The access key for your AWS account.
    $ export AWS_SECRET_ACCESS_KEY=xyz # The secret access key for your AWS account.
    */
    'credentials' => [
        'key' => 'ConfigureActualKey',
        'secret' => 'ConfigureActualSecret',
    ],
]);

try {
    $result = $client->getSecretValue([
        'SecretId' => $secretName
    ]);

    if (isset($result['SecretString'])) {
        $secret = $result['SecretString'];
    } else {
        $secret = base64_decode($result['SecretBinary']);
    }
} catch (AwsException $e) {
    $error = $e->getAwsErrorCode();
    if (
        $error == 'DecryptionFailureException'
        || $error == 'InternalServiceErrorException'
        || $error == 'InvalidParameterException'
        || $error == 'InvalidRequestException'
        || $error == 'ResourceNotFoundException'
    ) {
        // Secrets Manager can't decrypt the protected secret text using the provided KMS key.
        // Handle these errors.
    }
    throw $e;
}

echo $secret;
?>