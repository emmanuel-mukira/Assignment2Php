<?php
class forms{
    public function sign_up_form(){
        ?>
            <div class="row align-items-md-stretch">
            <div class="col-md-8">
                <form action="sign_up_handler.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Fullname: </label>
                        <input type="text" name="fullname" class="form-control form-control-lg" id="fullname" placeholder="Enter your name" maxlength="50" autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address: </label>
                        <input type="email" name="email" class="form-control form-control-lg" id="email" placeholder="Enter your email" maxlength="50">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username: </label>
                        <input type="text" name="username" class="form-control form-control-lg" id="username" placeholder="Enter your username" maxlength="50">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password: </label>
                        <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="Enter your password"></label>
                    </div>
                    <div class="mb-3">
                        <label for="genderId" class="form-label">Gender</label>
                        <select class="form-control" id="genderId" name="genderId">
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="roleId" class="form-label">Role</label>
                        <select class="form-control" id="roleId" name="roleId">
                            <option value="1">Admin</option>
                            <option value="2">User</option>
                        </select>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit" name="signup">Submit form</button>
                            </div>
                        </form>
                    </div>
        <?php
    }
}