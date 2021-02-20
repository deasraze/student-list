<?php

namespace App\Controllers;

use App\Components\Helpers\AuthorizationStudent;
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
            'notification' => $this->fc->request->getRequestBody('notification')
        ]);
    }

    /**
     * Registration page
     * @throws \Exception
     */
    public function actionRegister()
    {
        $student = new Student();
        $studentData = new StudentData($student);
        $authorization = new AuthorizationStudent($student, $this->container->get('cookieHelper'));
        $csrfProtection = $this->container->get('csrf');
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $csrfProtection->validate($this->fc->request);
            try {
                $studentData->fill($this->fc->request->getRequestBody());
                $errors = $this->container->get('StudentValidator')->validate($student);

                if (empty($errors)) {
                    $authorization->setToken()->authorizeStudent();
                    $this->container->get('StudentTableGateway')->save($student);
                    header('Location: /?notification=success');

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
            'token' => $csrfProtection->setToken()
        ]);
    }
}
