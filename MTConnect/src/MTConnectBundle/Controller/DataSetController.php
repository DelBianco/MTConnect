<?php

namespace MTConnectBundle\Controller;


use Doctrine\Common\Util\Debug;
use DOMDocument;
use DOMXPath;
use MTConnectBundle\Entity\DataSet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class DataSetController extends Controller
{

    public  $http = 'http://localhost:5000/current';

    public function indexAction($coleta_id)
    {
        $em = $this->getDoctrine()->getManager();
        $coleta = $em->getRepository('MTConnectBundle:Coleta')->find($coleta_id);
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($this->http);
        $root = $xmlDoc->documentElement;
        $header = $root->getElementsByTagName('Header');

        $dataItemsOrderByMachineByTypes = $em->getRepository('MTConnectBundle:DataItem')->findTypesByMachine();

        return $this->render('MTConnectBundle:DataSet:index.html.twig',array(
                'result'     => $dataItemsOrderByMachineByTypes,
                'coleta'        => $coleta,
                'creationTime'  => $header->item(0)->getAttribute('creationTime'),
                'sender'        => $header->item(0)->getAttribute('sender'),
                'instanceId'    => $header->item(0)->getAttribute('instanceId'),
                'bufferSize'    => $header->item(0)->getAttribute('bufferSize'),
                'version'       => $header->item(0)->getAttribute('version'),
                'firstSequence' => $header->item(0)->getAttribute('firstSequence'),
                'nextSequence'  => $header->item(0)->getAttribute('nextSequence'),
                'lastSequence'  => $header->item(0)->getAttribute('lastSequence')
            ));
    }

    public function parseXMLAction($coleta_id, Request $request){


        $xmlDoc = new DOMDocument();
        $xmlDoc->load('http://localhost:5000/current');
        $root = $xmlDoc->documentElement;
        $header = $root->getElementsByTagName('Header');
        $firstSequence = $header->item(0)->getAttribute('firstSequence');
        $nextSequence = $header->item(0)->getAttribute('nextSequence');
        $lastSequence = $header->item(0)->getAttribute('lastSequence');
        $em = $this->getDoctrine()->getManager();
        $coleta = $em->getRepository('MTConnectBundle:Coleta')->find($coleta_id);
        $Selected = array();
        parse_str($request->get('selected'), $Selected);
        foreach($Selected as $machine => $types){
            $xmlDoc->load('http://localhost:5000/'.$machine.'/current/');
            $xpath = new DomXpath($xmlDoc);
            foreach ($xpath->query('//*[@dataItemId]') as $rowNode) {
                if( array_search( strtoupper($rowNode->nodeName) , $types ) !== false ){
                    $dataSet = new DataSet();
                    $dataSet->setColeta($coleta);
                    /*
                     * é deixado para pós processamento o carregamento da entidade DataItem, pois dentro do ajax é
                     * necessário agilidade de insersão e não busca
                     */
                    $dataSet->setDataItemName($rowNode->getAttribute('dataItemId'));
                    $dataSet->setSequence($rowNode->getAttribute('sequence'));
                    $dateTimeFormated = date('Y-m-d\TH:i:sO',strtotime($rowNode->getAttribute('timestamp')));
                    $dataSet->setTimestamp(new \DateTime($dateTimeFormated));
                    $dataSet->setValue($rowNode->nodeValue);
                    $em->persist($dataSet);
                }
            $em->flush();
            }
        }

        return new Response( json_encode( array('firstSequence' => $firstSequence, 'lastSequence' => $lastSequence , 'nextSequence' => $nextSequence, 'creationTime'  => $header->item(0)->getAttribute('creationTime') ) ) );
    }

    public function previewTableAction($coleta_id){

        $em = $this->getDoctrine()->getManager();

        return new Response( json_encode( $em->getRepository('MTConnectBundle:DataSet')->findPreview($coleta_id,100)) );
    }

    public function analizeAction($coleta_id){
        $em = $this->getDoctrine()->getManager();
        $coleta = $em->getRepository('MTConnectBundle:Coleta')->find($coleta_id);

        //Alimenta o DataSet Com os respectivos DataItems
        $dataSet = $em->getRepository('MTConnectBundle:DataSet')->findByColeta($coleta_id);
        /**
         * @var $data DataSet
         */
        foreach($dataSet as $data){
            $dataItem = $em->getRepository('MTConnectBundle:DataItem')->findOneByName($data->getDataItemName());
            $data->setDataItem($dataItem);
        }

        $dataSet = $em->getRepository('MTConnectBundle:DataSet')->findByColeta($coleta_id);

        return $this->render('MTConnectBundle:DataSet:analize.html.twig',array(
            'coleta'    => $coleta,
            'data'      => $dataSet
        ));
    }


}


