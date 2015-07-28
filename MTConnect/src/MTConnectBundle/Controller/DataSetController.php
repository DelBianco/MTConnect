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

        /**
         * TODO: Dar um jeito de não armazenar dados que não sofreram alterações usar o timestamp para verificar se o dado é novo ou antigo
         *      isso pode reduzir o tempo de gravação no banco e muito, outra solução é utilizar o sample, porém as sequencias possuem um problema
         *      se for verificado que uma sequencia é maior que outra não significa necessariamente um dado mais novo, pois quando o agent é reiniciado
         *      a contagem da sequencia zera. e não faz sentido deixar o agente rodando rumo ao infinito até explodir o valor para a sequencia, sem contar que
         *      em um ambiente como o laboratório o servidor será reiniciado por diversos motivos.
         *
         */

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
            $xmlDoc->load('http://localhost:5000/'.$machine.'/sample/');
            $xpath = new DomXpath($xmlDoc);
            foreach ($xpath->query('//*[@dataItemId]') as $rowNode) {
                if( array_search( strtoupper($rowNode->nodeName) , $types ) !== false ) {
                    $dataSet = new DataSet();
                    $dataSet->setColeta($coleta);
                    /*
                     * é deixado para pós processamento o carregamento da entidade DataItem, pois dentro do ajax é
                     * necessário agilidade de insersão e não busca
                     */
                    $dataSet->setDataItemName($rowNode->getAttribute('dataItemId'));
                    $dataSet->setSequence($rowNode->getAttribute('sequence'));
                    $dataSet->setTimestamp($rowNode->getAttribute('timestamp'));
                    $dataSet->setValue($rowNode->nodeValue);
                    $em->persist($dataSet);
                    $em->flush();
                }
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
        $em->getRepository('MTConnectBundle:DataItem')->findAll();
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


