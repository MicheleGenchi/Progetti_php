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
use App\Models\Document;

class XmlDocument extends Document
{
    use HandlerWordTrait;

    private array $sections = array();
    private int $countSection = 1;
    private string $nomefile = '';
    protected SimpleXMLElement $xml;
    protected PhpWord $word;

    private function xmlfromfile(String $fileName): bool|SimpleXMLElement|Array
    {
        rename($fileName, $fileName . '.xml');
        $fileName .= '.xml';
        try {
            return simplexml_load_file($fileName);
        } catch (Exception $e) {
            return ["code" => $e->getCode(), "errore" => $e->getMessage()];
        }
    }

    function readXml(String $fileName): String
    {
        $this->xml=$this->xmlfromfile($fileName);
        return (isset($this->xml))?JSON_ENCODE($xml = $this->xml, JSON_PRETTY_PRINT):"xml object not found";
    }

    private function elabora(string $text): string
    {
        $array = explode(' ', $text);
        $temptext = '';
        foreach ($array as $element) {
            $temptext.=$element;
        }
        return $temptext;
    }

    public function compilaDocumento(Array $request):String 
    {
        $fileXml=$request['file_xml'];
        $fileTemplate=$request['file_template'];
        rename($fileTemplate ,$fileTemplate.'.docx');
        $fileTemplate.='.docx';
        $errore=[];
 
        // test xml file
        if (is_array($this->xmlfromfile($fileXml))) {
            array_push($errore, $this->xml);
        } else
        {
            $this->xml=$this->xmlfromfile($fileXml);
        }


       //compila il documento con i campi dell'xml

        return "";
    }
}


