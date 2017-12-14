<?php
$wsdl = "http://tempmeasure.azurewebsites.net/tempservice.svc?wsdl";
//$wsdl = "http://localhost:3056/TempService.svc?wsdl";
$client = new SoapClient($wsdl);

$resultWrapped = $client->UpdateDb();
$testEt = $client->TjekStatus();
//print_r($testEt);
$status = $testEt->TjekStatusResult;

$serviceApi = getApi();

function getApi() {
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, 'api.openweathermap.org/data/2.5/weather?q=copenhagen&units=metric&APPID=434107d9b55b48ee45ebc46030dee01d');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // ved at sætte returntransfer til true, gemmer den parametre i $result i stedet for at outputte direkte
    $result = curl_exec($curl);
    $jsonobj = json_decode($result);
    return $jsonobj->main->temp;
    //return $result;

}

require_once '../vendor/autoload.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader, array(
    //'cache' => '/path/to/compilation_cache',
    'auto_reload' => true
));
$template = $twig->loadTemplate('index.html.twig');
$parametersToTwig = array(
        "state" => $status,
        "serviceApi" => $serviceApi
);
echo $template->render($parametersToTwig);
?>

