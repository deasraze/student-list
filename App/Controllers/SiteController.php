<?php

namespace App\Controllers;

use App\Models\Student;
use App\Models\StudentData;

class SiteController extends Controller
{
    public function actionIndex()
    {
        $students = $this->container->get('StudentTableGateway')->getAll();
        $this->show('index', [
            'title' => 'Student list',
            'students' => $students
        ]);
    }

    public function actionRegister()
    {
        $student = new Student();
        $studentData = new StudentData($student);
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $studentData->fill($_POST);
                $errors = $this->container->get('StudentValidator')->validate($student);

                if (empty($errors)) {
                    $this->container->get('StudentTableGateway')->save($student);
                    header('Location: /');
                    return;
                }
            } catch (\TypeError $error) {
                $errors['type_error'] = true;
            }
        }

        $this->show('register', [
            'title' => 'Add yourself',
            'student' => $student,
            'errors' => $errors
        ]);
    }
}
