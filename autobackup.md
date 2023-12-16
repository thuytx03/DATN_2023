composer require spatie/laravel-backup
php artisan vendor:publish --provider="Spatie\Backup\BackupServiceProvider"
composer require masbug/flysystem-google-drive-ext

trong env thêm
GOOGLE_DRIVE_CLIENT_ID=187724143106-gtch41vjnd6e79dapketucqolgvpq5bp.apps.googleusercontent.com
GOOGLE_DRIVE_CLIENT_SECRET=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
GOOGLE_DRIVE_REFRESH_TOKEN=1//04ipC3HuAFjuOCgYIARAAGAQSNwF-L9IrdM0hbSfK8dtMHoRR3IV32fyM1lOQuupQBrnKJPmBGKW_1MZN9Bol9Lrdo_eGS4GMh0k
GOOGLE_DRIVE_FOLDER=Backups
#GOOGLE_DRIVE_TEAM_DRIVE_ID=xxx
#GOOGLE_DRIVE_SHARED_FOLDER_ID=xxx

trong file config/filesystems.php
'google' => [
'driver' => 'google',
'clientId' => env('GOOGLE_DRIVE_CLIENT_ID'),
'clientSecret' => env('GOOGLE_DRIVE_CLIENT_SECRET'),
'refreshToken' => env('GOOGLE_DRIVE_REFRESH_TOKEN'),
'folder' => env('GOOGLE_DRIVE_FOLDER'), // without folder is root of drive or team drive
//'teamDriveId' => env('GOOGLE_DRIVE_TEAM_DRIVE_ID'),
//'sharedFolderId' => env('GOOGLE_DRIVE_SHARED_FOLDER_ID'),
],

trong Providers/AppServiceProvince.php

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

private function backupDriver()
{
try {
Storage::extend('google', function ($app, $config) {
$options = [];

                if (!empty($config['teamDriveId'] ?? null)) {
                    $options['teamDriveId'] = $config['teamDriveId'];
                }

                if (!empty($config['sharedFolderId'] ?? null)) {
                    $options['sharedFolderId'] = $config['sharedFolderId'];
                }

                $client = new \Google\Client();
                $client->setClientId($config['clientId']);
                $client->setClientSecret($config['clientSecret']);
                $client->refreshToken($config['refreshToken']);

                $service = new \Google\Service\Drive($client);
                $adapter = new \Masbug\Flysystem\GoogleDriveAdapter($service, $config['folder'] ?? '/', $options);
                $driver = new \League\Flysystem\Filesystem($adapter);

                return new \Illuminate\Filesystem\FilesystemAdapter($driver, $adapter);
            });
        } catch (\Exception $e) {
            // your exception handling logic
        }
    }
    trong hàm boot thêm dòng lệnh $this->backupDriver();

trong config/backup.php
chỗ destination/disks sửa local thành google

trong file Kernel.php thêm đoạn này
protected function schedule(Schedule $schedule)
{
// $schedule->command('inspire')->hourly();
$schedule->command('backup:clean')->daily()->at('10:02');
$schedule->command('backup:run')->daily()->at('10:05')->withoutOverlapping();
$schedule->call(function () {
info('Backup task ran successfully.');
})->daily()->at('10:10');
}
