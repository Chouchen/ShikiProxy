I needed a proxy because downloading exe files is forbidden at work.

Zipped file aren't.

To use it, just enter the file's URL, choose "download now" or/and "download later"
For the first option, the download will start immediatly.
For the other one, an email will be asked, the script will send a link to the zipped file so you can download it later.
Once clicked, the link will be useless. It only works once.

To configure it, modify:

    define('BASE_URL', 'http://mywebsite.com');
in index.php

    RewriteBase /
in .htaccess

    mail('email', ...);
in FileToZipEmail.php

----------------------------------

Contact :
http://shikiryu.com/contact
