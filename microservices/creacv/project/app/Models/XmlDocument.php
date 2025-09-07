<?php

namespace App\Models;

//require_once 'vendor/autoload.php'; // Include Composer's autoloader

use App\Traits\HandlerWordTrait;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use PharIo\Manifest\Extension;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\Metadata\DocInfo;
use PhpOffice\PhpWord\IOFactory;
use Exception;
use SimpleXMLElement;

class XmlDocument
{
    use HandlerWordTrait;

    private array $sections = array();
    private int $countSection = 1;
    private string $nomefile = '';
    protected SimpleXMLElement $xml;

    function __construct(?string $fileName = null)
    {
        rename($fileName, $fileName . '.xml');
        $fileName .= '.xml';
        try {
            $this->xml = simplexml_load_file($fileName);
        } catch (Exception $e) {
            echo "File non trovato o mancante";
        }
    }

    function readXml(): String
    {
        $content = '';
        if (isset($this->xml)) {
            $xml = $this->xml;
            return json_encode((array) $xml, JSON_PRETTY_PRINT);
        } else {
            return "xml object not found";
        }
    }
}


