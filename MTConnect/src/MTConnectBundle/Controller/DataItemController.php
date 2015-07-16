<?php

namespace MTConnectBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MTConnectBundle\Entity\DataItem;
use MTConnectBundle\Form\DataItemType;

/**
 * DataItem controller.
 *
 */
class DataItemController extends Controller
{

    /**
     * Lists all DataItem entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MTConnectBundle:DataItem')->findAll();

        return $this->render('MTConnectBundle:DataItem:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new DataItem entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new DataItem();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('dataitem_show', array('id' => $entity->getId())));
        }

        return $this->render('MTConnectBundle:DataItem:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a DataItem entity.
     *
     * @param DataItem $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(DataItem $entity)
    {
        $form = $this->createForm(new DataItemType(), $entity, array(
            'action' => $this->generateUrl('dataitem_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new DataItem entity.
     *
     */
    public function newAction()
    {
        $entity = new DataItem();
        $form   = $this->createCreateForm($entity);

        return $this->render('MTConnectBundle:DataItem:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DataItem entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MTConnectBundle:DataItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DataItem entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MTConnectBundle:DataItem:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DataItem entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MTConnectBundle:DataItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DataItem entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MTConnectBundle:DataItem:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a DataItem entity.
    *
    * @param DataItem $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(DataItem $entity)
    {
        $form = $this->createForm(new DataItemType(), $entity, array(
            'action' => $this->generateUrl('dataitem_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing DataItem entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MTConnectBundle:DataItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find DataItem entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('dataitem_edit', array('id' => $id)));
        }

        return $this->render('MTConnectBundle:DataItem:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a DataItem entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MTConnectBundle:DataItem')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find DataItem entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('dataitem'));
    }

    /**
     * Creates a form to delete a DataItem entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dataitem_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
