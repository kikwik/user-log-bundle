<?php

namespace Kikwik\UserLogBundle\Controller\Admin;

use Kikwik\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionLogController extends CRUDController
{
    public function show(Request $request, int $id): Response
    {
        $object = $this->getConfiguration()->getObject($id);
        if(!$object)
        {
            throw $this->createNotFoundException();
        }
        $this->checkPermission('show',$object);

        return $this->redirect($this->generateUrl('kikwik_admin_user_log_request').'?filters[sessionLogIdentifier][operator]=uguale a&filters[sessionLogIdentifier][value]='.$object->__toString());
    }

}