## Modalbum
Modalbum includes everything you need to lunch a Live Streaming, Video Streaming and Image Sharing platform.  Its based on laravel 10 PHP framework.

### Requirement
- [**PHP**](https://php.net) 5.6.4+ (**7+** preferred)
- PHP Extensions: openssl, mcrypt, mbstring, phpredis and php-zip
- Database server: [MySQL](https://www.mysql.com) or [**MariaDB**](https://mariadb.org)
- [Redis](http://redis.io) Server
- [Composer](https://getcomposer.org)
- [Node.js](https://nodejs.org/) with npm
- [FFMpeg](https://ffmpeg.org/)
- [mediainfo](https://mediaarea.net/en/MediaInfo)
- [transmission](https://transmissionbt.com/)

### Installation
* Install some packages `sudo apt-get install ffmpeg mediainfo transmission-cli`
* clone the repository: `git clone https://github.com/davymaish/modalbum.git`
* create a database
* create configuration env file `.env` refer to `.env.example`
* install: `composer install --no-dev`
* setup database tables: `php artisan migrate`

### Configuration

#### Image Storage Location
There are 3 locations you can configure using **APP_STORAGE** option in the **.env** file
* ```APP_STORAGE=local``` : store image only in your local storage
* ```APP_STORAGE=localcloud``` : store image in the cloud and keep a local cache
* ```APP_STORAGE=cloud``` : store image only in the cloud

#### Setup Admin Account
```bash
php artisan tinker
```
```php
DB::table('users')->where('id', 2)->update(['email'=>'myemail@example.com']);
```
Click on **forgot password** link on the **login page** and reset password for your admin user.

#### Setup Cron Job
```bash
crontab -e -u www-data
```
```bash
* * * * * php /home/web/modalbum/artisan schedule:run >/dev/null 2>&1
*/5 * * * * php /home/web/modalbum/artisan auth:clear-resets >/dev/null 2>&1
```
#### Setup Supervisor
```bash
nano /etc/supervisor/conf.d/modalbum.conf
```
```bash
[program:modalbum-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /home/web/modalbum/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
```

#### Setup Google ReCaptcha
Visit https://www.google.com/recaptcha/admin and register your site

Get **Site key** and **Secret key**, add them in your .env file
```$xslt
...
## Site Key
GOOGLE_RECAPTCHA_SITE=''
## Secret Key
GOOGLE_RECAPTCHA_SECRET=''
...
```
## Contributing

Contributions are welcome! If you find any bugs or have suggestions for improvements, please open an issue or submit a pull request.

## Security Vulnerabilities

If you discover a security vulnerability within this project, please send an e-mail to me via [davymaish6@gmail.com](mailto:davymaish6@gmail.com). All security vulnerabilities will be promptly addressed.

## License

This project is licensed under the [MIT License](LICENSE).

## Contact

For any inquiries or feedback, feel free to contact me via:

- Website: [davymaish.github.io](https://davymaish.github.io)
- Email: [davymaish6@gmail.com](mailto:davymaish6@gmail.com)