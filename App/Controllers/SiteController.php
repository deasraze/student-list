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
        $students = $this->container->get('StudentTableGateway')->getAll();
        $this->show('index', [
            'title' => 'Student list',
            'students' => $students,
            'notify' => $this->fc->request->getRequestBody('notification'),
            'auth' => $this->container->get('AuthorizationStudent')->isAuthorize()
        ]);
    }

    /**
     * Registration page
     * @throws \Exception
     */
    public function actionForm()
    {
        $authorization =$this->container->get('AuthorizationStudent');
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
                    header('Location: /?notification=added&for=' . $authorization->getAuthToken());

                    return;
                }
            } catch (\TypeError $error) {
                $errors['type_error'] = true;
            }
        }

        $this->show('register', [
            'title' => 'Add yourself',
            'student' => $student,
            'errors' => $errors,
            'token' => $csrfProtection->getCsrfToken(),
            'auth' => $authorization->isAuthorize()
        ]);
    }
}
