<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DataCollector extends Controller
{
    public function collect()
    {
        ini_set('max_execution_time', 3000);
        ini_set('memory_limit', '-1');
        $directory = 'fcs_regions/Kaliningradskaja_obl/notifications/currMonth';
        $file_list = Storage::disk('ftp')->allFiles($directory);
        if($file_list != null) {
            foreach ($file_list as $key => $value) {
                Storage::disk('public')->put('/notifications/' . str_replace($directory . '/', "", $value), Storage::disk('ftp')->get($value));
                $zip = new \ZipArchive();
                $path = storage_path() . '/app/public/notifications/' . str_replace($directory . '/', "", $value);
                if ($zip->open($path, \ZipArchive::CREATE) == true) {
                    $zip->extractTo(storage_path() . '/app/public/notifications/unpacked');
                    $zip->close();
                }
            }
            print ('Files from ftp server is downloaded and unpacked');
        } else {
            print ('ERROR: Files or directory on ftp server not found');
        }
        $file_list = Storage::disk('public')->allFiles('/notifications/unpacked');
        $id = 0;
        $nsarray = [];
        for ($i = 0; $i <= 20; $i++) {
            $nsarray[$i] = 'ns' . $i . ':';
        }
        if($file_list != null) {
            foreach ($file_list as $key => $value) {
                if (str_contains($value, '.xml') == true & str_contains($value, '.zip') == false) {
                    $xml_string = str_ireplace($nsarray, "", file_get_contents(storage_path() . '/app/public/' . $value));
                    $xml = simplexml_load_string($xml_string);
                    $json = json_encode($xml);
                    $id++;
                    $date = new \DateTime();
                    DB::insert('insert into testapis (id, "jsonData", created_at) values (?, ?, ?)', [$id, $json, $date]);
                }
            }
            print ('XML files parsed and stored into database');
        } else {
            print ('ERROR: XML files not found');
        }
    }
}
