   # How to run the app on locally
    Step 1 : Install Guzzle HTTP library﻿
    composer require guzzlehttp/guzzle

    Step 2 : Configure SendGrid Credential
    You have to create sendgrid.com account and setting sendgrid API   key.
    MAIL_DRIVER=smtp
    MAIL_HOST=smtp.sendgrid.net
    MAIL_PORT=587
    MAIL_USERNAME={YOURUSERNAMEOFSENDGRIDACCOUNT}
    MAIL_PASSWORD={YOURPASSWORDOFSENDGRIDACCOUNT}
    MAIL_ENCRYPTION=tls
    Setp 3: Run
        php artisan serve
