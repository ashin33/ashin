<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ZipArchive;

class explodeZip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'explode_zip';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 扫描$con目录下的所有文件
        $dir = scandir(public_path('origin'));
        //定义一个数组接收文件名
        foreach ($dir as $k => $v) {
            // 跳过两个特殊目录   continue跳出循环
            if ($v == "." || $v == "..") {
                continue;
            }
            $dir_name = $v;
        }
        $dir_ = scandir(public_path('origin/'.$dir_name.'/debts_objects'));
        $num = count($dir_)-2;

        for($i=1;$i<=$num;$i++){

            if(file_exists(public_path('result/users.csv'))){
                unlink(public_path('result/users.csv'));
            }
            copy(public_path('origin/'.$dir_name.'/users/users_'.$i.'.csv'),public_path('result/users.csv'));

            if(file_exists(public_path('result/objects.csv'))){
                unlink(public_path('result/objects.csv'));
            }
            copy(public_path('origin/'.$dir_name.'/objects/objects_'.$i.'.csv'),public_path('result/objects.csv'));

            if(file_exists(public_path('result/debts_objects.csv'))){
                unlink(public_path('result/debts_objects.csv'));
            }
            copy(public_path('origin/'.$dir_name.'/debts_objects/debts_objects_'.$i.'.csv'),public_path('result/debts_objects.csv'));


            if(file_exists(public_path('result/objects_investment.csv'))){
                unlink(public_path('result/objects_investment.csv'));
            }
            copy(public_path('origin/'.$dir_name.'/objects_investment/objects_investment_'.$i.'.csv'),public_path('result/objects_investment.csv'));


            if(file_exists(public_path('result/transactions.csv'))){
                unlink(public_path('result/transactions.csv'));
            }
            copy(public_path('origin/'.$dir_name.'/transactions/transactions_'.$i.'.csv'),public_path('result/transactions.csv'));


            if(file_exists(public_path('result/objects_change.csv'))){
                unlink(public_path('result/objects_change.csv'));
            }
            copy(public_path('origin/'.$dir_name.'/objects_change/objects_change_'.$i.'.csv'),public_path('result/objects_change.csv'));
            if(strlen($i) == 1){
                $number = '00'.$i;
            }elseif(strlen($i) == 2){
                $number = '0'.$i;
            }else{
                $number = $i;
            }
            $file_name = public_path('result').'/'.$dir_name.'-'.$number.'-106.zip';
            $this->add2Zip($file_name);
        }
        echo 'success';
        return true;
    }

    public function add2Zip($file_name)
    {
        var_dump($file_name);
        $file_list = [
            public_path('result/users.csv'),
            public_path('result/objects.csv'),
            public_path('result/debts_objects.csv'),
            public_path('result/objects_investment.csv'),
            public_path('result/transactions.csv'),
            public_path('result/objects_change.csv'),
        ];
        if (file_exists($file_name)) {//文件存在,删除重新生成
            unlink($file_name);
        }
        $zip = new ZipArchive();
        $res_ = $zip->open($file_name, ZipArchive::CREATE);
        if ($res_ == TRUE) {
            foreach ($file_list as $key => $value) {
                if (file_exists($value)) {
                    $zip->addFile($value, basename($value));
                }
            }
            $zip->close();
        }
    }



}
