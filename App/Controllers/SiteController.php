<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

namespace App\Controllers;

use App\Components\Exceptions\AuthorizationStudentException;
use App\Components\Exceptions\ContainerException;
use App\Components\Exceptions\FileNotExistException;
use App\Components\Exceptions\NotFoundException;
use App\Components\Helpers\LinkHelper;
use App\Components\Helpers\SortingHelper;
use App\Components\Navbar;
use App\Components\Pagination;
use App\Components\Request;
use App\Components\Response;
use App\Models\Student;
use App\Models\StudentData;

class SiteController extends Controller
{
    /**
     * Limit on the number of students to output
     * @var int
     */
    private int $limitStudents = 10;

    /**
     * Main page
     * @param Request $request
     * @return Response
     * @throws ContainerException
     * @throws FileNotExistException in show()
     * @throws NotFoundException|\ValueError in Pagination
     */
    public function actionIndex(Request $request): Response
    {
        $studentGateway = $this->container->get('StudentTableGateway');
        $link = new LinkHelper($request);
        $sorting = new SortingHelper($request, $link, 'score', 'desc');
        $pagination = new Pagination(
            $request->getRequestBody('page', 1),
            $studentGateway->getTotalStudents(),
            $this->limitStudents,
            $link
        );
        $students = $studentGateway->getAll(
            $sorting->getSortKey(),
            $sorting->getSortType(),
            $this->limitStudents,
            $pagination->getOffset()
        );

        return $this->show('index', [
            'title' => 'Student list',
            'navbar' => new Navbar($request),
            'students' => $students,
            'sorting' => $sorting,
            'notify' => $request->getRequestBody('notification'),
            'auth' => $this->container->get('AuthorizationStudent')->isAuthorize(),
            'pagination' => $pagination
        ]);
    }

    /**
     * Form page
     * @param Request $request
     * @return Response
     * @throws ContainerException
     * @throws FileNotExistException in show
     * @throws AuthorizationStudentException in authorizeStudent()
     */
    public function actionForm(Request $request): Response
    {
        $authorization = $this->container->get('AuthorizationStudent');
        $studentGateway = $this->container->get('StudentTableGateway');

        $student = ($authorization->isAuthorize()) ?
            $studentGateway->getByToken($authorization->getAuthToken()) : new Student();
        $studentData = new StudentData($student);

        $csrfProtection = $this->container->get('csrf');
        $csrfProtection->setCsrfToken();
        $errors = [];

        if ($request->isPost()) {
            $csrfProtection->validate($request);
            try {
                $studentData->fill($request->getRequestBody());
                $student->token = $authorization->getAuthToken();

                $errors = $this->container->get('StudentValidator')->validate($student);
                if (count($errors) === 0) {
                    $studentGateway->save($student);
                    $authorization->authorizeStudent($student);
                    $link = new LinkHelper($request);

                    return $this->response->withHeader(
                        'Location',
                        $link->getNotifyLink(
                            ($authorization->isAuthorize()) ? 'edited' : 'added',
                            $authorization->getAuthToken()
                        )
                    );
                }
            } catch (\TypeError $error) {
                $errors['type_error'] = true;
            }
        }

        return $this->show('form', [
            'title' => ($authorization->isAuthorize()) ? 'Edit information' : 'Add yourself',
            'navbar' => new Navbar($request),
            'student' => $student,
            'errors' => $errors,
            'token' => $csrfProtection->getCsrfToken(),
            'auth' => $authorization->isAuthorize()
        ]);
    }

    /**
     * Search results page
     * @param Request $request
     * @return Response
     * @throws ContainerException
     * @throws NotFoundException|\ValueError in Pagination
     * @throws FileNotExistException in show()
     */
    public function actionSearch(Request $request): Response
    {
        $searchQuery = trim(strval($request->getRequestBody('search')));
        $link = new LinkHelper($request);
        if (strlen($searchQuery) === 0) {
            return $this->response->withHeader(
                'Location',
                $link->getNotifyLink('danger')
            );
        }

        $studentGateway = $this->container->get('StudentTableGateway');
        $sorting = new SortingHelper($request, $link, 'score', 'desc');
        $pagination = new Pagination(
            $request->getRequestBody('page', 1),
            $studentGateway->getTotalStudents($searchQuery),
            $this->limitStudents,
            $link
        );
        $students = $studentGateway->search(
            $searchQuery,
            $sorting->getSortKey(),
            $sorting->getSortType(),
            $this->limitStudents,
            $pagination->getOffset()
        );

        return $this->show('search', [
            'title' => 'Search results',
            'navbar' => new Navbar($request),
            'students' => $students,
            'searchQuery' => $searchQuery,
            'sorting' => $sorting,
            'auth' => $this->container->get('AuthorizationStudent')->isAuthorize(),
            'pagination' => $pagination
        ]);
    }
}
