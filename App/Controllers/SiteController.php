<?php

namespace App\Controllers;

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
        $sorting = [
            'key'  => $this->fc->request->getRequestBody('key', 'score'),
            'sort' => $this->fc->request->getRequestBody('sort', 'desc'),
        ];
        $students = $this->container->get('StudentTableGateway')->getAll($sorting['key'], $sorting['sort']);

        $this->show('index', [
            'title' => 'Student list',
            'navbar' => $this->container->get('navbar'),
            'students' => $students,
            'link' => $this->container->get('LinkHelper'),
            'sorting' => $sorting,
            'notify' => $this->fc->request->getRequestBody('notification'),
            'auth' => $this->container->get('AuthorizationStudent')->isAuthorize()
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
            $csrfProtection->validate($this->fc->request);
            try {
                $studentData->fill($this->fc->request->getRequestBody());
                $student->token = $authorization->getAuthToken();

                $errors = $this->container->get('StudentValidator')->validate($student);
                if (count($errors) === 0) {
                    $studentGateway->save($student);
                    $authorization->authorizeStudent($student);

                    $notify = http_build_query([
                        'notification' => ($authorization->isAuthorize()) ? 'edited' : 'added',
                        'for' => $authorization->getAuthToken()
                    ]);
                    header('Location: /?' . $notify);

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
        $searchQuery = trim(strval($this->fc->request->getRequestBody('search')));
        $sorting = [
            'key'  => $this->fc->request->getRequestBody('key', 'score'),
            'sort' => $this->fc->request->getRequestBody('sort', 'desc'),
        ];

        $students = $this->container->get('StudentTableGateway')->search(
            $searchQuery,
            $sorting['key'],
            $sorting['sort']
        );

        $this->show('search', [
            'title' => 'Search results',
            'navbar' => $this->container->get('navbar'),
            'students' => $students,
            'searchQuery' => $searchQuery,
            'sorting' => $sorting,
            'link' => $this->container->get('LinkHelper'),
            'auth' => $this->container->get('AuthorizationStudent')->isAuthorize()
        ]);
    }
}
