# google2fa

# install
composer require aventusgroup/google2fa

# usage
1. Для каждого пользователя необходимо создать и сохранить ключ(он потребуется для проверки кода).
2. $secret = TwoFactor::generateSecretKey(); // string(16)
3. Генерируем Qr код для пользователя (в метод передаём ранее созданный ключ, а так же название компании и имя пользователя, которые будут отображаться в приложении аутентификации) 
4. $qrContent = TwoFactor::generateQr($secret, 'CompanyName', 'UserName'); //base64 контент изображения
5. показываем картинку <img src="data:image/png;base64,{$qrContent}">
5. Скачиваем приложение для телефона (android https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en, ios https://apps.apple.com/us/app/google-authenticator/id388497605)
6. В приложении жмём +, добавить через qr
7. Приложение будет генерировать код из 6 цифр, которые будут действовать 60 секунд
8. Каждый раз когда пользователь будет авторизироваться, необходимо принимать этот код и проверять его 
9. TwoFactor::checkCode($code, $secret) // где $code это код из приложения клиента, $secret это сохранённый для клиента ключ. True в случае правильного кода. False  в случае неправильного кода