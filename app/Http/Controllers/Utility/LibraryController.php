<?php

namespace App\Http\Controllers\Utility;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Config;
use Schema;

class LibraryController extends Controller {

    static function getFileVersion() {
        try {
            $app = Config::get('app.version');
            if ($app) {
                return preg_replace("/[^0-9,.]/", "", $app);
            } else {
                return 0;
            }
        } catch (Exception $ex) {
            return 0;
        }
    }

    static function getDatabaseVersion() {
        try {
            $database = self::isDatabaseSetup();
            if ($database == true) {
                if (Schema::hasColumn('settings_system', 'version')) {
                    return \DB::table('settings_system')->where('id', '=', '1')->first()->version;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        } catch (Exception $ex) {
            return 0;
        }
    }

    public static function isDatabaseSetup() {
        try {
            if (Schema::hasTable('settings_system')) {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    static function encryptByFaveoPublicKey($plaintext) {
        try {
            // Compress the data to be sent
            $plaintext = gzcompress($plaintext);

            // Get the public Key of the recipient
            $path = storage_path('app/faveo-public.key');
            $key_content = file_get_contents($path);
            
            //dd($path);
            $publicKey = openssl_pkey_get_public($key_content);
            //dd($publicKey);
            $a_key = openssl_pkey_get_details($publicKey);

            // Encrypt the data in small chunks and then combine and send it.
            $chunkSize = ceil($a_key['bits'] / 8) - 11;
            $output = '';

            while ($plaintext) {
                $chunk = substr($plaintext, 0, $chunkSize);
                $plaintext = substr($plaintext, $chunkSize);
                $encrypted = '';
                if (!openssl_public_encrypt($chunk, $encrypted, $publicKey)) {
                    throw new Exception('Failed to encrypt data');
                }
                $output .= $encrypted;
            }
            openssl_free_key($publicKey);

            // This is the final encrypted data to be sent to the recipient
            $encrypted = $output;
            return $encrypted;
        } catch (Exception $ex) {
            dd($ex);
        }
    }
    public static function decryptByFaveoPrivateKey($encrypted) {
        try {
            //$encrypted = p¥Ùn¿olÓ¥9)OÞÝ¸Ôvh§=Ìtt1rkC‰É§%YœfÐS\BâkHW€mùÌØg¹+VŠ¥²?áÙ{/<¶¡£e¡ˆr°(V)Öíàr„Ž]K9¤ÿÖ¡Åmž”üÈoò×´î¢“µºŽ06¼e€rœ['4çhH¾ö:¨œ–S„œ¦,|¤ÇqÂrÈŸd+ml‡ uötÏ†ûóŽ&›áyÙ(ÆŒÁ$‘¥±Zj*îàÒöL‘ˆD†aÉö_§è¶°·V„Þú]%ÅR*B=žéršæñ*i+á­±èç|c¹ÑßŸ­F$;
            // Get the private Key
            $path = storage_path('app/faveo-private.key');
            $key_content = file_get_contents($path);
            if (!$privateKey = openssl_pkey_get_private($key_content)) {
                die('Private Key failed');
            }
            $a_key = openssl_pkey_get_details($privateKey);

            // Decrypt the data in the small chunks
            $chunkSize = ceil($a_key['bits'] / 8);
            $output = '';

            while ($encrypted) {
                $chunk = substr($encrypted, 0, $chunkSize);
                $encrypted = substr($encrypted, $chunkSize);
                $decrypted = '';
                if (!openssl_private_decrypt($chunk, $decrypted, $privateKey)) {
                    die('Failed to decrypt data');
                }
                $output .= $decrypted;
            }
            openssl_free_key($privateKey);

            // Uncompress the unencrypted data.
            $output = gzuncompress($output);

            echo '<br /><br /> Unencrypted Data: ' . $output;
        } catch (Exception $ex) {
            dd($ex);
        }
    }

}
