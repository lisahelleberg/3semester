<?php
/**
 * Created by PhpStorm.
 * User: Lisa
 * Date: 14-12-2017
 * Time: 10:56
 */
$wsdl = "http://tempmeasure.azurewebsites.net/tempservice.svc?wsdl";
$client = new SoapClient($wsdl);


$rwrapped = $client->GetAllTemp();
$result = $rwrapped->GetAllTempResult->Temp;
/*Station*/
//$rwrappedStation = $client->GetAllDataStation();
//$resultStation = $rwrappedStation->GetAllDataStationResult->Temperaturmaaling;

require_once '../vendor/autoload.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader, array(
    // 'cache' => '/path/to/compilation_cache',
    'auto_reload' => true
));


$template = $twig->loadTemplate('historik.html.twig');
$parametersToTwig = array("tempra" => $result,);
echo $template->render($parametersToTwig);
?>

