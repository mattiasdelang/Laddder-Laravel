@servers(['production' => 'deploybot@139.162.148.185'])

@task('deploy', ['on' => 'production'])
    cd /home/laddder.be/
    php artisan down
    git reset --hard HEAD
    git pull origin master
    composer dump-autoload
    php artisan migrate --force
    php artisan up
@endtask
