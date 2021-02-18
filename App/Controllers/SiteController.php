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

        $this->show('register', [
            'title' => 'Add yourself',
            'student' => $student,
            'errors' => $errors
        ]);
    }

}