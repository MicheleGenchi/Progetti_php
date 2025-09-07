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

class Document
{
    use HandlerWordTrait;

    private array $sections = array();
    private int $countSection = 1;
    protected PhpWord $phpWord;

    function __construct(?String $nomefile = null)
    {
        rename($nomefile ,$nomefile.'.docx');
        $nomefile.='.docx';
        if (isset($nomefile)) {
            try {
                $objReader = IOFactory::createReader('Word2007');
                Settings::setZipClass(Settings::PCLZIP);
                $this->phpWord = $objReader->load($nomefile);
            } catch (Exception $e) {
                print_r($e->getCode() . ' -> ' . $e->getMessage());
            }
        }
    }

    function setProperties($creator = 'Michele Genchi', $title = 'PHPWord')
    {
        // Set document properties
        $properties = $this->phpWord->getDocInfo();
        $properties->setCreator($creator);
        //$properties->setCompany('File Format');
        $properties->setTitle($title);
        $properties->setDescription('File Format Developer Guide');
        $properties->setCreated(date("Y-m-d H:i:s"));
        $properties->setModified(date("Y-m-d H:i:s"));
        $properties->setSubject('PHPWord');
    }

    function settings()
    {
        Settings::setDefaultFontName('Arial');
        Settings::setDefaultFontSize(14);
    }

    function newSection()
    {
        // Create a new Section
        $sections[$this->countSection] = $this->phpWord->addSection();
        $this->countSection++;
    }

    function addText(int $count = 1, string $testo = 'prova')
    {
        // Add some text
        $this->sections[$count]->addText($testo);
    }

    function read(): String
    {
        $content = '';
        foreach ($this->phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                $content.=$this->matched_element($element);
            }
        }
        return $content;
    }

    function scrivi(String $nomefile)
    {
        $writer = IOFactory::createWriter($this->phpWord, 'Word2007'); // Or 'OOXML'
        $writer->save($nomefile);
    }

}


