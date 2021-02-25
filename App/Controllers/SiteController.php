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
        $students = $this->container->get('StudentTableGateway')->getAll(
            $this->fc->request->getRequestBody('key') ?: 'score',
            $this->fc->request->getRequestBody('sort') ?: 'desc'
        );

        $this->show('index', [
            'title' => 'Student list',
            'students' => $students,
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
                if (empty($errors)) {
                    $studentGateway->save($student);
                    $authorization->authorizeStudent($student);

                    $notify = ($authorization->isAuthorize()) ? 'edited' : 'added';
                    header("Location: /?notification=$notify&for={$authorization->getAuthToken()}");

                    return;
                }
            } catch (\TypeError $error) {
                $errors['type_error'] = true;
            }
        }

        $this->show('form', [
            'title' => ($authorization->isAuthorize()) ? 'Edit information' : 'Add yourself',
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
        $authorization = $this->container->get('AuthorizationStudent');
        $studentGateway = $this->container->get('StudentTableGateway');
        $searchQuery = trim(strval($this->fc->request->getRequestBody('search')));
        $students = $studentGateway->search($searchQuery);

        $this->show('search', [
            'title' => 'Search results',
            'students' => $students,
            'searchQuery' => $searchQuery,
            'auth' => $authorization->isAuthorize()
        ]);
    }
}
