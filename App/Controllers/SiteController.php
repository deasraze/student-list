<?php

namespace App\Controllers;

use App\Components\Pagination;
use App\Models\Student;
use App\Models\StudentData;

class SiteController extends Controller
{
    /**
     * Main page
     * @throws \Exception
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
     * @throws \Exception
     */
    public function actionForm()
    {
        $authorization = $this->container->get('AuthorizationStudent');
        $studentGateway = $this->container->get('StudentTableGateway');

        $student = ($authorization->isAuthorize()) ?
            $studentGateway->getByToken($authorization->getAuthToken()) : new Student();
        $studentData = new StudentData($student);

        $csrfProtection = $this->container->get('csrf');
        $csrfProtection->setCsrfToken();
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $csrfProtection->validate($this->container->get('request'));
            try {
                $studentData->fill($this->container->get('request')->getRequestBody());
                $student->token = $authorization->getAuthToken();

                $errors = $this->container->get('StudentValidator')->validate($student);
                if (count($errors) === 0) {
                    $studentGateway->save($student);
                    $authorization->authorizeStudent($student);

                    header('Location:' . $this->container->get('LinkHelper')->getNotifyLink(
                        $authorization->isAuthorize(),
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
     * @throws \Exception
     */
    public function actionSearch()
    {
        $studentGateway = $this->container->get('StudentTableGateway');
        $searchQuery = trim(strval($this->container->get('request')->getRequestBody('search')));
        $sorting = [
            'key'  => $this->container->get('request')->getRequestBody('key', 'score'),
            'sort' => $this->container->get('request')->getRequestBody('sort', 'desc'),
        ];
        $pagination = new Pagination(
            $this->container->get('request')->getRequestBody('page', 1),
            $studentGateway->getTotalStudents($searchQuery),
            $studentGateway->getOutputRows(),
            $this->container->get('LinkHelper')
        );
        $students = $studentGateway->search(
            $searchQuery,
            $sorting['key'],
            $sorting['sort'],
            $pagination->getOffset()
        );

        $this->show('search', [
            'title' => 'Search results',
            'navbar' => $this->container->get('navbar'),
            'students' => $students,
            'searchQuery' => $searchQuery,
            'sorting' => $sorting,
            'link' => $this->container->get('LinkHelper'),
            'auth' => $this->container->get('AuthorizationStudent')->isAuthorize(),
            'pagination' => $pagination
        ]);
    }
}
