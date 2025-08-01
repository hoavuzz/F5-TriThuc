<style>
    .dangky form {
        background-color: #fff;
        display: flex;
        flex-direction: column;
        padding: 0 50px;
        height: 100%;
        justify-content: center;
    }

    .dangky .form-group {
        margin-bottom: 15px;
        text-align: left;
    }

    .dangky label {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
        color: #333;
    }

    .dangky input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ccc;
        border-radius: 20px;
        background-color: #f2f2f2;
        font-size: 14px;
        transition: 0.3s ease;
        outline: none;
    }

    .dangky input:focus {
        border-color: #4CAF50;
        background-color: #fff;
    }

    .dangky form button {
        margin-top: 10px;
    }

    .dangky {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 70vh;
        margin: 0;
        background: #f6f5f7;
        font-family: 'Montserrat', sans-serif;

    }

    .dangky .container {
        position: relative;
        width: 768px;
        max-width: 100%;
        min-height: 480px;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
    }

    .dangky .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
    }

    .dangky .sign-in-container {
        left: 0;
        width: 50%;
        z-index: 2;
    }

    .dangky .sign-up-container {
        left: 0;
        width: 50%;
        opacity: 0;
        z-index: 1;
    }

    .dangky .overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: transform 0.6s ease-in-out;
        z-index: 100;
    }

    .dangky .overlay {
        background: #FF416C;
        background: linear-gradient(to right, #FF4B2B, #FF416C);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: 0 0;
        color: #FFFFFF;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .dangky .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 40px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .dangky .overlay-left {
        transform: translateX(-20%);
    }

    .dangky .overlay-right {
        right: 0;
        transform: translateX(0);
    }

    .dangky .container.right-panel-active .sign-in-container {
        transform: translateX(100%);
    }

    .dangky .container.right-panel-active .sign-up-container {
        transform: translateX(100%);
        opacity: 1;
        z-index: 5;
    }

    .dangky .container.right-panel-active .overlay-container {
        transform: translateX(-100%);
    }

    .dangky .container.right-panel-active .overlay {
        transform: translateX(50%);
    }

    .dangky .container.right-panel-active .overlay-left {
        transform: translateX(0);
    }

    .dangky .container.right-panel-active .overlay-right {
        transform: translateX(20%);
    }

    button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 12px 24px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    button:hover {
        background-color: #45a049;
        transform: scale(1.05);
    }

    button:active {
        background-color: #3e8e41;
        transform: scale(0.98);
    }


    button.ghost {
        background: transparent;
        border: 2px solid white;
        color: white;
    }

    button.ghost:hover {
        background-color: white;
        color: #4CAF50;
    }
</style>
<div class="dangky">
    <div class="container right-panel-active" id="container">
        <!-- FORM ĐĂNG KÝ -->
        <div class="form-container sign-up-container">
            <form id="registerForm" action="index.php?mod=user&act=registerStudent" method="post">
                <?php if (!empty($error)): ?>
                    <div style="color: red; text-align: center; margin-bottom: 10px;"><?php echo $error; ?></div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="username">Tên đăng nhập:</label>
                    <input type="text" id="username" name="username" required value="<?php echo $_POST['username'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required value="<?php echo $_POST['email'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="text" id="phone" name="phone" value="<?php echo $_POST['phone'] ?? ''; ?>">
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_Password">Xác nhận mật khẩu:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <div class="form-group">
                    <button type="submit">Đăng ký</button>
                </div>
            </form>
        </div>

        <!-- FORM ĐĂNG NHẬP -->
        <div class="form-container sign-in-container">
            <form id="loginForm" action="index.php?mod=user&act=loginStudent" method="POST">
                <?php if (!empty($errorLogin)): ?>
                    <div style="color: red; text-align: center; margin-bottom: 10px;"><?php echo $errorLogin; ?></div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" required value="<?php echo $_POST['email'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label for="Pass">Mật khẩu:</label>
                    <input type="password" name="Pass" id="Pass" required>
                </div>
                <div class="form-group">
                    <button type="submit">Đăng nhập</button>
                </div>
            </form>
        </div>

        <!-- PHẦN GIAO DIỆN CHUYỂN ĐỔI -->
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Chào bạn !</h1>
                    <p>Nếu đã có tài khoản, hãy đăng nhập nhé!</p>
                    <button class="ghost" id="signIn">Đăng nhập</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Xin chào, bạn thân!</h1>
                    <p>Chưa có tài khoản? Hãy đăng ký nào!</p>
                    <button class="ghost" id="signUp">Đăng ký</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT CHUYỂN FORM -->
<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton?.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton?.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
</script>