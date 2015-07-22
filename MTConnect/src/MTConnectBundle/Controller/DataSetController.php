<?php

namespace MTConnectBundle\Controller;


use DOMDocument;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class DataSetController extends Controller
{

    public $http = 'http://localhost:5000/sample';

    public function indexAction()
    {
        return $this->render('MTConnectBundle:DataSet:index.html.twig', array(
            ));
    }

    /**
     * @return Response
     */
    public function startAction()
    {
        return new Response( json_encode( array('Start' => true) ) );
    }

    public function parseXMLAction(){
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($this->http);

        $root = $xmlDoc->documentElement;
        $header = $root->getElementsByTagName('Header');
        $firstSequence = $header->item(0)->getAttribute('firstSequence');
        $lastSequence = $header->item(0)->getAttribute('lastSequence');

        //fazer aqui um parser que le um no preenche um dataitem e salva em um vetor
        //ao final fazer o flush
        //
        // fazer um check para quando essa função for chamada com dataitens já carregados,
        // if sequence < lastSequence
        // pensar em como armazenar a ultima sequencia, utilizar o ajax para exibir e facilitar essa passagem
        //
        //ou seja o return pode ser o lastSequece e o numero de DataItens Coletados.

        return new Response( json_encode( array('firstSequence' => $firstSequence,'lastSequence'=>$lastSequence) ) );
    }



}
