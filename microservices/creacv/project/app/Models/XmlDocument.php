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

    function iterateNode(SimpleXMLElement $node, string &$content)
    {
        while ($node->hasChildren()) {
            $content.=$node->getName();
            $node->next();
        }
        return $content;
    }
    function readXml(): string
    {
        $content = '';
        if (isset($this->xml)) {
            $xml = $this->xml;
            $array=json_decode(json_encode((array) $xml),true);//$this->iterateNode($xml, $content);
            return implode("\n", (Array) $array);
        } else {
            return "xml object not found";
        }
    }
}


