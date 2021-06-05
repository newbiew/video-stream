<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'Video Stream');

// Project repository
set('repository', 'git@github.com:newbiew/video-stream.git');


// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', [
    'storage'
]);

set('keep_releases', 5);

// Writable dirs by web server
add('writable_dirs', [
    // 'storage/cms',
    // 'storage/cms/cache',
    // 'storage/cms/combiner',
    // 'storage/cms/twig',
    // 'storage/logs'
]);

// Hosts
host('128.199.115.80')
    ->user('deployer')
    ->stage('staging')
    ->identityFile('c:/Users/user/.ssh/deployerkey')
    ->set('env', [
        'DB_DATABASE' => 'staging-convert',
        'DB_USERNAME' => 'phpmyadminuser',
        'DB_PASSWORD' => '|q2180Lq2180'
    ])
    ->set('deploy_path', '/var/www/html/staging-convert');

// Hosts
// host('128.199.115.80')
//     ->user('deployer')
//     ->stage('production')
//     ->identityFile('c:/Users/user/.ssh/deployerkey')
//     ->set('env', [
//         'DB_DATABASE' => 'testing-deployer',
//         'DB_USERNAME' => 'phpmyadminuser',
//         'DB_PASSWORD' => '|q2180Lq2180'
//     ])
//     ->set('deploy_path', '/var/www/html/demo-arena');

// set('writable_chmod_mode', '777');
// set('writable_mode', 'chmod');
// set('writable_mode', 'chown');
// set('allow_anonymous_stats',)
set('ssh_multiplexing', false);

set('composer_options', 'install --verbose');
// set('writable_mode', 'chmod');
// set('use_relative_symlink', '0');
// Tasks
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    // 'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    // 'deploy:owner',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'artisan:storage:link',
    // 'artisan:view:cache',
    'artisan:config:cache',
    'deploy:symlink',
    'deploy:failed',
    // 'deploy:writable_dirs',
    // 'npm:install',
    // 'npm:build',
    // 'artisan:october',
    'reload:php-fpm',
    'cleanup'
]);


// task('build', function () {
//     run('cd {{release_path}} && build');
// });


// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');



// Migrate database before symlink new release.

// before('deploy:symlink', 'artisan:migrate');
task('artisan:october', function () {
    run('{{bin/php}} {{release_path}}/artisan october:up');
});


task('reload:php-fpm', function () {
    run('sudo /usr/sbin/service php7.4-fpm reload');
});

task('deploy:owner', function () {
    run('chown -R deployer:www-data /var/www/html/staging-convert');
    // $releasePath = get('release_path');
    // cd($releasePath);
    // run("chmod -R 775 /var/www/html/testing-deployer/shared/storage/logs");
    // run("chmod -R 775 /var/www/html/testing-deployer/shared/storage/framework");
});


// task('deploy:writable_dirs', function() {
//     $deployPath = get('deploy_path');
//     cd($deployPath);

//     run("chown -R deployer:www-data storage");
//     set('writable_dirs', ['storage']);
// });
