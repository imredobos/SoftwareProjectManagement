<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018. 06. 04.
 * Time: 19:42
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_USER')")
 */
class WorklogController extends Controller
{
    /**
     * @Route("worklogedit/{worklogId}", name="worklogedit")
     */
    public function editAction(Request $request, $worklogId=0){

    }
}