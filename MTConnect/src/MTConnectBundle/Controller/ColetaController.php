<?php

namespace MTConnectBundle\Controller;

use Doctrine\Common\Util\Debug;
use DOMDocument;
use MTConnectBundle\Entity\DataItem;
use MTConnectBundle\Entity\Machine;
use RecursiveArrayIterator;
use Symfony\Component\DependencyInjection\SimpleXMLElement;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MTConnectBundle\Entity\Coleta;
use MTConnectBundle\Form\ColetaType;

/**
 * Coleta controller.
 *
 */
class ColetaController extends Controller
{

    /**
     * Lists all Coleta entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MTConnectBundle:Coleta')->findAll();

        return $this->render('MTConnectBundle:Coleta:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Coleta entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Coleta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('coleta_show', array('id' => $entity->getId())));
        }

        return $this->render('MTConnectBundle:Coleta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Coleta entity.
     *
     * @param Coleta $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Coleta $entity)
    {
        $form = $this->createForm(new ColetaType(), $entity, array(
            'action' => $this->generateUrl('coleta_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Coleta entity.
     *
     */
    public function newAction()
    {
        $entity = new Coleta();
        $form   = $this->createCreateForm($entity);

        return $this->render('MTConnectBundle:Coleta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Coleta entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MTConnectBundle:Coleta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Coleta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MTConnectBundle:Coleta:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Coleta entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MTConnectBundle:Coleta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Coleta entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MTConnectBundle:Coleta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    public function configColetaAction($id){
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MTConnectBundle:Coleta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Coleta entity.');
        }

        $parsedData = $this->parseProbe($entity->getProbe());
        return $this->render('MTConnectBundle:Coleta:config.html.twig', array(
            'parsedProbe'      => $parsedData,
            'id'               => $id,
        ));
    }

    /**
    * Creates a form to edit a Coleta entity.
    *
    * @param Coleta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Coleta $entity)
    {
        $form = $this->createForm(new ColetaType(), $entity, array(
            'action' => $this->generateUrl('coleta_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Coleta entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MTConnectBundle:Coleta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Coleta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('coleta_edit', array('id' => $id)));
        }

        return $this->render('MTConnectBundle:Coleta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Coleta entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MTConnectBundle:Coleta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Coleta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('coleta'));
    }

    /**
     * Creates a form to delete a Coleta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('coleta_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function selectAction($id){
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MTConnectBundle:Coleta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Coleta entity.');
        }

        $parsedData = $this->parseProbe($entity->getProbe());

        foreach($parsedData as $machine => $dataItem)


        return $this->render('MTConnectBundle:Coleta:select.html.twig');
    }

    private function parseProbe($probeXml){
        $xmlDoc = new DOMDocument();
        $xmlDoc->loadXML($probeXml);
        $root = $xmlDoc->documentElement;
        $output = array();

        $devices = $root->getElementsByTagName('Device');

        foreach($devices as $device){
            $machine = new Machine();
            $machine->setName($device->attributes->getNamedItem('name')->nodeValue);
            $machine->setUUID($device->attributes->getNamedItem('uuid')->nodeValue);
            $dataItems = $device->getElementsByTagName('DataItem');
            $arrayDataItems = array();
            foreach($dataItems as $dataItem){
                $dI = new DataItem();
                $dI->setName($dataItem->attributes->getNamedItem('id')->nodeValue);
                $dI->setCategory($dataItem->attributes->getNamedItem('category')->nodeValue);
                $dI->setType($dataItem->attributes->getNamedItem('type')->nodeValue);
                $arrayDataItems[] = $dI;
            }
            $output = array_merge( $output , array( $machine->getName() => array('Machine' => $machine , 'DataItems' => $arrayDataItems) ) );
        }

        return $output;
    }
}
