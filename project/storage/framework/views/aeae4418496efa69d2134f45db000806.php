<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Admin/Dokter - KlinikApp</title>
</head>

<body>
    <h1>Login Page</h1>
    <form action="<?php echo e(route('login.submit')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br><br>
        <button type="submit">Login</button>
    </form>
    <?php if(session('error')): ?>
        <p style="color: red;"><?php echo e(session('error')); ?></p>
    <?php endif; ?>
</body>

</html>
<?php /**PATH C:\Users\Hanvy\Documents\klinikApp\project\resources\views/login.blade.php ENDPATH**/ ?>