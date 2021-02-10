<?php require_once ROOT . '/../App/Views/static/header.php'?>
<section class="hero text-center">
    <div class="container">
        <div class="hero__inner row justify-content-center position-relative">
            <div class="col-lg-8">
                <h1 class="hero__title mb-3">Website for registration of abiturients</h1>
                <h2 class="hero__description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad cupiditate
                    deleniti doloremque excepturi odit saepe sapiente, sint totam velit voluptatem. Accusamus, animi,
                    distinctio! Delectus neque perferendis rem, unde voluptas voluptates!</h2>
            </div>
        </div>
    </div>
</section>

<section class="students text-center my-5">
    <div class="container">
        <h3 class="students__title">List of abiturients</h3>
        <table class="students__table table table-bordered my-4">
            <thead class="table-dark">
            <tr>
                <td>#</td>
                <td><a href="" class="thead__link">First name</a></td>
                <td><a href="" class="thead__link">Last name</a></td>
                <td><a href="" class="thead__link">Group number</a></td>
                <td><a href="" class="thead__link">Score</a></td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>Ivan</td>
                <td>Ivanov</td>
                <td>0012</td>
                <td>250</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Sidr</td>
                <td>Sidorov</td>
                <td>1010Э</td>
                <td>180</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Petr</td>
                <td>Petrov</td>
                <td>132М</td>
                <td>220</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Vasya</td>
                <td>Pupkin</td>
                <td>150ЗМ</td>
                <td>292</td>
            </tr>
            </tbody>
        </table>
    </div>
</section>

<div class="pagination">
    <div class="container">
        <nav aria-label="Pagination">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a href="" class="page-link" aria-label="First" aria-disabled="true">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item active"><a href="" class="page-link">1</a></li>
                <li class="page-item"><a href="" class="page-link">2</a></li>
                <li class="page-item"><a href="" class="page-link">3</a></li>
                <li class="page-item"><a href="" class="page-link">4</a></li>
                <li class="page-item"><a href="" class="page-link">5</a></li>
                <li class="page-item">
                    <a href="" class="page-link" aria-label="Last">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<script src="js/bootstrap/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>