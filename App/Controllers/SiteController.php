<?php

namespace App\Controllers;

use App\Components\Exceptions\AuthorizationStudentException;
use App\Components\Exceptions\ContainerException;
use App\Components\Exceptions\FileNotExistException;
use App\Components\Exceptions\NotFoundException;
use App\Components\Pagination;
use App\Models\Student;
use App\Models\StudentData;

class SiteController extends Controller
{
    /**
     * Main page
     * @throws ContainerException
     * @throws NotFoundException|\ValueError in Pagination
     * @throws FileNotExistException in show()
     */
    public function actionIndex()
    {
        $request = $this->container->get('request');
        $studentGateway = $this->container->get('StudentTableGateway');
        $sorting = $this->container->get('sorting');
        $pagination = new Pagination(
            $request->getRequestBody('page', 1),
            $studentGateway->getTotalStudents(),
            $studentGateway->getOutputRows(),
            $this->container->get('LinkHelper')
        );
        $students = $studentGateway->getAll(
            $sorting->getSortKey(),
            $sorting->getSortType(),
            $pagination->getOffset()
        );

        $this->show('index', [
            'title' => 'Student list',
            'navbar' => $this->container->get('navbar'),
            'students' => $students,
            'sorting' => $sorting,
            'notify' => $request->getRequestBody('notification'),
            'auth' => $this->container->get('AuthorizationStudent')->isAuthorize(),
            'pagination' => $pagination
        ]);
    }

    /**
     * Form page
     * @throws ContainerException
     * @throws FileNotExistException in show
     * @throws AuthorizationStudentException in authorizeStudent()
     */
    public function actionForm()
    {
        $request = $this->container->get('request');
        $authorization = $this->container->get('AuthorizationStudent');
        $studentGateway = $this->container->get('StudentTableGateway');

        $student = ($authorization->isAuthorize()) ?
            $studentGateway->getByToken($authorization->getAuthToken()) : new Student();
        $studentData = new StudentData($student);

        $csrfProtection = $this->container->get('csrf');
        $csrfProtection->setCsrfToken();
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $csrfProtection->validate($request);
            try {
                $studentData->fill($request->getRequestBody());
                $student->token = $authorization->getAuthToken();

                $errors = $this->container->get('StudentValidator')->validate($student);
                if (count($errors) === 0) {
                    $studentGateway->save($student);
                    $authorization->authorizeStudent($student);

                    header('Location:' . $this->container->get('LinkHelper')->getNotifyLink(
                        ($authorization->isAuthorize()) ? 'edited' : 'added',
                        $authorization->getAuthToken()
                    ));

                    return;
                }
            } catch (\TypeError $error) {
                $errors['type_error'] = true;
            }
        }

        $this->show('form', [
            'title' => ($authorization->isAuthorize()) ? 'Edit information' : 'Add yourself',
            'navbar' => $this->container->get('navbar'),
            'student' => $student,
            'errors' => $errors,
            'token' => $csrfProtection->getCsrfToken(),
            'auth' => $authorization->isAuthorize()
        ]);
    }

    /**
     * Search results page
     * @throws ContainerException
     * @throws NotFoundException|\ValueError in Pagination
     * @throws FileNotExistException in show()
     */
    public function actionSearch()
    {
        $request = $this->container->get('request');
        $searchQuery = trim(strval($request->getRequestBody('search')));
        if (strlen($searchQuery) === 0) {
            header('Location:' . $this->container->get('LinkHelper')->getNotifyLink('danger'));

            return;
        }

        $studentGateway = $this->container->get('StudentTableGateway');
        $sorting = $this->container->get('sorting');
        $pagination = new Pagination(
            $request->getRequestBody('page', 1),
            $studentGateway->getTotalStudents($searchQuery),
            $studentGateway->getOutputRows(),
            $this->container->get('LinkHelper')
        );
        $students = $studentGateway->search(
            $searchQuery,
            $sorting->getSortKey(),
            $sorting->getSortType(),
            $pagination->getOffset()
        );

        $this->show('search', [
            'title' => 'Search results',
            'navbar' => $this->container->get('navbar'),
            'students' => $students,
            'searchQuery' => $searchQuery,
            'sorting' => $sorting,
            'auth' => $this->container->get('AuthorizationStudent')->isAuthorize(),
            'pagination' => $pagination
        ]);
    }
}
