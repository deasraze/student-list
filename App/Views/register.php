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

<div class="registration my-5">
    <div class="container">
        <h3 class="registration__title text-center">Add yourself to our list</h3>
        <form action="/register" method="post" class="row needs-validation g-3 my-3 mx-lg-5 px-lg-5" novalidate>
            <?php if (isset($errors['type_error'])): ?>
                <div class="container text-center">
                    <div class="row mx-2 justify-content-center">
                        <div class="col-md-6 alert alert-danger" role="alert">
                            Fill in all the fields of the form
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-md-6">
                <label for="inputFirstName" class="form-label">First name</label>
                <input type="text" id="inputFirstName"
                       class="form-control <?= (isset($errors['name'])) ? 'is-invalid' : '' ?>" name="name"
                       value="<?= htmlspecialchars($student->name ?? '') ?>"
                       aria-describedby="inputFirstName" required>
                <div id="inputFirstName" class="invalid-feedback">
                    The first name must be between 1 and 40 characters long and can contain letters, a space, an apostrophe and a hyphen
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputLastName" class="form-label">Last name</label>
                <input type="text" id="inputLastName"
                       class="form-control <?= (isset($errors['surname'])) ? 'is-invalid' : '' ?>" name="surname"
                       value="<?= htmlspecialchars($student->surname ?? '') ?>"
                       aria-describedby="inputLastName" required>
                <div id="inputLastName" class="invalid-feedback">
                    The last name must be between 1 and 40 characters long and can contain letters, a space, an apostrophe and a hyphen
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputByear" class="form-label">Birth year</label>
                <input type="number" min="1900" max="2004" id="inputByear"
                       class="form-control <?= (isset($errors['byear'])) ? 'is-invalid' : '' ?>"
                       value="<?= htmlspecialchars($student->byear ?? '') ?>"
                       name="byear" aria-describedby="inputByear" required>
                <div id="inputByear" class="invalid-feedback">
                    The year of birth must not be less than 1900 and more than 2004
                </div>
            </div>
            <div class="col-md-6">
                <label for="selectGender" class="form-label">Gender</label>
                <select id="selectGender"
                        class="form-select <?= (isset($errors['gender'])) ? 'is-invalid' : '' ?>" name="gender"
                        aria-describedby="selectGender" required>
                    <option selected disabled value="">Choose...</option>
                    <option <?= (isset($student->gender) && $student->gender == 'male') ? 'selected' : '' ?>
                            value="male">Male</option>
                    <option <?= (isset($student->gender) && $student->gender == 'female') ? 'selected' : '' ?>
                            value="female">Female</option>
                </select>
                <div id="selectGender" class="invalid-feedback">
                    Please select a valid gender.
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputGroupNumber" class="form-label">Group number</label>
                <input type="text" id="inputGroupNumber"
                       class="form-control <?= (isset($errors['sgroup'])) ? 'is-invalid' : '' ?>"
                       value="<?= htmlspecialchars($student->sgroup ?? '') ?>"
                       placeholder="Example: 1010Э, 132М, 00123" name="sgroup"
                       aria-describedby="inputGroupNumber" required>
                <div id="inputGroupNumber" class="invalid-feedback">
                    The group number must be between 2 and 5 characters, and can only contain letters and numbers
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputScore" class="form-label">Score</label>
                <input type="number" min="0" max="1100" id="inputScore"
                       class="form-control <?= (isset($errors['score'])) ? 'is-invalid' : '' ?>"
                       value="<?= htmlspecialchars($student->score ?? '') ?>"
                       placeholder="Total points for the Unified State Exam" name="score"
                       aria-describedby="inputScore" required>
                <div id="inputScore" class="invalid-feedback">
                    The number of points can not be less than 0 and more than 1110
                </div>
            </div>
            <div class="col-md-6">
                <label for="selectStatus" class="form-label">Status</label>
                <select id="selectStatus"
                        class="form-select <?= (isset($errors['status'])) ? 'is-invalid' : '' ?>" name="status"
                        aria-describedby="selectStatus" required>
                    <option selected disabled value="">Choose...</option>
                    <option <?= (isset($student->status) && $student->status == 'resident') ? 'selected' : '' ?>
                            value="resident">Resident</option>
                    <option <?= (isset($student->status) && $student->status == 'nonresident') ? 'selected' : '' ?>
                            value="nonresident">Nonresident</option>
                </select>
                <div id="selectStatus" class="invalid-feedback">
                    Please select a valid status.
                </div>
            </div>
            <div class="col-md-6">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="email" id="inputEmail"
                       class="form-control <?= (isset($errors['email'])) ? 'is-invalid' : '' ?>" placeholder="example@gmail.com"
                       value="<?= htmlspecialchars($student->email ?? '') ?>"
                       name="email" aria-describedby="inputEmail" required>
                <div id="inputEmail" class="invalid-feedback">
                    Invalid email or it is already occupied
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" class="registration-btn btn btn-dark px-4 mt-2">Add yourself</button>
            </div>
        </form>
    </div>
</div>
<?php require_once ROOT . '/../App/Views/static/footer.php' ?>