<?php 
require "db.php";
$data = $_POST;
if( isset($data['do_signup']) )
{//тут регистрируем 
    if(trim($data['login'])=='' )
    {
        $errors[]='Введите логин';
    }
    if(trim($data['email'])=='' )
    {
        $errors[]='Введите email';
    }
    if(($data['password'])=='' )
    {
        $errors[]='Введите пароль';
    }
    if(($data['password_2'])!= $data['password'] )
    {
        $errors[]='введеные пароли не совпадают!';
    }

    //проверка на повторный логни/пароль
    if(R::count('users', "login = ?", array($data['login'])) > 0  )
    {
        $errors[]='пользователь с таким логином уже существует';
    }
    if(R::count('users', "email = ?", array($data['email'])) > 0  )
    {
        $errors[]='пользователь с таким Email уже существует';
    }
    if (empty($errors)){
        //все хорошо можно зарегистрировать
       $user=R::dispense('users');
       $user->login = $data['login'];
       $user->email = $data['email'];
       $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
       R::store($user);
       echo '<div style="color:green;">Вы успешно зарегистрировались</div><hr>';

    } else 
    {
        echo '<div style="color:red;">'.array_shift($errors).'</div><hr>';
    }
}
?>
<form action="signup.php" method="POST">
    <p>
        <p><strong>Ваш логин:</strong></p>
        <input type="text" name="login" value="<?php echo @$data['login'];?>">
    </p>

    <p>
         <p><strong>Ваш email:</strong></p>
        <input type="email" name="email" value="<?php echo @$data['email'];?>">
    </p>
    <p>
         <p><strong>Ваш пароль</strong></p>
        <input type="password" name="password"value="<?php echo @$data['password'];?>">
    </p>
    <p>
         <p><strong>Ввведите ва ш пароль еще раз</strong></p>
        <input type="password" name="password_2"value="<?php echo @$data['password_2'];?>">
    </p>
    <p>
    <button type="submit" name="do_signup">Зарегестрироваться</button>
    </p>
</form>